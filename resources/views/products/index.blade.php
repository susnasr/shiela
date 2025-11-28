@extends('layouts.app')
@section('title', 'Products - SHIELA')

@section('content')
    <div class="container mx-auto px-4 py-8 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Shop Products</h1>

        @if (session('success'))
            <div class="mb-4 text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900 p-3 rounded">
                {{ session('success') }}
            </div>
        @elseif (session('info'))
            <div class="mb-4 text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900 p-3 rounded">
                {{ session('info') }}
            </div>
        @endif

        <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex flex-wrap gap-4 items-center">
            <!-- Category Filter -->
            <select name="category" class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 rounded focus:outline-none focus:ring-1 focus:ring-black dark:focus:ring-white min-w-[180px]">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" {{ $selectedCategory == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <!-- Sort Filter -->
            <select name="sort" class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 rounded focus:outline-none focus:ring-1 focus:ring-black dark:focus:ring-white min-w-[180px]">
                <option value="latest" {{ $sortOption == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="price_low" {{ $sortOption == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ $sortOption == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="featured" {{ $sortOption == 'featured' ? 'selected' : '' }}>Featured</option>
            </select>

            <!-- Search Input -->
            <input type="text"
                   name="search"
                   placeholder="Search products..."
                   value="{{ $searchQuery }}"
                   class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 rounded focus:outline-none focus:ring-1 focus:ring-black dark:focus:ring-white min-w-[200px]">

            <!-- Apply Button -->
            <button type="submit" class="bg-black dark:bg-white text-white dark:text-black px-6 py-2 rounded hover:bg-gray-800 dark:hover:bg-gray-200 transition duration-200 font-medium">
                Apply Filters
            </button>

            <!-- Reset Button -->
            <a href="{{ route('products.index') }}" class="text-gray-600 dark:text-gray-400 px-4 py-2 rounded border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                Reset
            </a>
        </form>

        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow hover:shadow-md transition duration-300 product-card bg-white dark:bg-gray-800">
                        <div class="product-image-container mb-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-48 object-cover rounded-lg">
                            @elseif($product->main_image)
                                <img src="{{ $product->main_image }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-48 object-cover rounded-lg">
                            @else
                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500 dark:text-gray-400">No Image</span>
                                </div>
                            @endif
                        </div>

                        <h2 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">{{ $product->name }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 text-lg font-bold mb-2">${{ number_format($product->price, 2) }}</p>

                        @if($product->category)
                            <span class="text-sm text-gray-500 dark:text-gray-400 mb-3 block">{{ $product->category->name }}</span>
                        @endif

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('products.show', $product->id) }}"
                               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200 flex-1 text-center text-sm">
                                View Details
                            </a>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="bg-black dark:bg-white text-white dark:text-black px-4 py-2 rounded hover:bg-gray-800 dark:hover:bg-gray-200 w-full transition duration-200 text-sm">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-gray-900 dark:text-white">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600 dark:text-gray-400 text-lg mb-4">No products found.</p>
                <a href="{{ route('products.index') }}"
                   class="bg-black dark:bg-white text-white dark:text-black px-6 py-2 rounded hover:bg-gray-800 dark:hover:bg-gray-200 transition duration-200">
                    Clear Filters
                </a>
            </div>
        @endif
    </div>
@endsection
