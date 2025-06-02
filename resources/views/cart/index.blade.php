@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-10 bg-gradient-to-br from-gray-100 via-gray-50 to-white min-h-screen">
        <!-- Page Header -->
        <header class="text-4xl font-extrabold text-gray-900 mb-10 tracking-tight border-b-4 border-gold-500 pb-2">
            Shopping Cart
        </header>

        <!-- Cart Items Section -->
        @if ($cartItems->isNotEmpty())
            <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Cart Items
                </h2>
                <div class="space-y-6">
                    @foreach ($cartItems as $item)
                        <div class="bg-white shadow-md rounded-xl p-4 transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300 border-l-4 border-indigo-600">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="{{ $item->product->main_image }}"
                                         alt="{{ $item->product->name }}"
                                         class="w-16 h-16 object-cover rounded mr-4"
                                         onerror="this.src='https://via.placeholder.com/50x50?text=No+Image'">
                                    <div>
                                        <p class="text-gray-800 font-medium">{{ $item->product->name }}</p>
                                        <p class="text-gray-600">Price: ₱{{ number_format($item->product->price, 2) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="action" value="decrease"
                                                class="px-2 py-1 bg-gray-300 text-gray-800 rounded-l hover:bg-gray-400">-</button>
                                        <span class="px-4 text-gray-800">{{ $item->quantity }}</span>
                                        <button type="submit" name="action" value="increase"
                                                class="px-2 py-1 bg-gray-300 text-gray-800 rounded-r hover:bg-gray-400">+</button>
                                    </form>
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Remove</button>
                                    </form>
                                </div>
                            </div>
                            <p class="mt-2 text-right text-gray-700 font-semibold">Subtotal: ₱{{ number_format($item->product->price * $item->quantity, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-8 h-8 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Order Summary
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal</span>
                        <span>₱{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700">
                        <span>Discount</span>
                        <span class="text-green-600">-₱{{ number_format($discount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-semibold text-gray-800 border-t pt-2">
                        <span>Total</span>
                        <span>₱{{ number_format($total, 2) }}</span>
                    </div>
                </div>
                <form action="{{ route('checkout') }}" method="GET" class="mt-6">
                    @csrf
                    <button type="submit" class="w-full text-center bg-blue-500 text-black px-4 py-2 rounded-xl hover:bg-gold-600 transition duration-300 font-semibold">
                        Proceed to Checkout
                    </button>
                </form>
            </div>
        @else
            <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6 text-center">
                <p class="text-gray-600 text-lg">Your cart is empty.</p>
                <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-gold-500 text-black px-4 py-2 rounded-xl hover:bg-gold-600 transition duration-300 font-semibold">
                    Shop Now
                </a>
            </div>
        @endif
    </div>
@endsection
