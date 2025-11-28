<header class="bg-white shadow-sm border-b sticky top-0 z-50 dark:bg-gray-800 dark:border-gray-700">
    <div class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-3xl font-bold brand-font tracking-wider text-gray-900 dark:text-white">
                SHIELA
            </a>

            <!-- Right Menu -->
            <div class="flex items-center space-x-6">
                @auth
                    <!-- Theme Dropdown -->
                    <div class="relative group">
                        <button class="p-2 text-gray-700 hover:text-black dark:text-gray-300 dark:hover:text-white transition duration-200">
                            <!-- Dynamic icon based on current theme -->
                            <span class="dark:hidden">
                                <!-- Sun icon for light mode -->
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span class="hidden dark:inline">
                                <!-- Moon icon for dark mode -->
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                </svg>
                            </span>
                        </button>

                        <!-- Theme Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <!-- Light Theme Option -->
                            <button onclick="setTheme('light')" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 border-b border-gray-100 dark:border-gray-600">
                                <svg class="w-4 h-4 mr-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                                </svg>
                                Light Mode
                            </button>

                            <!-- Dark Theme Option -->
                            <button onclick="setTheme('dark')" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 border-b border-gray-100 dark:border-gray-600">
                                <svg class="w-4 h-4 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                </svg>
                                Dark Mode
                            </button>

                            <!-- System Theme Option -->
                            <button onclick="setTheme('system')" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                System Default
                            </button>
                        </div>
                    </div>

                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="relative group">
                        <svg class="w-7 h-7 text-gray-700 group-hover:text-black dark:text-gray-300 dark:group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-black dark:bg-white text-white dark:text-black text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-black dark:text-gray-300 dark:hover:text-white font-medium transition">
                            <span>Hi, {{ Str::limit(auth()->user()->name, 12) }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('profile.edit') }}" class="block px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-gray-700 dark:text-gray-300">
                                My Profile
                            </a>
                            <a href="{{ route('orders.index') }}" class="block px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-gray-700 dark:text-gray-300">
                                My Orders
                            </a>
                            <a href="{{ route('wishlist.index') }}" class="block px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-gray-700 dark:text-gray-300">
                                Wishlist
                            </a>

                            @if(auth()->user()->is_admin || auth()->user()->role === 'admin')
                                <hr class="my-2 border-gray-200 dark:border-gray-600">
                                <a href="{{ route('admin.dashboard') }}" class="block px-5 py-3 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium hover:bg-indigo-100 dark:hover:bg-indigo-900/50">
                                    Admin Panel
                                </a>
                            @endif

                            <hr class="my-2 border-gray-200 dark:border-gray-600">
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="w-full text-left px-5 py-3 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition font-medium">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Theme Dropdown for Guests -->
                    <div class="relative group">
                        <button class="p-2 text-gray-700 hover:text-black dark:text-gray-300 dark:hover:text-white transition duration-200">
                            <span class="dark:hidden">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span class="hidden dark:inline">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                </svg>
                            </span>
                        </button>

                        <div class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <button onclick="setTheme('light')" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 border-b border-gray-100 dark:border-gray-600">
                                <svg class="w-4 h-4 mr-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                                </svg>
                                Light Mode
                            </button>
                            <button onclick="setTheme('dark')" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 border-b border-gray-100 dark:border-gray-600">
                                <svg class="w-4 h-4 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                </svg>
                                Dark Mode
                            </button>
                            <button onclick="setTheme('system')" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                System Default
                            </button>
                        </div>
                    </div>

                    <!-- Guest Links -->
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-black dark:text-gray-300 dark:hover:text-white font-medium transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-black dark:bg-white text-white dark:text-black rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition font-medium">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

<!-- Add this script to your layout file -->
<script>
    function setTheme(theme) {
        const html = document.documentElement;

        if (theme === 'system') {
            localStorage.removeItem('theme');
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        } else {
            localStorage.setItem('theme', theme);
            if (theme === 'dark') {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        }
    }

    // Initialize theme on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else if (savedTheme === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            // System preference
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }
        }
    });
</script>
