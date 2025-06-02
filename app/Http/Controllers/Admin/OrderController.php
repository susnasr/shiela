<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Notifications\OrderStatusNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->whereHas('user') // Only include orders with a valid user
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        if (!$order->user) {
            abort(404, 'Order user not found');
        }
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'carrier' => 'nullable|string|max:255',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $order->update($validated);

        $order->user->notify(new OrderStatusNotification($order));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully!');
    }

    public function destroy(Order $order)
    {
        try {
            // Start a transaction to ensure data consistency
            DB::beginTransaction();

            // Delete related order_items
            DB::table('order_items')
                ->where('order_id', $order->id)
                ->delete();

            // Hard delete the order
            $order->delete();

            // Commit the transaction
            DB::commit();

            Log::info("Order #{$order->id} deleted successfully by admin.");

            return redirect()->route('admin.orders.index')
                ->with('success', "Order #{$order->id} deleted successfully!");
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();

            Log::error("Failed to delete Order #{$order->id}: " . $e->getMessage());
            return redirect()->route('admin.orders.index')
                ->with('error', "Failed to delete Order #{$order->id}: " . $e->getMessage());
        }
    }
}
