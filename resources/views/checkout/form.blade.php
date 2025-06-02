@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-10 bg-gradient-to-br from-gray-100 via-gray-50 to-white min-h-screen">
        <!-- Page Header -->
        <header class="text-4xl font-extrabold text-gray-900 mb-10 tracking-tight border-b-4 border-gold-500 pb-2">
            Checkout
        </header>

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-6 border-l-4 border-red-500 transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                {{ session('error') }}
            </div>
        @endif

        <!-- Order Summary -->
        <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <svg class="w-8 h-8 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Order Summary
            </h2>
            <div class="space-y-6">
                @foreach ($cartItems as $item)
                    <div class="bg-white shadow-md rounded-xl p-4 border-l-4 border-indigo-600 transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="{{ $item->product->main_image }}"
                                     alt="{{ $item->product->name }}"
                                     class="w-16 h-16 object-cover rounded mr-4"
                                     onerror="this.src='https://via.placeholder.com/50x50?text=No+Image'">
                                <div>
                                    <p class="text-gray-800 font-medium">{{ $item->product->name }}</p>
                                    <p class="text-gray-600">Price: ₱{{ number_format($item->product->price, 2) }}</p>
                                    <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <p class="text-gray-700 font-semibold">Subtotal: ₱{{ number_format($item->product->price * $item->quantity, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 space-y-4">
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
        </div>

        <!-- Shipping Information -->
        <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Shipping Information
            </h2>
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    @error('address')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" name="city" id="city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    @error('city')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="w-full text-center bg-blue-500 text-black px-4 py-2 rounded-xl hover:bg-gold-600 transition duration-300 font-semibold">
                    Place Order
                </button>
            </form>
        </div>
    </div>
@endsection
