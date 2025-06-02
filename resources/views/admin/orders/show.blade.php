<!-- resources/views/admin/orders/show.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="relative mb-12">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-pink-100 opacity-50 rounded-3xl blur-xl"></div>
            <div class="relative bg-white bg-opacity-95 backdrop-blur-lg shadow-lg rounded-3xl p-8 border border-gray-100">
                <div class="flex justify-between items-center">
                    <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                        Order #{{ $order->id }}
                    </h1>
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Orders
                    </a>
                </div>
                <p class="mt-2 text-lg text-gray-500">Placed on {{ $order->created_at->format('F j, Y, g:i A') }}</p>
            </div>
        </div>

        <!-- Order Details Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="relative bg-white bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl p-8 border-l-4 border-blue-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-pink-50 opacity-20 rounded-2xl"></div>
                    <div class="relative">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                            <svg class="w-8 h-8 text-blue-400 mr-3 transform hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18M3 3h18M21 3v18M3 9h18M9 3v18"></path>
                            </svg>
                            Order Summary
                        </h2>
                        <div class="space-y-6">
                            <!-- Order Items -->
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between bg-gray-50 bg-opacity-80 rounded-xl p-4 transform hover:scale-[1.01] transition-all duration-300">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-lg text-gray-700 font-medium">{{ $item->product?->name ?? 'Unknown Product' }}</p>
                                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} | Unit Price: ${{ number_format($item->price, 2) }}</p>
                                        </div>
                                    </div>
                                    <p class="text-lg text-gray-700 font-semibold">${{ number_format($item->quantity * $item->price, 2) }}</p>
                                </div>
                            @endforeach
                            <!-- Total -->
                            <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                                <p class="text-xl text-gray-800 font-semibold">Total</p>
                                <p class="text-xl text-blue-500 font-bold">${{ number_format($order->total, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="relative bg-white bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl p-6 border-l-4 border-pink-200">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-50 to-blue-50 opacity-20 rounded-2xl"></div>
                <div class="relative">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-8 h-8 text-pink-400 mr-3 transform hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Customer Info
                    </h2>
                    <p class="text-gray-600"><span class="font-bold text-blue-500">Name:</span> {{ $order->user?->name ?? 'No User' }}</p>
                    <p class="text-gray-600"><span class="font-bold text-blue-500">Email:</span> {{ $order->user?->email ?? 'N/A' }}</p>
                </div>
            </div>

                <!-- Order Status -->
                <div class="relative bg-white bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl p-6 border-l-4 border-gray-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-blue-50 opacity-20 rounded-2xl"></div>
                    <div class="relative">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-8 h-8 text-gray-400 mr-3 transform hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Order Status
                        </h2>
                        <p class="text-gray-600 mb-4"><span class="font-bold text-blue-500">Status:</span>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : ($order->status == 'shipped' ? 'bg-green-100 text-green-700' : ($order->status == 'delivered' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                        <!-- Update Status Form -->
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label for="status" class="block text-gray-600 font-medium">Update Status</label>
                                <select name="status" id="status" class="mt-1 block w-full bg-gray-50 border-gray-300 text-gray-700 rounded-xl focus:ring-blue-300 focus:border-blue-300 transition-all duration-300">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-all duration-300 font-semibold shadow-sm">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
