<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SHIELA') }} - {{ $title ?? 'Authentication' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .auth-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #1a202c;
        }
        .auth-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        .auth-button {
            width: 100%;
            padding: 0.75rem;
            background-color: #1a202c;
            color: white;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-weight: 600;
        }
        .auth-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #4a5568;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
    <!-- Brand Logo -->
    <div class="mb-8">
        <a href="/">
            <span class="text-3xl font-bold font-serif">SHIELA</span>
        </a>
    </div>

    <!-- Auth Card -->
    <div class="w-full sm:max-w-md px-6 py-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        @yield('content')
    </div>
</div>
</body>
</html>
