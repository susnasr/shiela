<footer class="bg-gray-900 text-white py-16 mt-20">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <h3 class="text-3xl font-bold brand-font mb-4">SHIELA</h3>
                <p class="text-gray-400 leading-relaxed">Unseen outfits for unseen forces.<br>Premium apparel crafted with passion.</p>
            </div>

            <div>
                <h4 class="font-semibold text-lg mb-5">Shop</h4>
                <ul class="space-y-3 text-gray-400">
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition">All Products</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-white transition">Blog</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-lg mb-5">Account</h4>
                <ul class="space-y-3 text-gray-400">
                    @auth
                        <li><a href="{{ route('profile.edit') }}" class="hover:text-white transition">My Profile</a></li>
                        <li><a href="{{ route('orders.index') }}" class="hover:text-white transition">My Orders</a></li>
                        <li><a href="{{ route('wishlist.index') }}" class="hover:text-white transition">Wishlist</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Create Account</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-lg mb-5">Contact</h4>
                <p class="text-gray-400">support@shiela.com<br>+1 (555) 123-4567</p>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500 text-sm">
            © {{ date('Y') }} SHIELA. All rights reserved.
        </div>
    </div>
</footer>
