@extends('layouts.app')

@section('title', 'Shop - Thrift Platform')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Shop All Items</h1>
        <p class="mt-2 text-gray-600">Discover unique, pre-loved fashion items</p>
    </div>

    <!-- Filters -->
    <div class="mb-8 bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('shop.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search products..." 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Size -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                <select name="size" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">All Sizes</option>
                    <option value="XS" {{ request('size') == 'XS' ? 'selected' : '' }}>XS</option>
                    <option value="S" {{ request('size') == 'S' ? 'selected' : '' }}>S</option>
                    <option value="M" {{ request('size') == 'M' ? 'selected' : '' }}>M</option>
                    <option value="L" {{ request('size') == 'L' ? 'selected' : '' }}>L</option>
                    <option value="XL" {{ request('size') == 'XL' ? 'selected' : '' }}>XL</option>
                </select>
            </div>

            <!-- Price Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Max Price</label>
                <select name="price_max" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">Any Price</option>
                    <option value="25" {{ request('price_max') == '25' ? 'selected' : '' }}>Under $25</option>
                    <option value="50" {{ request('price_max') == '50' ? 'selected' : '' }}>Under $50</option>
                    <option value="100" {{ request('price_max') == '100' ? 'selected' : '' }}>Under $100</option>
                </select>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select name="sort" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </div>

            <!-- Filter Button -->
            <div class="md:col-span-5 flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition duration-150">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 group">
                <div class="aspect-w-1 aspect-h-1 bg-gray-200 relative">
                    <img src="{{ $product->first_image }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-64 object-cover group-hover:scale-105 transition duration-300">
                    
                    @if($product->discount_percentage > 0)
                        <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded text-sm font-medium">
                            -{{ $product->discount_percentage }}%
                        </div>
                    @endif

                    @if($product->is_featured)
                        <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded text-sm font-medium">
                            Featured
                        </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                    
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">{{ $product->category->name }}</span>
                        @if($product->size)
                            <span class="text-sm text-gray-600">Size: {{ $product->size }}</span>
                        @endif
                    </div>

                    @if($product->brand)
                        <p class="text-sm text-gray-600 mb-2">{{ $product->brand }}</p>
                    @endif

                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <span class="text-xl font-bold text-green-600">${{ number_format($product->price, 2) }}</span>
                            @if($product->original_price && $product->original_price > $product->price)
                                <span class="text-sm text-gray-500 line-through">${{ number_format($product->original_price, 2) }}</span>
                            @endif
                        </div>
                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full capitalize">
                            {{ str_replace('_', ' ', $product->condition) }}
                        </span>
                    </div>

                    <div class="flex space-x-2">
                        <a href="{{ route('shop.show', $product) }}" 
                           class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium text-center transition duration-150">
                            View Details
                        </a>
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-150">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
            <p class="text-gray-600">Try adjusting your search or filter criteria</p>
        </div>
    @endif
</div>
@endsection