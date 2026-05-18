# Thrift Platform - API Reference & Code Examples

## How to Extend & Modify the Application

This document provides code examples for common modifications and extensions.

---

## 1. Creating New Features

### Example 1: Add a Product Review System

**Step 1: Create the Review Model**
```php
// app/Models/Review.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment'
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

**Step 2: Create Migration**
```bash
php artisan make:migration create_reviews_table
```

```php
// database/migrations/xxxx_xx_xx_create_reviews_table.php
public function up()
{
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->integer('rating')->between(1, 5);
        $table->text('comment')->nullable();
        $table->timestamps();
    });
}
```

**Step 3: Add Relationships**
```php
// app/Models/Product.php
public function reviews()
{
    return $this->hasMany(Review::class);
}

public function getAverageRating()
{
    return $this->reviews()->average('rating');
}
```

**Step 4: Create Controller**
```php
// app/Http/Controllers/ReviewController.php
<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500'
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        return redirect()->route('shop.show', $product)
                        ->with('success', 'Review added successfully!');
    }
}
```

**Step 5: Add Route**
```php
// routes/web.php
Route::middleware('auth')->post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store');
```

**Step 6: Update View**
```html
<!-- resources/views/shop/show.blade.php -->
<div class="reviews-section mt-8">
    <h3 class="text-2xl font-bold mb-4">Customer Reviews</h3>

    @auth
        <form action="{{ route('reviews.store', $product) }}" method="POST" class="mb-6">
            @csrf
            <div class="mb-4">
                <label class="block font-medium mb-2">Rating</label>
                <select name="rating" class="border rounded px-3 py-2">
                    <option value="">Select rating</option>
                    <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                    <option value="4">⭐⭐⭐⭐ Good</option>
                    <option value="3">⭐⭐⭐ Average</option>
                    <option value="2">⭐⭐ Poor</option>
                    <option value="1">⭐ Very Poor</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-2">Comment</label>
                <textarea name="comment" class="border rounded px-3 py-2 w-full" rows="4"></textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit Review</button>
        </form>
    @else
        <p class="mb-6"><a href="{{ route('login') }}" class="text-blue-600">Login</a> to leave a review</p>
    @endauth

    <div class="reviews-list space-y-4">
        @foreach($product->reviews as $review)
            <div class="border rounded p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium">{{ $review->user->name }}</p>
                        <p class="text-yellow-500">
                            @for($i = 0; $i < $review->rating; $i++)
                                ⭐
                            @endfor
                        </p>
                    </div>
                    <p class="text-gray-500 text-sm">{{ $review->created_at->diffForHumans() }}</p>
                </div>
                <p class="mt-2 text-gray-700">{{ $review->comment }}</p>
            </div>
        @endforeach
    </div>
</div>
```

---

### Example 2: Add a Wishlist Feature

**Step 1: Create Wishlist Model**
```php
// app/Models/Wishlist.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

**Step 2: Add to User Model**
```php
// app/Models/User.php
public function wishlist()
{
    return $this->hasMany(Wishlist::class);
}

public function hasInWishlist($product)
{
    return $this->wishlist()->where('product_id', $product->id)->exists();
}
```

**Step 3: Create Controller**
```php
// app/Http/Controllers/WishlistController.php
<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Product $product)
    {
        $exists = Wishlist::where('user_id', Auth::id())
                          ->where('product_id', $product->id)
                          ->exists();

        if ($exists) {
            Wishlist::where('user_id', Auth::id())
                   ->where('product_id', $product->id)
                   ->delete();
            return back()->with('success', 'Removed from wishlist');
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ]);
            return back()->with('success', 'Added to wishlist');
        }
    }

    public function index()
    {
        $wishlistItems = Auth::user()->wishlist()->with('product')->get();
        return view('wishlist.index', compact('wishlistItems'));
    }
}
```

**Step 4: Add Routes**
```php
// routes/web.php
Route::middleware('auth')->group(function () {
    Route::post('/wishlist/{product}/toggle', [WishlistController::class, 'toggle'])
        ->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');
});
```

---

## 2. Database Modifications

### Example: Add Discount System

**Create Migration**
```bash
php artisan make:migration add_discounts_to_products
```

```php
// database/migrations/xxxx_xx_xx_add_discounts_to_products.php
public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->decimal('discount_percent', 5, 2)->default(0);
        $table->timestamp('discount_until')->nullable();
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['discount_percent', 'discount_until']);
    });
}
```

**Update Product Model**
```php
// app/Models/Product.php
public function getFinalPriceAttribute()
{
    if ($this->discount_percent > 0 && 
        $this->discount_until && 
        $this->discount_until > now()) {
        $discount = $this->price * ($this->discount_percent / 100);
        return $this->price - $discount;
    }
    return $this->price;
}

public function getDiscountSavingsAttribute()
{
    if ($this->discount_percent > 0) {
        return $this->price * ($this->discount_percent / 100);
    }
    return 0;
}
```

---

## 3. Authentication Customization

### Example: Add Seller Verification

**Create Migration**
```bash
php artisan make:migration add_seller_verification_to_users
```

```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('seller_status')->default('unverified'); // unverified, pending, verified
        $table->string('seller_document')->nullable(); // URL to verification document
        $table->text('seller_notes')->nullable();
        $table->timestamp('seller_verified_at')->nullable();
    });
}
```

**Update User Model**
```php
// app/Models/User.php
public function isVerifiedSeller()
{
    return $this->seller_status === 'verified';
}

public function isPendingSeller()
{
    return $this->seller_status === 'pending';
}
```

**Protect Routes**
```php
// routes/web.php
Route::middleware(['auth', 'seller.verified'])->prefix('admin')->group(function () {
    // Only verified sellers can access
    Route::resource('products', AdminProductController::class);
});
```

**Create Middleware**
```php
// app/Http/Middleware/VerifiedSeller.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifiedSeller
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isVerifiedSeller()) {
            return redirect('/')->with('error', 'You must be a verified seller');
        }

        return $next($request);
    }
}
```

---

## 4. API Endpoints (if building an API)

### Example: Create Product API

```php
// routes/api.php
Route::get('/products', [ProductController::class, 'apiIndex']);
Route::get('/products/{product:slug}', [ProductController::class, 'apiShow']);
```

```php
// Add to ProductController
public function apiIndex()
{
    return response()->json([
        'success' => true,
        'data' => Product::with(['category', 'seller'])->paginate(20)
    ]);
}

public function apiShow(Product $product)
{
    return response()->json([
        'success' => true,
        'data' => $product->load(['category', 'seller', 'reviews'])
    ]);
}
```

---

## 5. Email Notifications

### Example: Send Email When Product is Sold

**Create Mailable**
```bash
php artisan make:mail ProductSoldNotification
```

```php
// app/Mail/ProductSoldNotification.php
<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductSoldNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Product $product)
    {
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Your product ' . $this->product->name . ' has been sold!',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.product-sold',
        );
    }
}
```

**Create View**
```html
<!-- resources/views/emails/product-sold.blade.php -->
<h1>Product Sold!</h1>
<p>Congratulations! Your product "{{ $product->name }}" has been sold.</p>
<p>Price: ${{ number_format($product->price, 2) }}</p>
<p>Buyer will contact you soon.</p>
```

**Send Email**
```php
// In AdminProductController@update
Mail::to($product->seller->email)
    ->send(new ProductSoldNotification($product));
```

---

## 6. Laravel Blade Tips

### Useful Helpers

**Format Currency**
```html
{{ number_format($product->price, 2) }}  <!-- Output: 29.99 -->
```

**Format Date**
```html
{{ $product->created_at->format('M d, Y') }}  <!-- Output: Jan 15, 2024 -->
```

**Time Ago**
```html
{{ $product->created_at->diffForHumans() }}  <!-- Output: 2 days ago -->
```

**Conditional Rendering**
```html
@if($product->is_available)
    <span class="text-green-600">In Stock</span>
@else
    <span class="text-red-600">Out of Stock</span>
@endif
```

**Loop with Index**
```html
@foreach($products as $index => $product)
    <p>{{ $index + 1 }}. {{ $product->name }}</p>
@endforeach
```

**Check User Role**
```html
@if(Auth::user() && Auth::user()->isSeller())
    <a href="{{ route('admin.dashboard') }}">Go to Dashboard</a>
@endif
```

---

## 7. Common Issues & Solutions

### Issue 1: "Column not found" Error
**Cause**: Database migration not run
**Solution**:
```bash
php artisan migrate
```

### Issue 2: "Route not defined" Error
**Cause**: Route name mismatch
**Solution**:
```bash
php artisan route:list  # See all available routes
```

### Issue 3: "CSRF token mismatch"
**Cause**: Missing @csrf in form
**Solution**:
```html
<form method="POST">
    @csrf  <!-- Add this line -->
    <!-- form fields -->
</form>
```

### Issue 4: Images not displaying
**Cause**: Storage link not created
**Solution**:
```bash
php artisan storage:link
```

---

## 8. Performance Tips

**Use Eager Loading**
```php
// Bad: N+1 query problem
$products = Product::all();
foreach ($products as $product) {
    echo $product->category->name;  // Extra query for each product
}

// Good: Load category with products
$products = Product::with('category')->get();
```

**Use Pagination**
```php
// Bad: Load all records
$products = Product::all();

// Good: Load only needed records
$products = Product::paginate(12);
```

**Cache Queries**
```php
// Cache for 1 hour
$categories = cache()->remember('categories', 3600, function () {
    return Category::where('is_active', true)->get();
});
```

---

Good luck with your project! These examples show how to extend and customize the platform for your specific needs.
