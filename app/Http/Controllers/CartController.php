<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();

        // Filter out cart items where the product is null
        $cartItems = $cartItems->filter(function ($item) {
            return !is_null($item->product);
        });

        // Clean up invalid cart items from the database
        if ($cartItems->count() !== $cartItems->count()) {
            $user = Auth::user();
            $cartItems->each(function ($item) use ($user) {
                if (is_null($item->product)) {
                    CartItem::where('user_id', $user->id)
                        ->where('product_id', $item->product_id)
                        ->delete();
                }
            });
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $discount = 0;
        $discountCode = session('coupon_code');

        if ($discountCode) {
            $coupon = Coupon::where('code', $discountCode)
                ->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('expires_at', '>=', now())
                ->first();

            if ($coupon) {
                if ($coupon->discount_type == 'percentage') {
                    $discount = $subtotal * ($coupon->value / 100);
                } else {
                    $discount = $coupon->value;
                }
            }
        }

        $total = $subtotal - $discount;

        return view('cart.index', compact('cartItems', 'subtotal', 'discount', 'total'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $cartItems = Auth::user()->cartItems()->with('product')->get();
        $validCartItems = $cartItems->filter(function ($item) {
            return !is_null($item->product);
        });

        $subtotal = $validCartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('expires_at', '>=', now())
            ->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid or expired coupon code.');
        }

        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return back()->with('error', 'This coupon has reached its usage limit.');
        }

        $discount = $coupon->discount_type == 'percentage'
            ? ($subtotal * ($coupon->value / 100))
            : $coupon->value;

        session([
            'coupon_code' => $coupon->code,
            'coupon_discount' => $discount
        ]);

        return back()->with('success', 'Coupon applied successfully!');
    }

    public function add(Request $request, $id)
    {
        $request->validate([
            'size' => 'sometimes|required',
            'color' => 'sometimes|required',
            'custom_text' => 'sometimes|max:20'
        ]);

        $product = Product::findOrFail($id);
        $user = Auth::user();

        $customizations = [
            'size' => $request->size ?? null,
            'color' => $request->color ?? null,
            'custom_text' => $request->custom_text ?? null
        ];

        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->whereJsonContains('customizations', $customizations)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
            return redirect()->back()->with('info', 'Product quantity updated in cart.');
        }

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'customizations' => $customizations
        ]);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);

        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        if ($request->action === 'increase') {
            $cartItem->quantity += 1;
        } elseif ($request->action === 'decrease') {
            $cartItem->quantity -= 1;
            if ($cartItem->quantity <= 0) {
                $cartItem->delete();
                return redirect()->route('cart.index')->with('success', 'Item removed from cart');
            }
        }

        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully');
    }

    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);

        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart successfully');
    }

}
