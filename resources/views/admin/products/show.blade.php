<!-- resources/views/admin/products/show.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="relative mb-12">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-pink-100 opacity-50 rounded-3xl blur-xl"></div>
            <div class="relative bg-white bg-opacity-95 backdrop-blur-lg shadow-lg rounded-3xl p-8 border border-gray-100">
                <div class="flex justify-between items-center">
                    <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                        Product Details: {{ $product->name }}
                    </h1>
                    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold shadow-sm">
                        Back to Products
                    </a>
                </div>
                <p class="mt-2 text-lg text-gray-500">View the details of the product below.</p>
            </div>
        </div>

        <!-- Product Details -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl p-8 border-l-4 border-blue-200">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-pink-50 opacity-20 rounded-2xl"></div>
            <div class="relative">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-8 h-8 text-blue-400 mr-3 transform hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Product Information
                </h2>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Name</label>
                        <p class="mt-1 text-gray-600">{{ $product->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Category</label>
                        <p class="mt-1 text-gray-600">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Price</label>
                        <p class="mt-1 text-gray-600">${{ number_format($product->price, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Stock Quantity</label>
                        <p class="mt-1 text-gray-600">{{ $product->stock_quantity }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Status</label>
                        <p class="mt-1 text-gray-600">{{ ucfirst($product->status) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Featured</label>
                        <p class="mt-1 text-gray-600">{{ $product->is_featured ? 'Yes' : 'No' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700">Description</label>
                        <p class="mt-1 text-gray-600">{{ $product->description ?? 'No description available.' }}</p>
                    </div>
                    @if($product->image)
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Image</label>
                            <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="mt-2 h-48 w-auto rounded-lg shadow-sm">
                        </div>
                    @endif
                    @if($product->trashed())
                        <div class="sm:col-span-2">
                            <p class="text-red-600 font-semibold">This product is soft-deleted (Deleted at: {{ $product->deleted_at->format('d M Y H:i') }}).</p>
                            <form action="{{ route('admin.products.restore', $product->slug) }}" method="POST" class="inline-block mt-2">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-xl hover:bg-green-200 transition-all duration-300 font-semibold">
                                    Restore Product
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
