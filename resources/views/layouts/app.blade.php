<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SHIELA - Ecommerce Store')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <style>
        .brand-font { font-family: 'Playfair Display', serif; letter-spacing: 1.5px; }
        .body-font { font-family: 'Montserrat', sans-serif; }
    </style>

    <!-- Theme Script -->
    <script>
        // Check for saved theme preference or default to system
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="body-font bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col transition-colors duration-300">

{{-- ✅ EXACT SAME HEADER INCLUDED --}}
@include('layouts.header')

{{-- ⛔ REMOVE EXTRA PADDING HERE (so spacing matches home) --}}
<main class="flex-1 bg-gray-50 dark:bg-gray-900">
    @yield('content')
</main>

{{-- Footer --}}
@include('layouts.footer')

</body>
</html>
