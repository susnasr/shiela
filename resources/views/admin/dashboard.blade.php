@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-6 py-10 bg-gradient-to-br from-gray-100 via-gray-50 to-white min-h-screen">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-10 tracking-wide border-b-4 border-gold-500 pb-2">
            Admin Dashboard
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- Products Card -->
            <div class="bg-white shadow-xl rounded-xl p-6 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border-l-4 border-blue-600">
                <h2 class="text-2xl font-semibold text-gray-800 mb-5 flex items-center">
                    <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    Products
                </h2>
                <p class="text-lg text-gray-700"><span class="font-bold text-gold-500">Total:</span> {{ $metrics['products']['total'] }}</p>
                <p class="text-lg text-gray-700"><span class="font-bold text-green-600">Active:</span> {{ $metrics['products']['active'] }}</p>
                <p class="text-lg text-gray-700"><span class="font-bold text-red-600">Low Stock:</span> <span class="text-xl">{{ $metrics['products']['low_stock'] }}</span></p>
            </div>

            <div class="bg-white shadow-xl rounded-xl p-6 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border-l-4 border-green-600">
                <h2 class="text-2xl font-semibold text-gray-800 mb-5 flex items-center">
                    <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18M3 3h18M21 3v18M3 9h18M9 3v18"></path>
                    </svg>
                    Orders
                </h2>
                <p class="text-lg text-gray-700"><span class="font-bold text-gold-500">Total:</span> {{ $metrics['orders']['total'] }}</p>
                <p class="text-lg text-gray-700"><span class="font-bold text-green-600">Completed:</span> {{ $metrics['orders']['completed'] }}</p>
                <p class="text-lg text-gray-700"><span class="font-bold text-yellow-600">Pending:</span> <span class="text-xl">{{ $metrics['orders']['pending'] }}</span></p>
            </div>

            <div class="bg-white shadow-xl rounded-xl p-6 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border-l-4 border-purple-600">
                <h2 class="text-2xl font-semibold text-gray-800 mb-5 flex items-center">
                    <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2h6v-2c0-1.657-1.343-3-3-3zM12 3v2m0 10v6m-9-9h2m14 0h2"></path>
                    </svg>
                    Revenue
                </h2>
                <p class="text-lg text-gray-700"><span class="font-bold text-gold-500">Total:</span> ${{ number_format($metrics['revenue']['total'], 2) }}</p>
                <p class="text-lg text-gray-700"><span class="font-bold text-green-600">Monthly:</span> ${{ number_format($metrics['revenue']['monthly'], 2) }}</p>
                <p class="text-lg text-gray-700"><span class="font-bold text-blue-600">Weekly:</span> ${{ number_format($metrics['revenue']['weekly'], 2) }}</p>
            </div>

            <div class="bg-white shadow-xl rounded-xl p-6 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border-l-4 border-indigo-600">
                <h2 class="text-2xl font-semibold text-gray-800 mb-5 flex items-center">
                    <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Users
                </h2>
                <p class="text-lg text-gray-700"><span class="font-bold text-gold-500">Total:</span> {{ $metrics['users']['total'] }}</p>
                <p class="text-lg text-gray-700"><span class="font-bold text-green-600">Customers:</span> {{ $metrics['users']['customers'] }}</p>
                <p class="text-lg text-gray-700"><span class="font-bold text-blue-600">New This Month:</span> {{ $metrics['users']['new_this_month'] }}</p>
            </div>
        </div>

        <div class="bg-white shadow-xl rounded-xl p-6 mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18M3 3h18M21 3v18M3 9h18M9 3v18"></path>
                </svg>
                Recent Orders
            </h2>
            @if($recent_orders->isEmpty())
                <p class="text-gray-500 text-xl">No recent orders with valid items available.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300 bg-gradient-to-r from-white to-gray-50">
                        <thead>
                        <tr class="bg-gray-800 text-white uppercase text-sm">
                            <th class="py-4 px-6 text-left font-medium">Order ID</th>
                            <th class="py-4 px-6 text-left font-medium">Customer</th>
                            <th class="py-4 px-6 text-left font-medium">Status</th>
                            <th class="py-4 px-6 text-left font-medium">Items</th>
                            <th class="py-4 px-6 text-right font-medium">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @foreach($recent_orders as $order)
                            <tr class="hover:bg-gray-100 hover:shadow-lg transition duration-300">
                                <td class="py-5 px-6 text-gray-900 font-semibold">#{{ $order->id }}</td>
                                <td class="py-5 px-6 text-gray-700">{{ $order->user->name ?? '—' }}</td>
                                <td class="py-5 px-6">
                                        <span class="px-3 py-1 rounded-full {{ $order->status_color ?? 'bg-gray-500' }} text-white font-medium">
                                            {{ \App\Models\Order::STATUSES[$order->status] ?? $order->status }}
                                        </span>
                                </td>
                                <td class="py-5 px-6 text-gray-700">
                                    @foreach($order->items as $item)
                                        @if($item->product)
                                            <div class="text-lg">{{ $item->product->name }} (Qty: {{ $item->quantity }})</div>
                                        @else
                                            <div class="text-lg text-red-500">Item unavailable (Product deleted)</div>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="py-5 px-6 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-gold-600 hover:text-gold-800 font-semibold text-xl">View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="bg-white shadow-xl rounded-xl p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Low Stock Products
            </h2>
            @if($low_stock_products->isEmpty())
                <p class="text-gray-500 text-xl">No low stock products found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300 bg-gradient-to-r from-white to-gray-50">
                        <thead>
                        <tr class="bg-gray-800 text-white uppercase text-sm">
                            <th class="py-4 px-6 text-left font-medium">Product</th>
                            <th class="py-4 px-6 text-left font-medium">Category</th>
                            <th class="py-4 px-6 text-left font-medium">Stock</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @foreach($low_stock_products as $product)
                            <tr class="hover:bg-red-50 hover:shadow-md transition duration-300">
                                <td class="py-5 px-6 text-gray-900 font-semibold">{{ $product->name }}</td>
                                <td class="py-5 px-6 text-gray-700">{{ $product->category->name ?? '—' }}</td>
                                <td class="py-5 px-6">
                                    <span class="text-red-600 font-bold text-xl">{{ $product->stock_quantity }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
