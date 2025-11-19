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
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
            url('https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .brand-font { font-family: 'Playfair Display', serif; letter-spacing: 1.5px; }
        .body-font { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="body-font min-h-screen flex flex-col bg-gray-50">

@include('layouts.header')

<div class="hero">
    <div class="max-w-4xl px-6">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 brand-font leading-tight">
            Unseen outfits for unseen forces
        </h1>
        <p class="text-xl md:text-2xl mb-10 opacity-90">Curated collection of premium, exclusive apparel</p>
        <a href="{{ route('products.index') }}"
           class="inline-block px-12 py-5 bg-white text-black text-lg font-bold rounded-lg hover:bg-gray-100 transition shadow-xl">
            Shop Now
        </a>
    </div>
</div>

<section class="container mx-auto px-6 py-20 flex-1">
    <h2 class="text-4xl md:text-5xl font-bold text-center mb-16 brand-font">Featured Collection</h2>

    @if($featuredProducts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden group">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <div class="aspect-square bg-gray-100 overflow-hidden">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x400?text=SHIELA' }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        </div>
                    </a>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">
                            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-gray-600 transition">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                        @if($product->category)
                            <span class="text-sm text-gray-500">{{ $product->category->name }}</span>
                        @endif

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-5">
                            @csrf
                            <button type="submit" class="w-full bg-black text-white py-3 rounded-lg hover:bg-gray-800 transition font-medium">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-16">
            <a href="{{ route('products.index') }}" class="inline-block px-10 py-4 bg-black text-white text-lg font-medium rounded-lg hover:bg-gray-800 transition">
                View All Products
            </a>
        </div>
    @else
        <p class="text-center text-xl text-gray-600">No featured products yet. Check back soon!</p>
    @endif
</section>

@include('layouts.footer')

</body>
</html>
