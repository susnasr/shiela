@props(['href', 'active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900 dark:text-white focus:outline-none transition'
                : 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
