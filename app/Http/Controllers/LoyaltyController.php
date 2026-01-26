<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyFormula;
use App\Models\LoyaltyHistory;
use Illuminate\Http\Request;

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

        return view('loyalty-log', compact('loyaltyHistories'));
    }
}