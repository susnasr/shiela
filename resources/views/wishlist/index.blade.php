@extends('layouts.app')
@section('title', 'My Wishlist - SHIELA')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="list-reset flex text-gray-600">
                <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-800">Wishlist</li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold mb-8">My Wishlist</h1>

        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('info'))
            <div class="mb-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                {{ session('info') }}
            </div>
        @endif

        @if($wishlistItems->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($wishlistItems as $wishlistItem)
                    @php
                        $product = $wishlistItem->product;
                    @endphp
                    <div class="border rounded-lg p-4 shadow hover:shadow-md transition duration-300 relative">
                        <!-- Remove from Wishlist Button -->
                        <form action="{{ route('wishlist.destroy', $wishlistItem->id) }}" method="POST" class="absolute top-3 right-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition duration-200"
                                    onclick="return confirm('Remove from wishlist?')">
                                ❌
                            </button>
                        </form>

                        <!-- Product Image -->
                        <div class="mb-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-48 object-cover rounded-lg">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>

                        @if($product->category)
                            <p class="text-sm text-gray-600 mb-2">{{ $product->category->name }}</p>
                        @endif

                        <div class="mb-4">
                            <span class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                            @if($product->activeDiscounts && $product->activeDiscounts->count() > 0)
                                <span class="ml-2 text-sm text-red-600 line-through">
                                ${{ number_format($product->original_price, 2) }}
                            </span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-2">
                            <a href="{{ route('products.show', $product->id) }}"
                               class="block text-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-200">
                                View Product
                            </a>

                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-black text-white py-2 px-4 rounded hover:bg-gray-800 transition duration-200">
                                    🛒 Add to Cart
                                </button>
                            </form>
                        </div>

                        <!-- Added Date -->
                        <p class="text-xs text-gray-500 mt-3">
                            Added {{ $wishlistItem->created_at->diffForHumans() }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Empty Wishlist Message (if all items removed) -->
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">💔</div>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Your wishlist is empty</h2>
                <p class="text-gray-600 mb-6">Start adding items you love to your wishlist!</p>
                <a href="{{ route('products.index') }}"
                   class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition duration-200">
                    Browse Products
                </a>
            </div>
        @endif
    </div>

    <!-- Add some custom styles -->
    <style>
        .wishlist-item {
            transition: all 0.3s ease;
        }

        .wishlist-item:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection
