@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $post->title }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            @if ($post->image)
                <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded mb-6">
            @endif

            <p class="text-gray-600 mb-4"><strong>Category:</strong> {{ $post->category->name ?? '—' }}</p>
            <p class="text-gray-600 mb-4"><strong>Author:</strong> {{ $post->author->name ?? '—' }}</p>
            <p class="text-gray-600 mb-4"><strong>Status:</strong>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $post->is_published ? 'Published' : 'Draft' }}
                </span>
            </p>
            <p class="text-gray-600 mb-4"><strong>Published At:</strong> {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not Published' }}</p>
            <p class="text-gray-600 mb-4"><strong>Excerpt:</strong> {{ $post->excerpt ?? 'No excerpt provided.' }}</p>

            <div class="prose max-w-none mb-6">
                {!! $post->content !!}
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.blog.edit', $post) }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Edit</a>
                <form action="{{ route('admin.blog.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
