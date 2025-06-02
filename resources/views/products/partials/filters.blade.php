<div class="bg-white p-4 rounded-lg shadow-sm mb-6">
    <form action="{{ route('products.index') }}" method="GET" class="space-y-4">

        <!-- Search -->
        <div>
            <input type="text" name="search" placeholder="Search products..."
                   class="w-full px-4 py-2 border rounded-lg"
                   value="{{ request('search') }}">
        </div>

        <!-- Categories -->
        <div>
            <label for="category" class="block text-sm font-medium mb-1">Category</label>
            <select name="category" id="category"
                    class="w-full px-4 py-2 border rounded-lg">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Price Range -->
        <div>
            <label class="block text-sm font-medium mb-1">Price Range</label>
            <div class="flex gap-2 mb-2">
                <input type="number" name="min_price" placeholder="Min"
                       class="w-1/2 px-3 py-2 border rounded-lg"
                       value="{{ request('min_price') }}">
                <input type="number" name="max_price" placeholder="Max"
                       class="w-1/2 px-3 py-2 border rounded-lg"
                       value="{{ request('max_price') }}">
            </div>
            <input type="range" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                   value="{{ request('max_price') ?? $maxPrice }}"
                   class="w-full">
        </div>

        <!-- Sort By -->
        <div>
            <label for="sort" class="block text-sm font-medium mb-1">Sort By</label>
            <select name="sort" id="sort"
                    class="w-full px-4 py-2 border rounded-lg">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Apply Filters
            </button>
            <a href="{{ route('products.index') }}"
               class="w-full px-4 py-2 border border-gray-300 text-center rounded-lg hover:bg-gray-50">
                Reset
            </a>
        </div>
    </form>
</div>
