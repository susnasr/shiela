@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="relative mb-12">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-pink-100 opacity-50 rounded-3xl blur-xl"></div>
            <div class="relative bg-white bg-opacity-95 backdrop-blur-lg shadow-lg rounded-3xl p-8 border border-gray-100">
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">Edit Blog Post</h1>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl p-8 border-l-4 border-blue-200">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-pink-50 opacity-20 rounded-2xl"></div>
            <div class="relative">
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.blog.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                        <input type="text" name="title" id="title" class="w-full border rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-200 @error('title') border-red-500 @enderror" value="{{ old('title', $post->title) }}">
                        @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="category_id" class="block text-gray-700 font-semibold mb-2">Category</label>
                        <select name="category_id" id="category_id" class="w-full border rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-200 @error('category_id') border-red-500 @enderror">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="content" class="block text-gray-700 font-semibold mb-2">Content</label>
                        <textarea name="content" id="content" rows="10" class="w-full border rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-200 @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="excerpt" class="block text-gray-700 font-semibold mb-2">Excerpt (Optional)</label>
                        <textarea name="excerpt" id="excerpt" rows="4" class="w-full border rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-200 @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                        @error('excerpt')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-gray-700 font-semibold mb-2">Featured Image (Optional)</label>
                        @if ($post->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-32 h-32 object-cover rounded-xl mb-4">
                        @endif
                        <input type="file" name="image" id="image" class="w-full border rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-200 @error('image') border-red-500 @enderror">
                        @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_published" class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-200" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                            <span class="ml-3 text-gray-700 font-semibold">Publish Immediately</span>
                        </label>
                        @error('is_published')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-all duration-300 font-semibold shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Update Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
