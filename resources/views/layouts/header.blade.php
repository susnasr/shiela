<header class="bg-white shadow-sm border-b sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-3xl font-bold brand-font tracking-wider text-gray-900">
                SHIELA
            </a>

            <!-- Right Menu -->
            <div class="flex items-center space-x-8">
                @auth
                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="relative group">
                        <svg class="w-7 h-7 text-gray-700 group-hover:text-black transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-black font-medium transition">
                            <span>Hi, {{ Str::limit(auth()->user()->name, 12) }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('profile.edit') }}" class="block px-5 py-3 hover:bg-gray-50 transition">
                                My Profile
                            </a>
                            <a href="{{ route('orders.index') }}" class="block px-5 py-3 hover:bg-gray-50 transition">
                                My Orders
                            </a>
                            <a href="{{ route('wishlist.index') }}" class="block px-5 py-3 hover:bg-gray-50 transition">
                                Wishlist
                            </a>

                            @if(auth()->user()->is_admin || auth()->user()->role === 'admin')
                                <hr class="my-2">
                                <a href="{{ route('admin.dashboard') }}" class="block px-5 py-3 bg-indigo-50 text-indigo-700 font-medium hover:bg-indigo-100">
                                    Admin Panel
                                </a>
                            @endif

                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="w-full text-left px-5 py-3 text-red-600 hover:bg-red-50 transition font-medium">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Guest Links -->
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-black font-medium transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-black text-white rounded-lg hover:bg-gray-800 transition font-medium">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
