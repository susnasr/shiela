<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wishlistItems = Auth::user()
            ->wishlist()
            ->with(['product' => function($query) {
                $query->with('images'); // Assuming products have images
            }])
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request, Product $product)
    {
        try {
            $exists = Auth::user()->wishlist()
                ->where('product_id', $product->id)
                ->exists();

            if ($exists) {
                return back()
                    ->with('info', 'This product is already in your wishlist.');
            }

            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ]);

            return back()
                ->with('success', 'Product added to your wishlist successfully!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to add product to wishlist: ' . $e->getMessage());
        }
    }

    public function destroy($wishlistItemId)
    {
        try {
            $wishlistItem = Auth::user()->wishlist()
                ->findOrFail($wishlistItemId);

            $wishlistItem->delete();

            return back()
                ->with('success', 'Product removed from your wishlist.');

        } catch (ModelNotFoundException $e) {
            return back()
                ->with('error', 'Wishlist item not found or already removed.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to remove item from wishlist: ' . $e->getMessage());
        }
    }
}
