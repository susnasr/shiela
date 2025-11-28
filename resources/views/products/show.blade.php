@extends('layouts.app')
@section('title', $product->name . ' - SHIELA')
@section('content')
    <div class="container mx-auto px-4 py-8 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="list-reset flex text-gray-600 dark:text-gray-400">
                <li><a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('products.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">Products</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-800 dark:text-gray-200">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div class="bg-white dark:bg-gray-700 rounded-lg p-4 shadow">
                @if($product->images ?? false)
                    @php
                        $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
                    @endphp
                    <div id="productCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                        <div class="carousel-inner rounded-lg">
                            @foreach($images as $key => $image)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image) }}"
                                         class="d-block w-100 object-contain max-h-[500px]"
                                         alt="{{ $product->name }} - Image {{ $key + 1 }}">
                                </div>
                            @endforeach
                        </div>

                        @if(count($images) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @elseif($product->image ?? false)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="w-full object-contain max-h-[500px] rounded-lg"
                         alt="{{ $product->name }}">
                @else
                    <div class="w-full h-96 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500 dark:text-gray-400 text-lg">No image available</span>
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="lg:pl-8 bg-white dark:bg-gray-700 rounded-lg p-6 shadow">
                <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">{{ $product->name }}</h1>

                @if($product->category)
                    <p class="text-gray-600 dark:text-gray-400 mb-2">Category: <span class="font-semibold text-gray-900 dark:text-white">{{ $product->category->name }}</span></p>
                @endif

                <div class="mb-6">
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
                    @if($product->activeDiscounts && $product->activeDiscounts->count() > 0)
                        <span class="ml-2 text-sm text-red-600 dark:text-red-400 line-through">${{ number_format($product->original_price, 2) }}</span>
                        <span class="ml-2 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300 px-2 py-1 rounded text-sm">SAVE {{ $product->activeDiscounts->first()->percentage }}%</span>
                    @endif
                </div>

                <div class="mb-6">
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $product->description ?? 'No description available.' }}</p>
                </div>

                <!-- Add to Cart Section -->
                <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Quantity Selector -->
                        <div class="flex items-center space-x-4">
                            <label for="quantity" class="text-lg font-semibold text-gray-900 dark:text-white">Quantity:</label>
                            <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden shadow-sm bg-white dark:bg-gray-800">
                                <!-- Minus Button -->


                                <!-- Quantity Display -->
                                <input type="number"
                                       name="quantity"
                                       id="quantity"
                                       value="1"
                                       min="1"
                                       max="10"
                                       class="w-16 text-center border-0 focus:ring-0 focus:outline-none text-lg font-semibold bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                                       onchange="validateQuantity()"
                                       readonly>

                            </div>
                        </div>


                        <!-- Action Buttons -->
                        <div class="flex space-x-4">
                            <button type="submit"
                                    class="bg-black dark:bg-white text-white dark:text-black px-8 py-3 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition duration-300 font-semibold flex-1">
                                🛒 Add to Cart
                            </button>

                            <button type="button"
                                    class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-300 font-semibold">
                                ♡ Wishlist
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Product Features -->
                <div class="mt-8 border-t border-gray-200 dark:border-gray-600 pt-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Product Details</h3>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                        @if($product->sku)
                            <li><strong>SKU:</strong> {{ $product->sku }}</li>
                        @endif
                        @if($product->weight)
                            <li><strong>Weight:</strong> {{ $product->weight }} kg</li>
                        @endif
                        @if($product->dimensions)
                            <li><strong>Dimensions:</strong> {{ $product->dimensions }}</li>
                        @endif
                        <li><strong>Availability:</strong> <span class="text-green-600 dark:text-green-400">In Stock</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-16 border-t border-gray-200 dark:border-gray-600 pt-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <p class="text-gray-500 dark:text-gray-400 text-center col-span-full">Related products coming soon...</p>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS for carousel -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
