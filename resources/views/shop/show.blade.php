@extends('layouts.app')

@section('title', $product->name . ' - Thrift Platform')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Images -->
        <div>
            @if($product->images && count($product->images) > 0)
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden">
                        <img id="main-image" 
                             src="{{ $product->images[0] }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-96 object-cover">
                    </div>
                    
                    <!-- Thumbnail Images -->
                    @if(count($product->images) > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($product->images as $index => $image)
                                <button onclick="changeMainImage('{{ $image }}')" 
                                        class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden hover:opacity-75 transition">
                                    <img src="{{ $image }}" 
                                         alt="{{ $product->name }} {{ $index + 1 }}" 
                                         class="w-full h-20 object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="space-y-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="text-lg text-gray-600 mt-2">{{ $product->category->name }}</p>
            </div>

            <!-- Price -->
            <div class="flex items-center space-x-4">
                <span class="text-3xl font-bold text-green-600">${{ number_format($product->price, 2) }}</span>
                @if($product->original_price && $product->original_price > $product->price)
                    <span class="text-xl text-gray-500 line-through">${{ number_format($product->original_price, 2) }}</span>
                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-medium">
                        Save {{ $product->discount_percentage }}%
                    </span>
                @endif
            </div>

            <!-- Product Info -->
            <div class="grid grid-cols-2 gap-4 py-4 border-t border-b border-gray-200">
                @if($product->brand)
                    <div>
                        <span class="text-sm font-medium text-gray-900">Brand:</span>
                        <span class="text-sm text-gray-600 ml-2">{{ $product->brand }}</span>
                    </div>
                @endif
                
                @if($product->size)
                    <div>
                        <span class="text-sm font-medium text-gray-900">Size:</span>
                        <span class="text-sm text-gray-600 ml-2">{{ $product->size }}</span>
                    </div>
                @endif
                
                <div>
                    <span class="text-sm font-medium text-gray-900">Condition:</span>
                    <span class="text-sm text-gray-600 ml-2 capitalize">{{ str_replace('_', ' ', $product->condition) }}</span>
                </div>
                
                <div>
                    <span class="text-sm font-medium text-gray-900">Seller:</span>
                    <span class="text-sm text-gray-600 ml-2">{{ $product->seller->name }}</span>
                </div>
            </div>

            <!-- Description -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
            </div>

            <!-- Add to Cart -->
            @if($product->is_available)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex items-center space-x-4">
                        <label for="quantity" class="text-sm font-medium text-gray-900">Quantity:</label>
                        <select name="quantity" id="quantity" class="border border-gray-300 rounded px-3 py-1">
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition duration-150">
                        Add to Cart
                    </button>
                </form>
            @else
                <div class="bg-gray-100 text-gray-600 px-6 py-3 rounded-lg text-center">
                    This item is no longer available
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">You might also like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                            <img src="{{ $relatedProduct->first_image }}" 
                                 alt="{{ $relatedProduct->name }}" 
                                 class="w-full h-48 object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-900 mb-2">{{ $relatedProduct->name }}</h3>
                            <p class="text-green-600 font-bold">${{ number_format($relatedProduct->price, 2) }}</p>
                            <a href="{{ route('shop.show', $relatedProduct) }}" 
                               class="mt-2 block text-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded text-sm transition">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function changeMainImage(imageSrc) {
    document.getElementById('main-image').src = imageSrc;
}
</script>
@endsection