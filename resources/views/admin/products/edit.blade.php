<!-- resources/views/admin/products/edit.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="relative mb-12">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-pink-100 opacity-50 rounded-3xl blur-xl"></div>
            <div class="relative bg-white bg-opacity-95 backdrop-blur-lg shadow-lg rounded-3xl p-8 border border-gray-100">
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                    Edit Product: {{ $product->name }}
                </h1>
                <p class="mt-2 text-lg text-gray-500">Update the product details below.</p>
            </div>
        </div>

        <!-- Edit Product Form -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl p-8 border-l-4 border-blue-200">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-pink-50 opacity-20 rounded-2xl"></div>
            <div class="relative">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-8 h-8 text-blue-400 mr-3 transform hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Product Details
                </h2>

                <!-- Form -->
                <form action="{{ route('admin.products.update', $product->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700">Product Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('name') border-red-300 @enderror" placeholder="Enter product name" required>
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-gray-700">Category</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('category_id') border-red-300 @enderror">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700">Price</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('price') border-red-300 @enderror" placeholder="Enter price" required>
                            @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div>
                            <label for="stock" class="block text-sm font-semibold text-gray-700">Stock Quantity</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock_quantity) }}" min="0" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('stock') border-red-300 @enderror" placeholder="Enter stock quantity" required>
                            @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('status') border-red-300 @enderror" required>
                                <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status', $product->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Featured Product -->
                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-300 transition-all duration-300">
                            <label for="is_featured" class="ml-2 block text-sm font-semibold text-gray-700">Featured Product</label>
                            @error('is_featured')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('description') border-red-300 @enderror" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="sm:col-span-2">
                            <label for="image" class="block text-sm font-semibold text-gray-700">Product Image</label>
                            @if($product->image)
                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="mt-2 h-48 w-auto rounded-lg shadow-sm">
                                <p class="mt-1 text-sm text-gray-600">Upload a new image to replace the current one.</p>
                            @endif
                            <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all duration-300">
                            @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="sm:col-span-2 flex justify-end space-x-4">
                            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-all duration-300 font-semibold">
                                Update Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
