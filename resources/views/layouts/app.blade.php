<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Browse the latest SHIELA apparel – stylish, comfortable, and curated for you.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Product Card Styles -->
    <style>
        .product-card {
            transition: all 0.3s ease;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .product-image-container {
            position: relative;
            overflow: hidden;
            aspect-ratio: 1/1;
            background-color: #f8f9fa;
        }
        .product-image {
            transition: transform 0.5s ease;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        .product-card:hover .product-image {
            transform: scale(1.05);
        }
        .product-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            z-index: 10;
        }
    </style>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')

    @if(isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>
</div>
</body>
</html>
