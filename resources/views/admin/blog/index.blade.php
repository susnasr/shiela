@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="relative mb-12">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-pink-100 opacity-50 rounded-3xl blur-xl"></div>
            <div class="relative bg-white bg-opacity-95 backdrop-blur-lg shadow-lg rounded-3xl p-8 border border-gray-100">
                <div class="flex justify-between items-center">
                    <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                        Manage Blog Posts
                    </h1>
                    <a href="{{ route('admin.blog.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-all duration-300 font-semibold shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Post
                    </a>
                </div>
                <p class="mt-2 text-lg text-gray-500">View and manage all blog posts below.</p>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="relative bg-green-50 bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl p-6 border-l-4 border-green-200 mb-6">
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-green-100 opacity-20 rounded-2xl"></div>
                <div class="relative text-green-700">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Blog Posts Table -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-md shadow-md rounded-2xl p-8 border-l-4 border-blue-200">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-pink-50 opacity-20 rounded-2xl"></div>
            <div class="relative">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-8 h-8 text-blue-400 mr-3 transform hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18M3 3h18M21 3v18M3 9h18M9 3v18"></path>
                    </svg>
                    All Posts
                </h2>

                @if ($posts->isEmpty())
                    <p class="text-gray-600 italic">No blog posts found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                            @foreach ($posts as $post)
                                <tr class="hover:bg-gray-50 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $post->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $post->category->name ?? 'Uncategorized' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $post->is_published ? 'Published' : 'Draft' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                        <a href="{{ route('admin.blog.show', $post) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-all duration-300 text-sm font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>
                                        <a href="{{ route('admin.blog.edit', $post) }}" class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-xl hover:bg-green-200 transition-all duration-300 text-sm font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-xl hover:bg-red-200 transition-all duration-300 text-sm font-semibold">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867  help with the rest of the path 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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
                @endif
            </div>
        </div>
    </div>
@endsection
