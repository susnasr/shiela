<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $user = Auth::user();
            $cartItems = $user->cartItems()->with('product')->get();
            $total = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            $charge = Charge::create([
                'amount' => $total * 100, // Amount in cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment for Order from Sheila',
            ]);

            // Proceed with order creation
            $order = $user->orders()->create([
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'payment_method' => 'card',
                'status' => 'paid',
                'transaction_id' => $charge->id,
            ]);

            // Add order items and clear cart
            foreach ($cartItems as $item) {
                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            $user->cartItems()->delete();

            return redirect()->route('orders.show', $order)->with('success', 'Payment successful!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
