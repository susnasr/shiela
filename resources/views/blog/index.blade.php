@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="relative mb-12">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-pink-100 opacity-50 rounded-3xl blur-xl"></div>
            <div class="relative bg-white bg-opacity-95 backdrop-blur-lg shadow-lg rounded-3xl p-8 border border-gray-100">
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">Shiela Blog</h1>
                <p class="mt-2 text-lg text-gray-600">Explore our latest insights and stories.</p>
            </div>
        </div>

        <!-- Blog Posts Grid -->
        <div class="relative">
            @if ($posts->isEmpty())
                <div class="bg-white bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl p-8 border-l-4 border-blue-200">
                    <p class="text-gray-600">No blog posts found.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($posts as $post)
                        <div class="relative bg-white bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl overflow-hidden border-l-4 border-blue-200 hover:shadow-lg transition-shadow duration-300">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-pink-50 opacity-20 rounded-2xl"></div>
                            @if ($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                            @else
                                <img src="{{ asset('images/default-blog.jpg') }}" alt="Placeholder" class="w-full h-48 object-cover">
                            @endif
                            <div class="relative p-6">
                                <h2 class="text-xl font-semibold text-gray-800 mb-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 hover:underline">{{ $post->title }}</a>
                                </h2>
                                <p class="text-gray-600 mb-4">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">{{ $post->category->name ?? 'Uncategorized' }}</span>
                                    <span class="text-sm text-gray-500">{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not Published' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
