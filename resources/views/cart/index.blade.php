@extends('layouts.app')

@section('title', 'Shopping Cart - Thrift Platform')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>
    
    @if(isset($cartItems) && $cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    @foreach($cartItems as $item)
                        <div class="p-6 border-b border-gray-200 flex gap-4">
                            @php
                                if (is_string($item->product->images)) {
                                    $images = json_decode($item->product->images, true) ?? [];
                                } else {
                                    $images = is_array($item->product->images) ? $item->product->images : [];
                                }
                                $firstImage = $images[0] ?? null;
                            @endphp
                            
                            <div class="flex-shrink-0">
                                @if($firstImage)
                                    <img src="@if(str_starts_with($firstImage, 'http')){{ $firstImage }}@else{{ asset('storage/' . $firstImage) }}@endif" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-24 h-24 rounded-lg object-cover">
                                @else
                                    <div class="w-24 h-24 rounded-lg bg-gray-300 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                <p class="mt-1 text-sm text-gray-600">${{ number_format($item->product->price, 2) }} each</p>
                                
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="mt-2 flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="quantity" class="border border-gray-300 rounded px-2 py-1 text-sm">
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" @if($item->quantity == $i) selected @endif>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Update</button>
                                </form>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-900">${{ number_format($item->total_price, 2) }}</p>
                                
                                <form action="{{ route('cart.remove', $item) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Cart Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    
                    <div class="space-y-2 mb-4 pb-4 border-b border-gray-200">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900 font-medium">${{ number_format($total ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="text-gray-900 font-medium">$0.00</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax</span>
                            <span class="text-gray-900 font-medium">$0.00</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mb-6">
                        <span class="font-semibold text-gray-900">Total</span>
                        <span class="text-xl font-bold text-gray-900">${{ number_format($total ?? 0, 2) }}</span>
                    </div>
                    
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition duration-150 mb-2">
                        Proceed to Checkout
                    </button>
                    
                    <a href="{{ route('shop.index') }}" class="block text-center text-blue-600 hover:text-blue-700 font-medium text-sm">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5M7 13l-1.1 5m0 0h9.1M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
            <p class="text-gray-600 mb-4">Start shopping to add items to your cart</p>
            <a href="{{ route('shop.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition duration-150">
                Continue Shopping
            </a>
        </div>
    @endif
</div>
@endsection
