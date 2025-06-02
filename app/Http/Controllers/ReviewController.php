<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review = new Review();
        $review->user_id = Auth::id();
        $review->product_id = $product->id;
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->save();

        return back()->with('success', 'Review submitted successfully!');
    }
}
