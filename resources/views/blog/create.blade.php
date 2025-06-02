@extends('layouts.guest')

@section('content')
    <div class="w-full">
        <h1 class="text-2xl font-bold text-center mb-6">Add New Blog Post</h1>

        @if ($errors->any())
            <div class="mb-4 text-center text-red-600 text-sm">
                <ul class="list-none p-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('blog.store') }}">
            @csrf
            <div class="mb-4">
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
            </div>
            <div class="mb-4">
                <x-input-label for="content" :value="__('Content')" />
                <textarea id="content" class="block mt-1 w-full border-gray-300 rounded" name="content" rows="5" required>{{ old('content') }}</textarea>
            </div>
            <div class="mb-4">
                <x-input-label for="slug" :value="__('Slug')" />
                <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')" required />
            </div>
            <x-primary-button class="w-full justify-center">
                {{ __('Submit') }}
            </x-primary-button>
        </form>
    </div>
@endsection
