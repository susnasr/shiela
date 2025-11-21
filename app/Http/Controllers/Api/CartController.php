<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('cartItems.product');
        $items = $user->cartItems->map(fn($item) => [
            'cart_item_id' => $item->id,
            'product' => $item->product,
            'quantity' => $item->quantity,
            'subtotal' => $item->quantity * $item->product->price,
        ]);

        return response()->json([
            'items' => $items,
            'totals' => [
                'count' => $user->cart_count,
                'amount' => $user->cart_total,
            ]
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $request->user()->cartItems()->updateOrCreate(
            ['product_id' => $product->id],
            ['quantity' => \DB::raw('quantity + 1')]
        );

        return response()->json(['message' => 'Added to cart!']);
    }

    public function remove(Request $request, $cartItem)
    {
        $request->user()->cartItems()->findOrFail($cartItem)->delete();
        return response()->json(['message' => 'Removed']);
    }

    public function update(Request $request, $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $request->user()->cartItems()->findOrFail($cartItem)->update(['quantity' => $request->quantity]);
        return response()->json(['message' => 'Updated']);
    }
}
