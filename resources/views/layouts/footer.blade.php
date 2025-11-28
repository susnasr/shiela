<footer class="bg-gray-900 dark:bg-gray-800 text-white py-16 mt-20 transition-colors duration-300">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <h3 class="text-3xl font-bold brand-font mb-4">SHIELA</h3>
                <p class="text-gray-400 dark:text-gray-300 leading-relaxed">Unseen outfits for unseen forces.<br>Premium apparel crafted with passion.</p>
            </div>

            <div>
                <h4 class="font-semibold text-lg mb-5">Shop</h4>
                <ul class="space-y-3 text-gray-400 dark:text-gray-300">
                    <li><a href="{{ route('products.index') }}" class="hover:text-white dark:hover:text-gray-100 transition">All Products</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-white dark:hover:text-gray-100 transition">Blog</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-lg mb-5">Account</h4>
                <ul class="space-y-3 text-gray-400 dark:text-gray-300">
                    @auth
                        <li><a href="{{ route('profile.edit') }}" class="hover:text-white dark:hover:text-gray-100 transition">My Profile</a></li>
                        <li><a href="{{ route('orders.index') }}" class="hover:text-white dark:hover:text-gray-100 transition">My Orders</a></li>
                        <li><a href="{{ route('wishlist.index') }}" class="hover:text-white dark:hover:text-gray-100 transition">Wishlist</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-white dark:hover:text-gray-100 transition">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white dark:hover:text-gray-100 transition">Create Account</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-lg mb-5">Contact</h4>
                <p class="text-gray-400 dark:text-gray-300">support@shiela.com<br>+1 (555) 123-4567</p>
            </div>
        </div>

        <div class="border-t border-gray-800 dark:border-gray-700 mt-12 pt-8 text-center text-gray-500 dark:text-gray-400 text-sm">
            © Designed & Developed by nsr. All rights reserved.{{ date('Y') }}
        </div>
    </div>
</footer>
