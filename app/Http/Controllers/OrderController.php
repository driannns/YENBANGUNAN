<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\LoyaltyHistory;
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    private function getFilteredLoyaltyPoints($userId = null)
    {
        $query = LoyaltyHistory::where(function ($query) {
                            $query->where('expired_at', '>', now())
                                ->orWhereNull('expired_at');
                        });
        $user = auth()->user();

        if (!$user->is_admin AND !$user->is_manager) {
            $query->where('user_id', $userId);
        }

        return $query->sum('points_earned');
    }
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->is_admin or $user->is_manager) {
            // Admin dapat melihat semua order
            $query = Order::with('user');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    // Search in invoice number
                    $q->where('invoice_number', 'like', '%' . $search . '%')
                    // Search in PO number
                    ->orWhere('po_number', 'like', '%' . $search . '%')
                    // Search in total amount
                    ->orWhere('total_amount', 'like', '%' . $search . '%')
                    // Search in status
                    ->orWhere('status', 'like', '%' . $search . '%')
                    // Search in customer name
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                                 ->orWhere('NIK', 'like', '%' . $search . '%');
                    })
                    // Search in created date (format: Y-m-d)
                    ->orWhereDate('created_at', 'like', '%' . $search . '%')
                    ->orWhereDate('order_date', 'like', '%' . $search . '%');
                });
            }

            $orders = $query->paginate(10)->appends($request->query());
            $orderAmount = Order::sum('total_amount');
            $loyaltyPoints = $this->getFilteredLoyaltyPoints();
        } else {
            // Customer hanya melihat order miliknya
            $query = Order::where('user_id', $user->id);

            // Search functionality for customers
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    // Search in invoice number
                    $q->where('invoice_number', 'like', '%' . $search . '%')
                    // Search in PO number
                    ->orWhere('po_number', 'like', '%' . $search . '%')
                    // Search in total amount
                    ->orWhere('total_amount', 'like', '%' . $search . '%')
                    // Search in status
                    ->orWhere('status', 'like', '%' . $search . '%')
                    // Search in created date (format: Y-m-d)
                    ->orWhereDate('created_at', 'like', '%' . $search . '%')
                    ->orWhereDate('order_date', 'like', '%' . $search . '%');
                });
            }

            $orders = $query->paginate(10)->appends($request->query());
            $orderAmount = Order::where('user_id', $user->id)->sum('total_amount');
            $loyaltyPoints = $this->getFilteredLoyaltyPoints($user->id);
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
        // Only admin (not manager) can request void
        if (!auth()->user()->is_admin || auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        if (!in_array($order->status, ['confirmed', 'draft'], true)) {
            return redirect()->route('orders-history')->with('error', 'Only confirmed or draft orders can be voided.');
        }

        $order->update(['status' => 'void_requested']);

        return redirect()->route('orders-history')->with('success', 'Void request submitted for manager approval.');
    }

    public function voidApprove(Order $order)
    {
        // Only manager can approve void
        if (!auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        if ($order->status !== 'void_requested') {
            return redirect()->route('orders-history')->with('error', 'Order is not pending void approval.');
        }

        $order->update(['status' => 'voided']);

        return redirect()->route('orders-history')->with('success', 'Order voided successfully.');
    }

    public function voidReject(Order $order)
    {
        // Only manager can reject void
        if (!auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        if ($order->status !== 'void_requested') {
            return redirect()->route('orders-history')->with('error', 'Order is not pending void approval.');
        }

        $order->update(['status' => 'confirmed']);

        return redirect()->route('orders-history')->with('success', 'Void request rejected.');
    }
}
