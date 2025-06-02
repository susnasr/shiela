<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        $selectedCategory = null;
        $sortOption = $request->get('sort', 'latest');
        $searchQuery = $request->get('search');

        $products = Product::query()
            ->where('is_featured', true)
            ->with(['category', 'activeDiscounts'])
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%');
            });



        if ($request->has('category')) {
            $category = Category::where('slug', $request->get('category'))->firstOrFail();
            $selectedCategory = $category->slug;
            $products->where('category_id', $category->id);
        }

        switch ($sortOption) {
            case 'price_low':
                $products->orderBy('price');
                break;
            case 'price_high':
                $products->orderByDesc('price');
                break;
            case 'popular':
                $products->orderByDesc('views');
                break;
            case 'featured':
                $products->where('is_featured', true);
            default:
                $products->latest();
        }

        $products = $products->paginate(12)->withQueryString();

        return view('products.index', [
            'categories' => $categories,
            'products' => $products,
            'selectedCategory' => $selectedCategory,
            'sortOption' => $sortOption,
            'searchQuery' => $searchQuery
        ]);
    }


}
