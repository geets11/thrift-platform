@extends('layouts.app')

@section('content')
<div class="shop-header">
    <div class="container">
        <h1>Thrift Shop</h1>
        <p>Discover amazing pre-loved treasures at unbeatable prices</p>
    </div>
</div>

<div class="container">
    <div class="products-layout">
        <div class="filters-sidebar">
            <div class="filters-card">
                <h2 class="filters-title">Filters</h2>
                
                <form action="{{ route('shop.index') }}" method="GET" id="filtersForm">
                    <div class="filter-group">
                        <label for="search">Search</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search products...">
                    </div>
                    
                    <div class="filter-group">
                        <label for="category">Category</label>
                        <select id="category" name="category">
                            <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All Categories</option>
                            <option value="men" {{ request('category') == 'men' ? 'selected' : '' }}>Men</option>
                            <option value="women" {{ request('category') == 'women' ? 'selected' : '' }}>Women</option>
                            <option value="kids" {{ request('category') == 'kids' ? 'selected' : '' }}>Kids</option>
                            <option value="accessories" {{ request('category') == 'accessories' ? 'selected' : '' }}>Accessories</option>
                            <option value="home" {{ request('category') == 'home' ? 'selected' : '' }}>Home & Decor</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="condition">Condition</label>
                        <select id="condition" name="condition">
                            <option value="all" {{ request('condition') == 'all' ? 'selected' : '' }}>All Conditions</option>
                            <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="like_new" {{ request('condition') == 'like_new' ? 'selected' : '' }}>Like New</option>
                            <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Good</option>
                            <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="price_min">Min Price</label>
                        <input type="number" id="price_min" name="price_min" value="{{ request('price_min') }}" placeholder="0" min="0" step="0.01">
                    </div>
                    
                    <div class="filter-group">
                        <label for="price_max">Max Price</label>
                        <input type="number" id="price_max" name="price_max" value="{{ request('price_max') }}" placeholder="1000" min="0" step="0.01">
                    </div>
                    
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('shop.index') }}" class="btn btn-secondary">Clear All</a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="products-grid">
            @if(isset($products) && $products->count() > 0)
                <div class="products-results">
                    <div class="results-header">
                        <p>Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                        <div class="sort-options">
                            <select name="sort" onchange="this.form.submit()">
                                <option value="latest">Latest</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                                <option value="name">Name A-Z</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="products-container">
                        @foreach($products as $product)
                            <div class="product-card">
                                <div class="product-image">
                                    @if($product->images)
                                        @php
                                            $images = json_decode($product->images, true);
                                            $firstImage = $images[0] ?? null;
                                        @endphp
                                        @if($firstImage)
                                            <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $product->name }}" loading="lazy">
                                        @else
                                            {{-- CSS-based placeholder instead of placeholder.svg --}}
                                            <div class="image-placeholder">
                                                <div class="placeholder-content">
                                                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M21 19V5C21 3.9 20.1 3 19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19ZM8.5 13.5L11 16.51L14.5 12L19 18H5L8.5 13.5Z" fill="#ccc"/>
                                                    </svg>
                                                    <p>{{ $product->name }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        {{-- CSS-based placeholder instead of placeholder.svg --}}
                                        <div class="image-placeholder">
                                            <div class="placeholder-content">
                                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M21 19V5C21 3.9 20.1 3 19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19ZM8.5 13.5L11 16.51L14.5 12L19 18H5L8.5 13.5Z" fill="#ccc"/>
                                                </svg>
                                                <p>{{ $product->name }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="product-badges">
                                        <span class="condition-badge condition-{{ $product->condition }}">
                                            {{ ucfirst(str_replace('_', ' ', $product->condition)) }}
                                        </span>
                                        @if($product->created_at->diffInDays() < 7)
                                            <span class="new-badge">New</span>
                                        @endif
                                    </div>
                                    
                                    <div class="product-overlay">
                                        <div class="overlay-buttons">
                                            <a href="{{ route('shop.show', $product) }}" class="btn btn-primary">View Details</a>
                                            @auth
                                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary">Add to Cart</button>
                                                </form>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="product-info">
                                    <h3 class="product-name">{{ $product->name }}</h3>
                                    <p class="product-price">${{ number_format($product->price, 2) }}</p>
                                    <p class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                    <p class="product-seller">by {{ $product->seller->name ?? 'Unknown' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="pagination-wrapper">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="no-products">
                    <div class="no-products-icon">
                        <svg width="100" height="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z" fill="#ddd"/>
                        </svg>
                    </div>
                    <h3>No products found</h3>
                    <p>Try adjusting your filters or search terms.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">View All Products</a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.shop-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    padding: 3rem 0;
    margin-bottom: 2rem;
    text-align: center;
}

.shop-header h1 {
    font-size: 3rem;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.shop-header p {
    font-size: 1.2rem;
    opacity: 0.9;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.products-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
}

.filters-sidebar {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    height: fit-content;
    position: sticky;
    top: 2rem;
}

.filters-title {
    margin-bottom: 1.5rem;
    color: #333;
    font-size: 1.3rem;
    font-weight: 600;
}

.filter-group {
    margin-bottom: 1.5rem;
}

.filter-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #555;
}

.filter-group input,
.filter-group select {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 0.9rem;
    background: white;
    transition: border-color 0.3s ease;
}

.filter-group input:focus,
.filter-group select:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
    flex-direction: column;
}

.results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f8f9fa;
}

.results-header p {
    color: #666;
    font-weight: 500;
}

.sort-options select {
    padding: 0.5rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 6px;
    background: white;
}

.products-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.product-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.product-image {
    position: relative;
    height: 250px;
    overflow: hidden;
    background: #f8f9fa;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

/* CSS-based image placeholder */
.image-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}

.placeholder-content {
    text-align: center;
    padding: 1rem;
}

.placeholder-content p {
    margin-top: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: #6c757d;
}

.product-badges {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    z-index: 2;
}

.condition-badge {
    background: rgba(255,255,255,0.9);
    color: #333;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
}

.condition-new { background: rgba(40, 167, 69, 0.9); color: white; }
.condition-like_new { background: rgba(23, 162, 184, 0.9); color: white; }
.condition-good { background: rgba(255, 193, 7, 0.9); color: #333; }
.condition-fair { background: rgba(220, 53, 69, 0.9); color: white; }

.new-badge {
    background: #ff6b6b;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.overlay-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.product-info {
    padding: 1.25rem;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
    line-height: 1.3;
}

.product-price {
    font-size: 1.3rem;
    font-weight: bold;
    color: #e74c3c;
    margin-bottom: 0.5rem;
}

.product-category,
.product-seller {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 0.25rem;
}

.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-primary:hover {
    background: #0056b3;
    transform: translateY(-1px);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #545b62;
}

.no-products {
    text-align: center;
    padding: 4rem 2rem;
    color: #666;
    grid-column: 1 / -1;
}

.no-products-icon {
    margin-bottom: 2rem;
    opacity: 0.7;
}

.no-products h3 {
    margin-bottom: 1rem;
    color: #333;
    font-size: 1.5rem;
}

.no-products p {
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.pagination-wrapper {
    margin-top: 3rem;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .products-layout {
        grid-template-columns: 1fr;
    }
    
    .filters-sidebar {
        order: 2;
        margin-top: 2rem;
        position: static;
    }
    
    .products-grid {
        order: 1;
    }
    
    .results-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .products-container {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
    
    .shop-header h1 {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .products-container {
        grid-template-columns: 1fr;
    }
    
    .overlay-buttons {
        flex-direction: row;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }
}
</style>
@endsection
