@extends('layouts.app')

@section('title', $category->name . ' - Thrift Platform')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Category Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
        @if($category->description)
            <p class="mt-2 text-gray-600">{{ $category->description }}</p>
        @endif
        <p class="mt-2 text-sm text-gray-500">Showing {{ $products->count() }} of {{ $products->total() }} items</p>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                <div class="aspect-w-1 aspect-h-1 bg-gray-200 relative">
                    @php
                        if (is_string($product->images)) {
                            $images = json_decode($product->images, true) ?? [];
                        } else {
                            $images = is_array($product->images) ? $product->images : [];
                        }
                        $firstImage = $images[0] ?? null;
                    @endphp
                    
                    @if($firstImage)
                        <img src="@if(str_starts_with($firstImage, 'http')){{ $firstImage }}@else{{ asset('storage/' . $firstImage) }}@endif" 
                             alt="{{ $product->name }}" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    
                    <span class="absolute top-2 left-2 bg-blue-600 text-white px-2 py-1 rounded text-xs font-medium capitalize">
                        {{ str_replace('_', ' ', $product->condition) }}
                    </span>
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                    <p class="text-green-600 font-bold text-lg mb-2">${{ number_format($product->price, 2) }}</p>
                    <p class="text-sm text-gray-600 mb-4">by {{ $product->seller->name ?? 'Unknown Seller' }}</p>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('shop.show', $product) }}" 
                           class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition">
                            View Details
                        </a>
                        @auth
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium transition">
                                    Add to Cart
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No products</h3>
                <p class="mt-1 text-sm text-gray-500">No products available in this category yet.</p>
                <div class="mt-6">
                    <a href="{{ route('shop.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Continue Shopping
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
