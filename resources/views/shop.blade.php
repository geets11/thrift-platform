@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Shop</h1>
        
        <div class="row">
            <!-- Filters -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Filters</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('shop') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">All</option>
                                    <option value="men" {{ request('gender') == 'men' ? 'selected' : '' }}>Men</option>
                                    <option value="women" {{ request('gender') == 'women' ? 'selected' : '' }}>Women</option>
                                    <option value="kids" {{ request('gender') == 'kids' ? 'selected' : '' }}>Kids</option>
                                    <option value="unisex" {{ request('gender') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Price Range</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}">
                                    </div>
                                    <div class="col">
                                        <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Sort By</label>
                                <select name="sort" class="form-select">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Products -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="mb-0">Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }} products</p>
                    
                    <div class="input-group" style="width: 300px;">
                        <form action="{{ route('shop') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </form>
                    </div>
                </div>
                
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="product-card h-100">
                                <div class="product-image" style="background-image: url('{{ asset('storage/' . $product->main_image) }}')"></div>
                                <div class="product-info">
                                    <h5>{{ $product->name }}</h5>
                                    <p class="text-primary fw-bold">NPR{{ number_format($product->price, 2) }}</p>
                                    <p>{{ ucfirst($product->gender) }} • {{ $product->size }}</p>
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                No products found. Try adjusting your filters.
                            </div>
                        </div>
                    @endforelse
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection