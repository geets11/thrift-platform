@extends('layouts.app')

@section('title', 'Sell Your Item - Thrift Fashion')

@section('content')
    <div class="container">
        <div class="sell-container">
            <h1 class="page-title">Sell Your Item</h1>
            
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="sell-form">
                @csrf
                
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Vintage Denim Jacket" required>
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Describe your item, including any flaws or wear..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price (NPR)</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
                        @error('price')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="men" {{ old('category') == 'men' ? 'selected' : '' }}>Men</option>
                            <option value="women" {{ old('category') == 'women' ? 'selected' : '' }}>Women</option>
                            <option value="kids" {{ old('category') == 'kids' ? 'selected' : '' }}>Kids</option>
                            <option value="accessories" {{ old('category') == 'accessories' ? 'selected' : '' }}>Accessories</option>
                            <option value="bags" {{ old('category') == 'bags' ? 'selected' : '' }}>Bags</option>
                        </select>
                        @error('category')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="condition">Condition</label>
                        <select id="condition" name="condition" required>
                            <option value="" disabled selected>Select condition</option>
                            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New with tags</option>
                            <option value="like-new" {{ old('condition') == 'like-new' ? 'selected' : '' }}>Like New</option>
                            <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
                            <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                        </select>
                        @error('condition')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="size">Size</label>
                        <select id="size" name="size" required>
                            <option value="" disabled selected>Select size</option>
                            <option value="xs" {{ old('size') == 'xs' ? 'selected' : '' }}>XS</option>
                            <option value="s" {{ old('size') == 's' ? 'selected' : '' }}>S</option>
                            <option value="m" {{ old('size') == 'm' ? 'selected' : '' }}>M</option>
                            <option value="l" {{ old('size') == 'l' ? 'selected' : '' }}>L</option>
                            <option value="xl" {{ old('size') == 'xl' ? 'selected' : '' }}>XL</option>
                            <option value="one-size" {{ old('size') == 'one-size' ? 'selected' : '' }}>One Size</option>
                        </select>
                        @error('size')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="image">Product Images</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                    <p class="form-help">Upload an image of your item. Maximum file size: 2MB.</p>
                    @error('image')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">List Item for Sale</button>
            </form>
        </div>
    </div>
@endsection