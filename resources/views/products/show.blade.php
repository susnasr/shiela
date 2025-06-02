@if($product->images ?? false)
    @php
        $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
    @endphp
    <div id="productCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($images as $key => $image)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <img src="{{ $product->main_image }}" class="d-block w-100" alt="qwer">
                </div>
            @endforeach
        </div>
        <!-- Carousel controls remain the same -->
    </div>
@elseif($product->image ?? false)
    <img src="{{ $product->main_image }}" class="img-fluid" alt="{{ $product->name ?? 'Product image' }}">
@else
    <div class="bg-light text-center p-5">
        No image available
    </div>
@endif
