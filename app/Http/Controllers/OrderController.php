<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\LoyaltyHistory;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->is_admin) {
            // Admin dapat melihat semua order
            $orders = Order::with('user')->paginate(10);
            $orderAmount = Order::sum('total_amount');
            $loyaltyPoints = LoyaltyHistory::where(function ($query) {
                $query->where('expired_at', '>', now())
                      ->orWhereNull('expired_at');
            })
            ->sum('points_earned');
        } else {
            // Customer hanya melihat order miliknya
            $orders = Order::where('user_id', $user->id)->paginate(10);
            $orderAmount = Order::where('user_id', $user->id)->sum('total_amount');
            $loyaltyPoints = LoyaltyHistory::where('user_id', $user->id)
                ->where(function ($query) {
                    $query->where('expired_at', '>', now())
                          ->orWhereNull('expired_at');
                })
                ->sum('points_earned');
        }

        return view('orders-history', compact('orders', 'orderAmount', 'loyaltyPoints'));
    }

    public function create()
    {
        $user = auth()->user();
        $users = [];

        if ($user->is_admin) {
            $users = \App\Models\User::where('is_admin', false)->where('is_manager', false)->get();
        }

        return view('create-order-history', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:255',
            'po_number' => 'nullable|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'order_date' => 'required|date',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $userId = auth()->id();
        if (auth()->user()->is_admin && $request->has('user_id')) {
            $userId = $request->user_id;
        }

        $status = 'confirmed'; // Default untuk customer
        if (auth()->user()->is_admin) {
            $status = 'draft'; // Admin create order = draft, perlu approval manager
        }

        $order = Order::create([
            'invoice_number' => $request->invoice_number,
            'po_number' => $request->po_number,
            'total_amount' => $request->total_amount,
            'order_date' => $request->order_date,
            'user_id' => $userId,
            'status' => $status,
        ]);

        // Generate loyalty only for confirmed orders
        if ($status === 'confirmed') {
            $pointsEarned = $order->generateLoyalty();
        }

        return redirect()->route('orders-history')->with('success', 'Order created successfully.');
    }

    public function approve(Order $order)
    {
        // Only manager can approve
        if (!auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        // Only draft orders can be approved
        if ($order->status !== 'draft') {
            return redirect()->route('orders-history')->with('error', 'Order is not in draft status');
        }

        $order->update(['status' => 'confirmed']);

        // Generate loyalty points for confirmed order
        $order->generateLoyalty();

        return redirect()->route('orders-history')->with('success', 'Order approved successfully and loyalty points generated.');
    }

    public function reject(Order $order)
    {
        // Only manager can reject
        if (!auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        // Only draft orders can be rejected
        if ($order->status !== 'draft') {
            return redirect()->route('orders-history')->with('error', 'Order is not in draft status');
        }

        $order->update(['status' => 'rejected']);

        return redirect()->route('orders-history')->with('success', 'Order rejected successfully.');
    }

    public function edit(Order $order)
    {
        // Only admin (not manager) can edit orders
        if (!auth()->user()->is_admin || auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        $users = \App\Models\User::where('is_admin', false)->where('is_manager', false)->get();

        return view('edit-order-history', compact('order', 'users'));
    }

    public function update(Request $request, Order $order)
    {
        // Only admin (not manager) can update orders
        if (!auth()->user()->is_admin || auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'invoice_number' => 'required|string|max:255',
            'po_number' => 'nullable|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'order_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        $order->update([
            'invoice_number' => $request->invoice_number,
            'po_number' => $request->po_number,
            'total_amount' => $request->total_amount,
            'order_date' => $request->order_date,
            'user_id' => $request->user_id,
            'status' => 'draft',
        ]);

        return redirect()->route('orders-history')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        // Only admin (not manager) can delete orders
        if (!auth()->user()->is_admin || auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        $order->delete();

        return redirect()->route('orders-history')->with('success', 'Order deleted successfully.');
    }
}
