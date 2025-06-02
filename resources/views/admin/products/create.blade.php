@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="relative mb-12">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-pink-100 opacity-50 rounded-3xl blur-xl"></div>
            <div class="relative bg-white bg-opacity-95 backdrop-blur-lg shadow-lg rounded-3xl p-8 border border-gray-100">
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                    Add New Product
                </h1>
                <p class="mt-2 text-lg text-gray-500">Fill in the details below to create a new product.</p>
            </div>
        </div>

        <!-- Create Product Form -->
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
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700">Product Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('name') border-red-300 @enderror" placeholder="Enter product name" required>
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-gray-700">Category</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('category_id') border-red-300 @enderror" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700">Price ($)</label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('price') border-red-300 @enderror" placeholder="Enter price" required>
                            @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="block text-sm font-semibold text-gray-700">Stock Quantity</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" min="0" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('stock') border-red-300 @enderror" placeholder="Enter stock quantity" required>
                            @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div>
                            <label for="image" class="block text-sm font-semibold text-gray-700">Product Image</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full text-gray-700 rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('image') border-red-300 @enderror">
                            @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('status') border-red-300 @enderror" required>
                                <option value="" disabled selected>Select status</option>
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Featured -->
                        <div>
                            <label for="is_featured" class="block text-sm font-semibold text-gray-700">Featured Product</label>
                            <div class="mt-1">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-300">
                            </div>
                            @error('is_featured')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="5" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-300 focus:border-blue-300 transition-all duration-300 @error('description') border-red-300 @enderror" placeholder="Enter product description">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-all duration-300 font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
