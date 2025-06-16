<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Product and Category routes (public)
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ProductController::class, 'show'])->name('shop.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

// Admin routes (for sellers)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class);
    
    // Quick route to add products for testing
    Route::get('/add-product', [AdminProductController::class, 'create'])->name('add-product');
});

// Static pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/orders', function () {
    return view('orders.index');
})->middleware('auth')->name('orders.index');

Route::get('/wishlist', function () {
    return view('wishlist.index');
})->middleware('auth')->name('wishlist.index');

Route::get('/settings', function () {
    return view('settings.index');
})->middleware('auth')->name('settings.index');

Route::get('/profile/show', function () {
    return view('profile.show');
})->name('profile.show');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Google OAuth routes (placeholder)
Route::get('/auth/google', function () {
    return redirect()->route('login')->with('error', 'Google OAuth not implemented yet');
})->name('auth.google');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

require __DIR__.'/auth.php';
