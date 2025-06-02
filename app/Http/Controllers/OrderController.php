<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderStatusNotification;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function checkout(Request $request)
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $discount = session('coupon_discount', 0);
        $total = $subtotal - $discount;

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        if ($request->isMethod('get')) {
            // Display checkout form
            return view('checkout.form', compact('cartItems', 'subtotal', 'discount', 'total'));
        }

        // Handle POST request (process checkout)
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
        ]);

        $order = DB::transaction(function () use ($request, $cartItems) {
            $subtotal = $cartItems->sum(function ($item) {
                if ($item->quantity > $item->product->stock_quantity) {
                    throw new \Exception("Not enough stock for product: {$item->product->name}");
                }
                return $item->product->price * $item->quantity;
            });

            $discount = session('coupon_discount', 0);
            $total = $subtotal - $discount;

            $order = Auth::user()->orders()->create([
                'total_amount' => $total,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_address' => $request->address, // Using 'address' instead of 'shipping_address' for consistency
                'payment_method' => 'manual', // Default payment method; adjust as needed
                'status' => 'pending',
                'coupon_code' => session('coupon_code'),
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'customizations' => $item->customizations,
                ]);

                $item->product->decrement('stock_quantity', $item->quantity);
            }

            Auth::user()->cartItems()->delete();
            session()->forget(['coupon_code', 'coupon_discount']);

            return $order;
        });

        Auth::user()->notify(new OrderStatusNotification($order));

        return redirect('/dashboard')
            ->with('success', '✅ Your order has been placed successfully!');
    }
}
