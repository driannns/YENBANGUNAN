<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyFormula;
use App\Models\LoyaltyHistory;
use App\Models\RedeemItem;
use App\Models\RedeemHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LoyaltyController extends Controller
{
    public function formula()
    {
        $formula = LoyaltyFormula::first(); // Assuming there's only one formula

        return view('loyalty-formula', compact('formula'));
    }

    public function log(Request $request)
    {
        // Only manager can access loyalty log
        // if (!auth()->user()->is_manager) {
        //     abort(403, 'Unauthorized');
        // }

        $query = LoyaltyHistory::with(['order', 'user']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // Search in user name
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                             ->orWhere('NIK', 'like', '%' . $search . '%');
                })
                // Search in order number
                ->orWhereHas('order', function ($orderQuery) use ($search) {
                    $orderQuery->where('invoice_number', 'like', '%' . $search . '%');
                })
                // Search in points
                ->orWhere('points_earned', 'like', '%' . $search . '%')
                // Search in created date (format: Y-m-d)
                ->orWhereDate('created_at', 'like', '%' . $search . '%');
            });
        }

        // Phone number search
        if ($request->has('phone_number') && !empty($request->phone_number)) {
            $phoneNumber = $request->phone_number;
            $query->whereHas('user', function ($userQuery) use ($phoneNumber) {
                $userQuery->where('phone_number', 'like', '%' . $phoneNumber . '%');
            });
        }

        $loyaltyHistories = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());

        // Pending redeem requests for manager review
        $redeemRequests = RedeemHistory::with(['redeemItem', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $redeemHistories = RedeemHistory::with(['redeemItem', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'redeems')
            ->appends($request->query());

        return view('loyalty-log', compact('loyaltyHistories', 'redeemRequests', 'redeemHistories'));
    }

    // public function redeem()
    // {
    //     $redeemItems = RedeemItem::where('is_active', true)->get();
    //     $userPoints = $this->getUserCurrentPoints();

    //     return view('redeem-points', compact('redeemItems', 'userPoints'));
    // }

    public function promotionProgram(Request $request){
        $loyaltyPoints = LoyaltyHistory::where('user_id', auth()->user()->id)
            ->where(function ($query) {
                $query->where('expired_at', '>', now())
                      ->orWhereNull('expired_at');
            })
            ->sum('points_earned');
        $userRedeems = RedeemHistory::with('redeemItem')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $redeemItemsQuery = RedeemItem::query();
        if (!auth()->user()->is_manager) {
            $redeemItemsQuery->where('is_active', true);
        }
        $redeemItems = $redeemItemsQuery->orderBy('created_at', 'desc')->get();

        return view('promotion-program', compact('loyaltyPoints', 'userRedeems', 'redeemItems'));
    }

    public function cancelRedeem(Request $request, $id)
    {
        $redeem = RedeemHistory::findOrFail($id);

        // only owner can cancel and only if pending
        if ($redeem->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($redeem->status !== 'pending') {
            return back()->with('error', 'Cannot cancel a processed redeem request.');
        }

        $redeem->status = 'cancelled';
        $redeem->processed_at = Carbon::now();
        $redeem->save();

        return back()->with('success', 'Redeem request cancelled.');
    }
    public function processRedeem(Request $request)
    {
        $request->validate([
            'redeem_item_id' => 'required|exists:redeem_items,id',
            'quantity' => 'required|integer|min:1',
            ]);
            
            $redeemItem = RedeemItem::findOrFail($request->redeem_item_id);
            $quantity = $request->quantity;
            $pointsRequired = $redeemItem->points_required * $quantity;
            $userPoints = $this->getUserCurrentPoints();
            
            if ($pointsRequired > $userPoints) {
                return back()->withErrors(['quantity' => 'Insufficient points. You need ' . $pointsRequired . ' points but only have ' . $userPoints . ' points.']);
                }

        // Create redeem history
        RedeemHistory::create([
            'user_id' => auth()->id(),
            'redeem_item_id' => $request->redeem_item_id,
            'quantity' => $quantity,
            'points_used' => $pointsRequired,
            'status' => 'pending',
        ]);

        return redirect()->route('loyalty.promotion-program')->with('success', 'Redeem request submitted successfully. Please wait for approval.');
    }

    public function approveRedeem(Request $request, $id)
    {
        $redeem = RedeemHistory::findOrFail($id);

        // only allow if pending
        if ($redeem->status !== 'pending') {
            return back()->with('error', 'Redeem request already processed.');
        }

        DB::transaction(function () use ($redeem) {
            $redeem->status = 'redeemed';
            $redeem->processed_at = Carbon::now();
            $redeem->save();

            // Deduct points by creating negative loyalty history
            // Use same expiry calculation as getUserCurrentPoints
            $now = Carbon::now();
            $currentYear = $now->year;
            if ($now->month <= 6) {
                $expiredDate = Carbon::create($currentYear, 6, 30)->endOfDay();
            } else {
                $expiredDate = Carbon::create($currentYear, 12, 31)->endOfDay();
            }

            \App\Models\LoyaltyHistory::create([
                'order_id' => null,
                'user_id' => $redeem->user_id,
                'points_earned' => -1 * $redeem->points_used,
                'expired_at' => $expiredDate,
                'type' => 'redeem',
            ]);
        });

        return back()->with('success', 'Redeem request approved and points deducted.');
    }

    public function rejectRedeem(Request $request, $id)
    {
        $redeem = RedeemHistory::findOrFail($id);

        if ($redeem->status !== 'pending') {
            return back()->with('error', 'Redeem request already processed.');
        }

        $redeem->status = 'rejected';
        $redeem->processed_at = Carbon::now();
        $redeem->notes = $request->input('notes', null);
        $redeem->save();

        return back()->with('success', 'Redeem request rejected.');
    }

    public function storeRedeemItem(Request $request)
    {
        if (!auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'is_active' => 'nullable|boolean',
            'image_url' => 'nullable|url|max:2048',
            'image_file' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'image_source' => 'required|in:url,file',
        ]);

        if (!empty($data['image_url']) && $request->hasFile('image_file')) {
            return back()->withErrors(['image' => 'Pilih salah satu: URL atau file.']);
        }

        $imageUrl = $data['image_url'] ?? null;
        if ($request->hasFile('image_file')) {
            if (!$request->file('image_file')->isValid()) {
                return back()->withErrors(['image' => 'File image tidak valid.']);
            }
            $path = $request->file('image_file')->storePublicly('redeem-items', 'public');
            $imageUrl = Storage::url($path);
        }

        if (!$imageUrl) {
            return back()->withErrors(['image' => 'Image wajib diisi (URL atau file).']);
        }

        RedeemItem::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'points_required' => $data['points_required'],
            'unit' => $data['unit'],
            'is_active' => (bool) ($data['is_active'] ?? false),
            'image_url' => $imageUrl,
        ]);

        return back()->with('success', 'Redeem item created.');
    }

    public function updateRedeemItem(Request $request, RedeemItem $redeemItem)
    {
        if (!auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'is_active' => 'nullable|boolean',
            'image_url' => 'nullable|url|max:2048',
            'image_file' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'image_source' => 'required|in:url,file,keep',
        ]);

        if (!empty($data['image_url']) && $request->hasFile('image_file')) {
            return back()->withErrors(['image' => 'Pilih salah satu: URL atau file.']);
        }

        $imageUrl = $redeemItem->image_url;
        if ($data['image_source'] === 'url') {
            $imageUrl = $data['image_url'] ?? null;
        } elseif ($data['image_source'] === 'file') {
            if (!$request->hasFile('image_file')) {
                return back()->withErrors(['image' => 'File image wajib diisi.']);
            }
            if (!$request->file('image_file')->isValid()) {
                return back()->withErrors(['image' => 'File image tidak valid.']);
            }
            $path = $request->file('image_file')->storePublicly('redeem-items', 'public');
            $imageUrl = Storage::url($path);
        }

        if ($data['image_source'] !== 'keep' && !$imageUrl) {
            return back()->withErrors(['image' => 'Image wajib diisi (URL atau file).']);
        }

        $redeemItem->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'points_required' => $data['points_required'],
            'unit' => $data['unit'],
            'is_active' => (bool) ($data['is_active'] ?? false),
            'image_url' => $imageUrl,
        ]);

        return back()->with('success', 'Redeem item updated.');
    }

    public function destroyRedeemItem(RedeemItem $redeemItem)
    {
        if (!auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        $redeemItem->delete();

        return back()->with('success', 'Redeem item deleted.');
    }

    private function getUserCurrentPoints()
    {
        $now = now();
        $currentYear = $now->year;

        if ($now->month <= 6) {
            $expiredDate = \Carbon\Carbon::create($currentYear, 6, 30)->endOfDay();
        } else {
            $expiredDate = \Carbon\Carbon::create($currentYear, 12, 31)->endOfDay();
        }
  
        return LoyaltyHistory::where('user_id', auth()->user()->id)
            ->where(function ($query) {
                $query->where('expired_at', '>', now())
                      ->orWhereNull('expired_at');
            })
            ->sum('points_earned');
    }
}
