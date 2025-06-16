@extends('layouts.app')

@section('title', 'Categories - Thrift Platform')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-900">Shop by Category</h1>
        <p class="mt-2 text-gray-600">Find exactly what you're looking for</p>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @php
        $categories = [
            ['name' => 'Women\'s Clothing', 'count' => 245, 'image' => 'womens+clothing'],
            ['name' => 'Men\'s Clothing', 'count' => 189, 'image' => 'mens+clothing'],
            ['name' => 'Shoes', 'count' => 156, 'image' => 'vintage+shoes'],
            ['name' => 'Accessories', 'count' => 98, 'image' => 'fashion+accessories'],
            ['name' => 'Bags & Purses', 'count' => 87, 'image' => 'vintage+bags'],
            ['name' => 'Jewelry', 'count' => 134, 'image' => 'vintage+jewelry']
        ];
        @endphp

        @foreach($categories as $category)
        <div class="group relative bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
            <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                <img src="/placeholder.svg?height=200&width=300&query={{ $category['image'] }}" 
                     alt="{{ $category['name'] }}" 
                     class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
            </div>
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $category['name'] }}</h3>
                <p class="text-gray-600 mb-4">{{ $category['count'] }} items available</p>
                <a href="{{ route('shop.index') }}?category={{ urlencode($category['name']) }}" 
                   class="inline-flex items-center text-green-600 hover:text-green-700 font-medium">
                    Shop Now
                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Featured Categories -->
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Featured Collections</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="relative bg-gradient-to-r from-green-500 to-blue-500 rounded-lg overflow-hidden">
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="relative p-8 text-white">
                    <h3 class="text-2xl font-bold mb-2">Vintage Collection</h3>
                    <p class="mb-4">Discover authentic vintage pieces from the 70s, 80s, and 90s</p>
                    <a href="{{ route('shop.index') }}?collection=vintage" 
                       class="inline-block bg-white text-gray-900 px-6 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                        Explore Vintage
                    </a>
                </div>
            </div>
            <div class="relative bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg overflow-hidden">
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="relative p-8 text-white">
                    <h3 class="text-2xl font-bold mb-2">Designer Finds</h3>
                    <p class="mb-4">Pre-loved designer items at unbeatable prices</p>
                    <a href="{{ route('shop.index') }}?collection=designer" 
                       class="inline-block bg-white text-gray-900 px-6 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                        Shop Designer
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection