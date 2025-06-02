@if ($paginator->hasPages())
    <nav class="flex items-center justify-center space-x-4 py-8">
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 border rounded text-gray-400 cursor-not-allowed">
                &larr; Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="px-4 py-2 border rounded hover:bg-gray-100 transition-colors duration-200">
                &larr; Previous
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="px-4 py-2 border rounded hover:bg-gray-100 transition-colors duration-200">
                Next &rarr;
            </a>
        @else
            <span class="px-4 py-2 border rounded text-gray-400 cursor-not-allowed">
                Next &rarr;
            </span>
        @endif
    </nav>
@endif
