<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderStatusNotification;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'revenue' => Order::whereNotIn('status', ['cancelled', 'pending'])
                ->sum('total_amount'),
            'customers' => User::where('is_admin', false)->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'top_products' => Product::withCount('orders')
                ->orderBy('orders_count', 'desc')
                ->take(5)
                ->get()
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(10);

        $statuses = [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function approveOrder(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->update(['status' => 'approved']);

            // Notify user
            $order->user->notify(new OrderStatusNotification($order));

            // Update product inventory
            foreach ($order->items as $item) {
                $item->product->decrement('stock', $item->quantity);
            }
        });

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order #'.$order->id.' approved successfully.');
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,shipped,delivered,cancelled'
        ]);

        $order->update($validated);

        if ($order->wasChanged('status')) {
            $order->user->notify(new OrderStatusNotification($order));
        }

        return back()->with('success', 'Order status updated.');
    }
}
