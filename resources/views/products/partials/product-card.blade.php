<div class="product-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <a href="{{ route('products.show', $product) }}" class="block">
        <!-- Product Image -->
        <div class="product-image h-48 bg-gray-100 flex items-center justify-center">
            @if($product->mainImage)
                <img src="{{ asset('storage/' . $product->mainImage) }}"
                     alt="{{ $product->name }}"
                     class="h-full w-full object-cover">
            @else
                <div class="text-gray-400">No Image Available</div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-1 truncate">{{ $product->name }}</h3>

            <!-- Price and Rating -->
            <div class="flex justify-between items-center mt-2">
                <span class="text-lg font-bold text-indigo-600">${{ number_format($product->price, 2) }}</span>

                @if($product->averageRating() > 0)
                    <div class="flex items-center">
                        <span class="text-yellow-400 mr-1">★</span>
                        <span class="text-sm text-gray-600">{{ number_format($product->averageRating(), 1) }}</span>
                    </div>
                @endif
            </div>

            <!-- Category Badge -->
            @if($product->category)
                <span class="inline-block bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full mt-2">
                    {{ $product->category->name }}
                </span>
            @endif
        </div>
    </a>

    <!-- Add to Cart Button -->
    <div class="px-4 pb-4">
        <form action="{{ route('cart.add', $product) }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition-colors">
                Add to Cart
            </button>
        </form>
    </div>
</div>
