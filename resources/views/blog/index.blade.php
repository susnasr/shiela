@extends('layouts.guest')

@section('content')
    <div class="w-full">
        <h1 class="text-2xl font-bold text-center mb-6">SHIELA Blog</h1>

        @if (session('success'))
            <div class="mb-4 text-center text-green-600 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Category Filter (if implemented) -->
        @if (count($categories ?? []) > 0)
            <div class="mb-4 text-center">
                <select name="category" id="category" class="border-gray-300 rounded p-2" onchange="window.location.href=this.value">
                    <option value="{{ route('blog.index') }}">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ route('blog.category', $category->slug) }}" {{ request()->routeIs('blog.category') && request()->category === $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        @forelse ($posts as $post)
            <div class="mb-4 p-4 bg-white shadow rounded">
                <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                <p class="text-gray-600">{{ Str::limit($post->content, 150) }}</p>
                <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 hover:underline">Read more</a>
                @auth
                    <a href="{{ route('blog.edit', $post->slug) }}" class="ml-4 text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('blog.destroy', $post->slug) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <x-primary-button type="submit" class="bg-red-600 hover:bg-red-700 text-sm py-1 px-2">Delete</x-primary-button>
                    </form>
                @endauth
            </div>
        @empty
            <p class="text-center">No posts available yet.</p>
        @endforelse

        @auth
            <a href="{{ route('blog.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add New Post</a>
        @endauth

        <!-- Pagination (if used) -->
        @if ($posts instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-4 text-center">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
