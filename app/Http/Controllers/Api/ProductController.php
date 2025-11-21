<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('category')->where('status', 'published')->latest()->get();
    }

    public function show(Product $product)
    {
        if ($product->status !== 'published') abort(404);
        $product->load('category');
        return $product;
    }
}
