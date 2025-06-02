@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <article class="prose lg:prose-xl">
            <h1 class="text-4xl font-bold">{{ $post->title }}</h1>

            <div class="flex items-center text-sm text-gray-500 space-x-4 mt-2">
                <span>{{ $post->category->name ?? 'Uncategorized' }}</span>
                <span>•</span>
                <span>{{ $post->published_at ? $post->published_at->format('F d, Y') : 'Draft' }}</span>
            </div>

            @if ($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full rounded-lg my-6">
            @endif

            <div class="mt-6 prose-h1:">
                {!! $post->content !!}
            </div>

            <div class="mt-8">
                <a href="{{ route('blog.index') }}"
                   class="inline-flex items-center px-4 py-2 mt-6 text-sm font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 rounded-lg transition duration-200 shadow-sm">
                    &larr; Back to Blog
                </a>
            </div>
        </article>
    </div>
@endsection
