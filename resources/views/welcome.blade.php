<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SHIELA - Official outfit site of Exalters</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
            url('https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .brand-font {
            font-family: 'Playfair Display', serif;
            letter-spacing: 2px;
        }
        .body-font {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="body-font">
<!-- Navigation -->
<nav class="container mx-auto px-6 py-4">
    <div class="flex justify-between items-center">
        <div class="text-2xl font-bold brand-font">SHIELA</div>
        <div class="flex space-x-4">
            <a href="{{ route('login') }}" class="px-4 py-2">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-black text-white rounded">Register</a>
        </div>
    </div>
</nav>

<div class="hero">
    <div class="max-w-2xl px-4">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 brand-font">Unseen outfits for unseen forces</h1>
        <p class="text-xl mb-8">Discover our curated collection of high-quality, stylish apparel</p>
        <a href="{{ route('products.index') }}" class="inline-block px-8 py-3 bg-white text-black font-semibold rounded hover:bg-gray-100 transition">
            Shop Now
        </a>
    </div>
</div>

<section class="container mx-auto px-4 py-12">
    <h2 class="text-3xl font-bold text-center mb-8 brand-font">Featured Collection</h2>

    @if($featuredProducts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($featuredProducts as $product)
                <div class="border rounded-lg p-4 shadow hover:shadow-md transition duration-300 product-card">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <div class="product-image-container mb-4">
                            @php
                                $imageToShow = $product->image
                                    ? asset('product_pics/' . $product->image)
                                    : 'https://via.placeholder.com/300x300?text=No+Image';
                            @endphp
                            <img src="{{ $product->main_image }}"
                                 alt="{{ $product->name }}"
                                 class="rounded w-full h-auto object-cover"
                                 style="aspect-ratio: 1 / 1;" />
                        </div>
                    </a>

                    <div class="p-4">
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            <h3 class="text-lg font-semibold hover:text-gray-600">{{ $product->name }}</h3>
                        </a>
                        <p class="text-gray-600 mt-2">${{ number_format($product->price, 2) }}</p>

                        @if($product->category)
                            <span class="text-sm text-gray-500">{{ $product->category->name }}</span>
                        @endif

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-black text-white rounded hover:bg-gray-800 transition">
                View All Products
            </a>
        </div>
    @else
        <b> {{ $featuredProductCount }}</b>
        <p class="text-center text-gray-600">No featured products available</p>
    @endif
</section>

@include('layouts.footer')
</body>
</html>
