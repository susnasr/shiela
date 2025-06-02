@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Blog Post</h1>

        <form action="{{ route('admin.blog.update', $post) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror" value="{{ old('title', $post->title) }}">
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
                <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2 @error('category_id') border-red-500 @enderror">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-gray-700 font-medium mb-2">Content</label>
                <textarea name="content" id="content" rows="10" class="w-full border rounded px-3 py-2 @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
                @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="excerpt" class="block text-gray-700 font-medium mb-2">Excerpt (Optional)</label>
                <textarea name="excerpt" id="excerpt" rows="4" class="w-full border rounded px-3 py-2 @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">Featured Image (Optional)</label>
                @if ($post->image)
                    <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-32 h-32 object-cover mb-2">
                @endif
                <input type="file" name="image" id="image" class="w-full border rounded px-3 py-2 @error('image') border-red-500 @enderror">
                @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_published" class="form-checkbox" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700">Publish Immediately</span>
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Post</button>
            </div>
        </form>
    </div>
@endsection
