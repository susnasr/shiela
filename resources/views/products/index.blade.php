@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Shop Products</h1>
        @if (session('success'))
            <div class="mb-4 text-green-600 bg-green-100 p-3 rounded">
                {{ session('success') }}
            </div>
        @elseif (session('info'))
            <div class="mb-4 text-blue-600 bg-blue-100 p-3 rounded">
                {{ session('info') }}
            </div>
        @endif

        <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex flex-wrap gap-4">
            <select name="category" class="border px-3 py-2 rounded">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="sort" class="border px-3 py-2 rounded">
                <option value="">Sort by</option>
                <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>Price: High to Low</option>
            </select>

            <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">
                Apply Filters
            </button>
        </form>

        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="border rounded-lg p-4 shadow hover:shadow-md transition duration-300 product-card">
                        <div class="product-image-container mb-4 relative">
                            <img src="{{ $product->main_image }}" alt="NONGA" class="mt-2 h-48 w-auto rounded-lg shadow-sm">
                        </div>

                        <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                        <p class="text-gray-600">${{ number_format($product->price, 2) }}</p>

                        @if($product->category)
                            <span class="text-sm text-gray-500">{{ $product->category->name }}</span>
                        @endif

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 w-full">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <p class="text-gray-600">No products found.</p>
        @endif
    </div>
@endsection
