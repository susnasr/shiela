@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-10 bg-gradient-to-br from-gray-100 via-gray-50 to-white min-h-screen">
        <!-- Welcome Message -->
        @if (session('success'))
            <div class="bg-gradient-to-br from-teal-100 via-teal-50 to-white shadow-xl rounded-xl p-6 mb-6 border-l-4 border-gold-500 transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight flex items-center">
                    <svg class="w-8 h-8 text-gold-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.564.36-3.045 1-4.364m-1 4.364a8 8 0 013.966-6.897"></path>
                    </svg>
                    {{ session('success') }}
                </h2>
            </div>
        @endif

        <!-- Page Header -->
        <header class="text-4xl font-extrabold text-gray-900 mb-10 tracking-tight border-b-4 border-gold-500 pb-2">
            My Account
        </header>

        <!-- Metrics Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- My Orders -->
            <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border-l-4 border-green-600">
                <h2 class="text-xl font-semibold text-gray-800 mb-5 flex items-center">
                    <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18M3 3h18M21 3v18M3 9h18M9 3v18"></path>
                    </svg>
                    My Orders
                </h2>
                <p class="text-lg text-gray-700"><span class="font-bold text-gold-500">Orders:</span> {{ $metrics['total_orders'] }}</p>
                <p class="text-lg text-gray-700"><span class="font-bold text-yellow-600">Pending:</span> {{ $metrics['pending_orders'] }}</p>
                <a href="{{ route('orders.index') }}" class="mt-4 inline-block px-4 py-2 bg-gold-500 text-black rounded-xl hover:bg-gold-600 transition duration-300 font-semibold">View All Orders</a>
            </div>

            <!-- Wishlist -->
            <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border-l-4 border-purple-600">
                <h2 class="text-xl font-semibold text-gray-800 mb-5 flex items-center">
                    <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Wishlist
                </h2>
                <p class="text-lg text-gray-700"><span class="font-bold text-gold-500">Items:</span> {{ $metrics['wishlist_items'] }}</p>
                <p class="text-lg text-gray-700"><span class="font-bold text-pink-600">On Sale:</span> {{ $metrics['on_sale_items'] }}</p>
                <a href="{{ route('wishlist.index') }}" class="mt-4 inline-block px-4 py-2 bg-gold-500 text-black rounded-xl hover:bg-gold-600 transition duration-300 font-semibold">View Wishlist</a>
            </div>

            <!-- Account Details -->
            <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border-l-4 border-indigo-600">
                <h2 class="text-xl font-semibold text-gray-800 mb-5 flex items-center">
                    <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Account Details
                </h2>
                <p class="text-lg text-gray-700"><span class="font-bold text-gold-500">Member Since:</span> {{ $metrics['member_since'] }}</p>
                <a href="{{ route('profile.edit') }}" class="mt-4 inline-block px-4 py-2 bg-gold-500 text-black rounded-xl hover:bg-gold-600 transition duration-300 font-semibold">Edit Profile</a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6 mb-12">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Quick Actions
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <a href="{{ route('products.index') }}" class="bg-white shadow-md rounded-xl p-6 text-center transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300 border-l-4 border-gray-400">
                    <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18M3 3h18M21 3v18M3 9h18M9 3v18"></path>
                    </svg>
                    <p class="text-lg text-gray-700 font-semibold">Continue Shopping</p>
                </a>
                <a href="{{ route('cart.index') }}" class="bg-white shadow-md rounded-xl p-6 text-center transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300 border-l-4 border-green-600">
                    <svg class="w-12 h-12 text-green-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="text-lg text-gray-700 font-semibold">View Cart</p>
                </a>
                <a href="{{ route('orders.index') }}" class="bg-white shadow-md rounded-xl p-6 text-center transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300 border-l-4 border-indigo-600">
                    <svg class="w-12 h-12 text-indigo-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-lg text-gray-700 font-semibold">Track Orders</p>
                </a>
                <a href="{{ route('profile.edit') }}" class="bg-white shadow-md rounded-xl p-6 text-center transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300 border-l-4 border-yellow-600">
                    <svg class="w-12 h-12 text-yellow-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p class="text-lg text-gray-700 font-semibold">Account Settings</p>
                </a>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <svg class="w-8 h-8 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Recent Activities
            </h2>
            @if($recentActivities->isEmpty())
                <p class="text-gray-600">No recent activities to show.</p>
            @else
                <ul class="space-y-4">
                    @foreach($recentActivities as $activity)
                        <li class="flex items-start">
                            <span class="inline-block w-2 h-2 bg-gold-500 rounded-full mt-2 mr-3"></span>
                            <div>
                                <p class="text-gray-700">{{ $activity['message'] }}</p>
                                <p class="text-sm text-gray-500">{{ $activity['time'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
