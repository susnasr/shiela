<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderByDesc('price');
                break;
            case 'popular':
                $query->withCount('orders')->orderByDesc('orders_count');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        return view('admin.products.index', compact('products', 'categories', 'minPrice', 'maxPrice'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Log::info('Product store request received', ['input' => $request->all()]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean'
        ]);

        $validated['stock_quantity'] = $validated['stock'];
        unset($validated['stock']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        }

        $product = Product::create($validated);
        Log::info('Product created successfully', ['product_id' => $product->id]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        Log::info('Product update request received', ['input' => $request->all(), 'product_id' => $product->id]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean'
        ]);

        $validated['stock_quantity'] = $validated['stock'];
        unset($validated['stock']);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        }

        $product->update($validated);
        Log::info('Product updated successfully', ['product_id' => $product->id]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        Log::info('Product destroy request received', ['product_id' => $product->id]);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        Log::info('Product deleted successfully', ['product_id' => $product->id]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function restore(Request $request, Product $product)
    {
        Log::info('Product restore request received', ['product_id' => $product->id]);

        $product->restore();
        Log::info('Product restored successfully', ['product_id' => $product->id]);

        return redirect()->route('admin.products.show', $product->slug)
            ->with('success', 'Product restored successfully.');
    }
}
