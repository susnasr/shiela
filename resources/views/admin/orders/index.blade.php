@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="relative mb-12">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-pink-100 opacity-50 rounded-3xl blur-xl"></div>
            <div class="relative bg-white bg-opacity-95 backdrop-blur-lg shadow-lg rounded-3xl p-8 border border-gray-100">
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                    Manage Orders
                </h1>
                <p class="mt-2 text-lg text-gray-500">View and manage all customer orders below.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="relative bg-white bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl p-8 border-l-4 border-blue-200">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-pink-50 opacity-20 rounded-2xl"></div>
            <div class="relative">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-8 h-8 text-blue-400 mr-3 transform hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18M3 3h18M21 3v18M3 9h18M9 3v18"></path>
                    </svg>
                    All Orders
                </h2>

                @if($orders->isEmpty())
                    <p class="text-gray-600 italic">No orders found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">#{{ $order->id ?? 'N/A'}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $order->user?->name ?? 'No User' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : ($order->status == 'shipped' ? 'bg-green-100 text-green-700' : ($order->status == 'delivered' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">${{ number_format($order->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-all duration-300 text-sm font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>
                                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="bg-gray-50 border-gray-300 text-gray-700 rounded-xl focus:ring-blue-300 focus:border-blue-300 text-sm transition-all duration-300">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete Order #{{ $order->id }}? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-xl hover:bg-red-200 transition-all duration-300 text-sm font-semibold">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $orders->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
