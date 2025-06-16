<div class="product-card">
    <div class="product-image">
        <a href="{{ route('products.show', $product->id) }}">
            <img src="{{ $product->image_url ?? asset('images/placeholder.jpg') }}" alt="{{ $product->name }}">
        </a>
        <button class="wishlist-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
        </button>
    </div>
    <div class="product-content">
        <a href="{{ route('products.show', $product->id) }}" class="product-title">{{ $product->name }}</a>
        <p class="product-category">{{ $product->category }}</p>
        <p class="product-price">NPR{{ number_format($product->price, 2) }}</p>
        <p class="product-seller">Seller: {{ $product->user->name }}</p>
    </div>
    <div class="product-footer">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-primary btn-sm btn-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                Add to Cart
            </button>
        </form>
    </div>
</div>