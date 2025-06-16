@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">{{ $category->name }}</h1>
        <p class="lead mb-4">{{ $category->description }}</p>
        
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 mb-4">
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
                        No products found in this category yet.
                    </div>
                </div>
            @endforelse
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection