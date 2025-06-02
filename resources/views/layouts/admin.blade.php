<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | {{ config('app.name') }}</title>

    <!-- Tailwind CSS (or your preferred framework) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
<!-- Admin Navigation -->
<nav class="bg-black text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">Admin Panel</a>
        <div class="space-x-4">
            <a href="{{ route('admin.products.index') }}" class="hover:text-blue-200">
                <i class="fas fa-box mr-1"></i> Products
            </a>
            <a href="{{ route('admin.orders.index') }}" class="hover:text-blue-200">
                <i class="fas fa-shopping-cart mr-1"></i> Orders
            </a>
            <a href="{{ route('admin.blog.index') }}" class="hover:text-blue-200">
                <i class="fas fa-blog mr-1"></i> Blogs
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="hover:text-blue-200">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="container mx-auto p-4">
    @yield('content')
</main>

<!-- Optional JS -->
<script>
    // Add any admin-specific JS here
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Admin dashboard loaded');
    });
</script>
</body>
</html>
