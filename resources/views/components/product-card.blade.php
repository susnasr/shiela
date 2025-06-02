<div class="group relative">
    {{-- Image Container --}}
    <div class="aspect-square overflow-hidden mb-4 relative">
        {{-- Product Image with Link --}}
        <a href="{{ route('products.show', $product) }}" class="block h-full">
            <img src="{{ $product->main_image }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-75">

            {{-- Quick Add Button (Appears on Hover) --}}
            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-20">
                <form action="{{ route('cart.add', $product) }}" method="POST" class="text-center">
                    @csrf
                    <button type="submit"
                            class="bg-white text-black px-6 py-2 text-sm font-medium hover:bg-gray-100 transition"
                            aria-label="Add {{ $product->name }} to cart">
                        Quick Add
                    </button>
                </form>
            </div>
        </a>

        {{-- Sale Badge --}}
        @if($product->has_active_discount)
            <div class="absolute top-3 left-3 bg-black text-white text-xs px-3 py-1 tracking-wider">
                SALE
            </div>
        @endif
    </div>

    {{-- Product Info --}}
    <div class="text-center px-2">
        <h3 class="text-gray-900 mb-1 font-light text-lg">
            <a href="{{ route('products.show', $product) }}" class="hover:text-gray-600 transition-colors duration-200">
                {{ $product->name }}
            </a>
        </h3>
        <div class="flex justify-center items-center space-x-2">
            @if($product->has_active_discount)
                <span class="text-gray-500 line-through text-sm">
                    ${{ number_format($product->price, 2) }}
                </span>
            @endif
            <span class="font-medium {{ $product->has_active_discount ? 'text-red-600' : 'text-gray-900' }}">
                ${{ number_format($product->final_price, 2) }}
            </span>
        </div>
    </div>
</div>
