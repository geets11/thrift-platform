@extends('layouts.app')

@section('title', $product->name . ' - Thrift Fashion')

@section('content')
    <div class="container">
        <div class="product-detail">
            <div class="product-detail-image">
                <img src="{{ $product->image_url ?? asset('images/placeholder.jpg') }}" alt="{{ $product->name }}">
            </div>
            
            <div class="product-detail-content">
                <div class="product-detail-header">
                    <div class="product-detail-category">
                        <span class="badge">{{ $product->category }}</span>
                    </div>
                    <div class="product-detail-actions">
                        <button class="btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </button>
                        <button class="btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                        </button>
                    </div>
                </div>
                
                <h1 class="product-detail-title">{{ $product->name }}</h1>
                <p class="product-detail-price">NPR{{ number_format($product->price, 2) }}</p>
                
                <div class="product-detail-info">
                    <p>Condition: {{ $product->condition }}</p>
                    <p>Size: {{ $product->size }}</p>
                    <p>Seller: {{ $product->user->name }}</p>
                </div>
                
                <div class="product-detail-description">
                    <p>{{ $product->description }}</p>
                </div>
                
                <div class="product-detail-actions">
                    <form action="{{ route('cart.add') }}" method="POST" class="quantity-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="quantity-input">
                            <button type="button" class="quantity-btn minus" onclick="decrementQuantity()">-</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="10">
                            <button type="button" class="quantity-btn plus" onclick="incrementQuantity()">+</button>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            Add to Cart
                        </button>
                    </form>
                </div>
                
                <div class="contact-seller-card">
                    <form action="{{ route('notify.seller') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-outline btn-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            Contact Seller
                        </button>
                    </form>
                    <p class="contact-seller-note">Clicking "Contact Seller" will send a notification to the seller with your contact information.</p>
                </div>
            </div>
        </div>
        
        <div class="related-products">
            <h2 class="section-title">Related Products</h2>
            <div class="product-grid">
                @foreach($relatedProducts as $relatedProduct)
                    @include('partials.product-card', ['product' => $relatedProduct])
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function decrementQuantity() {
        const input = document.getElementById('quantity');
        const value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
        }
    }
    
    function incrementQuantity() {
        const input = document.getElementById('quantity');
        const value = parseInt(input.value);
        if (value < 10) {
            input.value = value + 1;
        }
    }
</script>
@endsection