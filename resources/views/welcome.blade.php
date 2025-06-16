@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <div class="hero-text">
            <h1>Find Amazing Thrift Treasures</h1>
            <p>Discover unique, pre-loved items at unbeatable prices. From vintage clothing to rare collectibles.</p>
            <div class="hero-buttons">
                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-large">Start Shopping</a>
                <a href="{{ route('register') }}" class="btn btn-secondary btn-large">Join Community</a>
            </div>
        </div>
        <div class="hero-image">
            <div class="hero-image-placeholder">
                <div class="hero-image-content">
                    <svg width="120" height="120" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 7H16V6C16 4.9 15.1 4 14 4H10C8.9 4 8 4.9 8 5V7H5C4.4 7 4 7.4 4 8S4.4 9 5 9H6V19C6 20.1 6.9 21 8 21H16C17.1 21 18 20.1 18 19V9H19C19.6 9 20 8.6 20 8S19.6 7 19 7ZM10 6H14V7H10V6ZM16 19H8V9H16V19Z" fill="rgba(255,255,255,0.8)"/>
                        <path d="M10 11V17H12V11H10ZM14 11V17H16V11H14Z" fill="rgba(255,255,255,0.8)"/>
                    </svg>
                    <h3>Thrift Store</h3>
                    <p>Sustainable Shopping</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="featured-categories">
    <div class="container">
        <h2>Shop by Category</h2>
        <div class="categories-grid">
            <div class="category-card">
                <div class="category-image-placeholder women">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 5.5V6.5L12.5 7.5C12.09 7.15 11.54 7 11 7H9C7.35 7 6 8.35 6 10V22H8V16H10V22H12V10.5L15 9.5V15L13.5 17.5V22H15.5V16L17.5 13L21 9Z" fill="white"/>
                    </svg>
                    <span>Women's Fashion</span>
                </div>
                <div class="category-info">
                    <h3>Women's Fashion</h3>
                    <p>Vintage dresses, tops, and accessories</p>
                    <a href="{{ route('shop.index') }}?category=women" class="btn btn-outline">Shop Now</a>
                </div>
            </div>
            <div class="category-card">
                <div class="category-image-placeholder men">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM15.89 8.11C15.5 7.72 14.83 7.68 14.39 8.11L13 9.5V12.5L11 10.5V7H9V10.5L7 12.5V22H9V14L11 12L13 14V22H15V12.5L16.11 11.39C16.5 11 16.89 10.61 16.89 8.11Z" fill="white"/>
                    </svg>
                    <span>Men's Fashion</span>
                </div>
                <div class="category-info">
                    <h3>Men's Fashion</h3>
                    <p>Classic shirts, jackets, and more</p>
                    <a href="{{ route('shop.index') }}?category=men" class="btn btn-outline">Shop Now</a>
                </div>
            </div>
            <div class="category-card">
                <div class="category-image-placeholder accessories">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12S6.48 22 12 22 22 17.52 22 12 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12S7.59 4 12 4 20 7.59 20 12 16.41 20 12 20ZM12 6C8.69 6 6 8.69 6 12S8.69 18 12 18 18 15.31 18 12 15.31 6 12 6ZM12 16C9.79 16 8 14.21 8 12S9.79 8 12 8 16 9.79 16 12 14.21 16 12 16Z" fill="white"/>
                    </svg>
                    <span>Accessories</span>
                </div>
                <div class="category-info">
                    <h3>Accessories</h3>
                    <p>Bags, jewelry, and unique finds</p>
                    <a href="{{ route('shop.index') }}?category=accessories" class="btn btn-outline">Shop Now</a>
                </div>
            </div>
            <div class="category-card">
                <div class="category-image-placeholder home">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 20V14H14V20H19V12H22L12 3L2 12H5V20H10Z" fill="white"/>
                    </svg>
                    <span>Home & Decor</span>
                </div>
                <div class="category-info">
                    <h3>Home & Decor</h3>
                    <p>Furniture, art, and home goods</p>
                    <a href="{{ route('shop.index') }}?category=home" class="btn btn-outline">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products">
    <div class="container">
        <h2>Featured Items</h2>
        <div class="products-grid">
            @php
                $featuredProducts = App\Models\Product::with(['category', 'seller'])
                    ->inRandomOrder()
                    ->limit(8)
                    ->get();
            @endphp
            
            @foreach($featuredProducts as $product)
                <div class="product-card">
                    <div class="product-image">
                        @if($product->images)
                            @php
                                // Handle both string and array formats safely
                                if (is_string($product->images)) {
                                    $images = json_decode($product->images, true) ?? [];
                                } else {
                                    $images = is_array($product->images) ? $product->images : [];
                                }
                                $firstImage = $images[0] ?? null;
                            @endphp
                            @if($firstImage)
                                {{-- Check if it's a URL or local path --}}
                                @if(str_starts_with($firstImage, 'http'))
                                    <img src="{{ $firstImage }}" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $product->name }}">
                                @endif
                            @else
                                <div class="image-placeholder">
                                    <div class="placeholder-content">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21 19V5C21 3.9 20.1 3 19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19ZM8.5 13.5L11 16.51L14.5 12L19 18H5L8.5 13.5Z" fill="#ccc"/>
                                        </svg>
                                        <p>{{ Str::limit($product->name, 15) }}</p>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="image-placeholder">
                                <div class="placeholder-content">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 19V5C21 3.9 20.1 3 19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19ZM8.5 13.5L11 16.51L14.5 12L19 18H5L8.5 13.5Z" fill="#ccc"/>
                                    </svg>
                                    <p>{{ Str::limit($product->name, 15) }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="product-overlay">
                            <a href="{{ route('shop.show', $product) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3>{{ $product->name }}</h3>
                        <p class="price">${{ number_format($product->price, 2) }}</p>
                        <p class="condition">{{ ucfirst(str_replace('_', ' ', $product->condition)) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center">
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-large">View All Products</a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="why-choose-us">
    <div class="container">
        <h2>Why Choose Our Thrift Platform?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon eco">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22L6.66 19.7C7.14 19.87 7.64 20 8 20C19 20 22 3 22 3C21 5 14 5.25 9 6.25C4 7.25 2 11.5 2 13.5C2 15.5 3.75 17.25 3.75 17.25C7.5 13.5 12.5 12.5 17 8Z" fill="#4CAF50"/>
                    </svg>
                </div>
                <h3>Eco-Friendly</h3>
                <p>Give items a second life and reduce waste by shopping sustainably.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon savings">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.8 10.9C9.53 10.31 8.8 9.7 8.8 8.75C8.8 7.66 9.81 6.9 11.5 6.9C13.28 6.9 13.94 7.75 14 9H16.21C16.14 7.28 15.09 5.7 13 5.19V3H10V5.16C8.06 5.58 6.5 6.84 6.5 8.77C6.5 11.08 8.41 12.23 11.2 12.9C13.7 13.5 14.2 14.38 14.2 15.31C14.2 16 13.71 17.1 11.5 17.1C9.44 17.1 8.63 16.18 8.5 15H6.32C6.44 17.19 8.08 18.42 10 18.83V21H13V18.85C14.95 18.5 16.5 17.35 16.5 15.3C16.5 12.46 14.07 11.5 11.8 10.9Z" fill="#FF9800"/>
                    </svg>
                </div>
                <h3>Amazing Prices</h3>
                <p>Find quality items at a fraction of their original retail price.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon unique">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L13.09 8.26L22 9L13.09 9.74L12 16L10.91 9.74L2 9L10.91 8.26L12 2Z" fill="#9C27B0"/>
                    </svg>
                </div>
                <h3>Unique Finds</h3>
                <p>Discover one-of-a-kind vintage and rare items you won't find anywhere else.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon community">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 4C18.2 4 20 5.8 20 8C20 10.2 18.2 12 16 12C13.8 12 12 10.2 12 8C12 5.8 13.8 4 16 4ZM8 4C10.2 4 12 5.8 12 8C12 10.2 10.2 12 8 12C5.8 12 4 10.2 4 8C4 5.8 5.8 4 8 4ZM8 14C5.33 14 0 15.33 0 18V20H16V18C16 15.33 10.67 14 8 14ZM16 14C15.71 14 15.38 14.02 15.03 14.05C16.19 14.89 17 16.02 17 17.35V20H24V18C24 15.33 18.67 14 16 14Z" fill="#2196F3"/>
                    </svg>
                </div>
                <h3>Community</h3>
                <p>Join a community of conscious shoppers and sellers making a difference.</p>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 0;
    margin-bottom: 4rem;
}

.hero-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
}

.hero-text h1 {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero-text p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.hero-image-placeholder {
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 3rem;
    text-align: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.hero-image-content h3 {
    margin: 1rem 0 0.5rem 0;
    font-size: 1.5rem;
}

.hero-image-content p {
    opacity: 0.8;
    font-size: 1rem;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    text-align: center;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    cursor: pointer;
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.1rem;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-primary:hover {
    background: #0056b3;
    transform: translateY(-2px);
}

.btn-secondary {
    background: transparent;
    color: white;
    border-color: white;
}

.btn-secondary:hover {
    background: white;
    color: #667eea;
}

.btn-outline {
    background: transparent;
    color: #333;
    border-color: #333;
}

.btn-outline:hover {
    background: #333;
    color: white;
}

/* Sections */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

section {
    margin-bottom: 4rem;
}

section h2 {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 3rem;
    color: #333;
}

/* Categories Grid */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.category-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
}

.category-image-placeholder {
    height: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 500;
    position: relative;
}

.category-image-placeholder.women {
    background: linear-gradient(135deg, #ff6b6b, #ee5a24);
}

.category-image-placeholder.men {
    background: linear-gradient(135deg, #3742fa, #2f3542);
}

.category-image-placeholder.accessories {
    background: linear-gradient(135deg, #ffa502, #ff6348);
}

.category-image-placeholder.home {
    background: linear-gradient(135deg, #7bed9f, #70a1ff);
}

.category-image-placeholder span {
    margin-top: 0.5rem;
    font-size: 1.1rem;
}

.category-info {
    padding: 1.5rem;
}

.category-info h3 {
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.category-info p {
    color: #666;
    margin-bottom: 1rem;
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.product-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    position: relative;
}

.product-card:hover {
    transform: translateY(-3px);
}

.product-image {
    position: relative;
    height: 200px;
    overflow: hidden;
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
    font-size: 0.8rem;
    font-weight: 500;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-info {
    padding: 1rem;
}

.product-info h3 {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.product-info .price {
    font-size: 1.2rem;
    font-weight: bold;
    color: #e74c3c;
    margin-bottom: 0.25rem;
}

.product-info .condition {
    font-size: 0.9rem;
    color: #666;
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.feature-card {
    text-align: center;
    padding: 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.feature-icon {
    margin-bottom: 1rem;
    display: flex;
    justify-content: center;
}

.feature-card h3 {
    font-size: 1.3rem;
    margin-bottom: 1rem;
    color: #333;
}

.feature-card p {
    color: #666;
    line-height: 1.6;
}

.text-center {
    text-align: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .hero-text h1 {
        font-size: 2rem;
    }
    
    .hero-buttons {
        justify-content: center;
    }
    
    .categories-grid,
    .products-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
    
    section h2 {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .hero-text h1 {
        font-size: 1.5rem;
    }
    
    .categories-grid,
    .products-grid {
        grid-template-columns: 1fr;
    }
    
    .btn-large {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
}
</style>
@endsection
