@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Blog Post Header -->
        <div class="relative mb-12">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-pink-100 opacity-50 rounded-3xl blur-xl"></div>
            <div class="relative bg-white bg-opacity-95 backdrop-blur-lg shadow-lg rounded-3xl p-8 border border-gray-100">
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">{{ $post->title }}</h1>
            </div>
        </div>

        <!-- Blog Post Content -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl p-8 border-l-4 border-blue-200">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-pink-50 opacity-20 rounded-2xl"></div>
            <div class="relative">
                @if ($post->image)
                    <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-xl mb-6">
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <p class="text-gray-600"><strong>Category:</strong> {{ $post->category->name ?? '—' }}</p>
                    <p class="text-gray-600"><strong>Author:</strong> {{ $post->author->name ?? '—' }}</p>
                    <p class="text-gray-600"><strong>Status:</strong> {{ $post->is_published ? 'Published' : 'Draft' }}</p>
                    <p class="text-gray-600"><strong>Published At:</strong> {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not Published' }}</p>
                    <p class="text-gray-600"><strong>Excerpt:</strong> {{ $post->excerpt ?? 'No excerpt provided.' }}</p>
                </div>

                <div class="prose max-w-none mb-6 text-gray-700">
                    {!! $post->content !!}
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.blog.edit', $post) }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-all duration-300 font-semibold shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-xl hover:bg-red-200 transition-all duration-300 font-semibold shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
