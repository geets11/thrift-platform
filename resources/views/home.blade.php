@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Thrift Fashion Platform</h1>
            <p class="lead mb-4">Discover unique fashion items at affordable prices. Buy, sell, and trade pre-loved clothing with our community.</p>
            <a href="{{ route('shop') }}" class="btn btn-light btn-lg">Shop Now</a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                @foreach($categories as $category)
                <div class="col-md-3">
                    <div class="category-card">
                        <h3>{{ $category->name }}</h3>
                        <p>{{ $category->description }}</p>
                        <a href="{{ route('category', $category->slug) }}" class="browse-link">Browse</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Featured Products</h2>
            <div class="row">
                @foreach($featuredProducts as $product)
                <div class="col-md-3">
                    <div class="product-card">
                        <div class="product-image" style="background-image: url('{{ asset('storage/' . $product->main_image) }}')"></div>
                        <div class="product-info">
                            <h5>{{ $product->name }}</h5>
                            <p class="text-primary fw-bold">NPR{{ number_format($product->price, 2) }}</p>
                            <p>{{ $product->gender }} • {{ $product->size }}</p>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection