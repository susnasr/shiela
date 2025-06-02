@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-10 bg-gradient-to-br from-gray-100 via-gray-50 to-white min-h-screen">
        <!-- Page Header -->
        <header class="text-4xl font-extrabold text-gray-900 mb-10 tracking-tight border-b-4 border-gold-500 pb-2">
            Order Details - #{{ $order->id }}
        </header>

        <!-- Order Summary Card -->
        <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border-l-4 border-green-600 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-5 flex items-center">
                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                Order Summary
            </h2>
            <div class="space-y-3 text-gray-700">
                <p><span class="font-bold text-gold-500">Placed On:</span> {{ $order->created_at->format('F d, Y H:i:s') }}</p>
                <p><span class="font-bold text-yellow-600">Status:</span> <span class="text-yellow-500">{{ $order->status }}</span></p>
                <p><span class="font-bold text-gold-500">Total Amount:</span> ${{ number_format($order->total_amount, 2) }}</p>
                <p><span class="font-bold text-gold-500">Subtotal:</span> ${{ number_format($order->subtotal, 2) }}</p>
                <p><span class="font-bold text-green-600">Discount:</span> ${{ number_format($order->discount ?? 0.00, 2) }}</p>
                <p><span class="font-bold text-gold-500">Shipping Address:</span> {{ $order->shipping_address }}</p>
                <p><span class="font-bold text-gold-500">Payment Method:</span> {{ $order->payment_method }}</p>
            </div>
        </div>

        <!-- Order Items Card -->
        <div class="bg-gradient-to-br from-gray-100 via-gray-200 to-white shadow-xl rounded-xl p-6 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border-l-4 border-indigo-600">
            <h2 class="text-xl font-semibold text-gray-800 mb-5 flex items-center">
                <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Order Items
            </h2>
            <ul class="list-disc list-inside space-y-3 text-gray-700">
                @foreach ($order->items as $item)
                    <li>
                        {{ $item->name }} -
                        <span class="font-bold text-gold-500">Quantity:</span> {{ $item->quantity }},
                        <span class="font-bold text-gold-500">Price:</span> ${{ number_format($item->price, 2) }},
                        <span class="font-bold text-gold-500">Subtotal:</span> ${{ number_format($item->subtotal, 2) }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
