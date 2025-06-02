@extends('layouts.guest')

@section('content')
    <div class="w-full">
        <h1 class="text-2xl font-bold text-center mb-6">SHIELA Blog</h1>
        <div class="mb-4 p-4 bg-white shadow rounded">
            <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
            <p class="text-gray-600">{{ $post->content }}</p>
            @auth
                <a href="{{ route('blog.edit', $post->slug) }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Edit</a>
                <form action="{{ route('blog.destroy', $post->slug) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <x-primary-button type="submit" class="bg-red-600 hover:bg-red-700">Delete</x-primary-button>
                </form>
            @endauth
        </div>
        <a href="{{ route('blog.index') }}" class="text-blue-600 hover:underline">Back to Blog</a>
    </div>
@endsection
