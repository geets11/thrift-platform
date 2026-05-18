# Thrift Platform - Complete Setup & Development Guide

## Project Overview
This is a Laravel e-commerce platform for buying and selling thrift/secondhand fashion items. It includes:
- User authentication
- Product listings with images
- Shopping cart functionality
- Seller dashboard
- Admin controls

---

## Prerequisites & Installation

### Step 1: Environment Setup
```bash
# Copy .env file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database
createdb thrift_platform

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Start development server
php artisan serve
```

### Step 2: Install Dependencies
```bash
composer install
npm install
npm run dev
```

---

## Key Features & How They Work

### 1. USER AUTHENTICATION
**Location**: `app/Http/Controllers/AuthController.php`
**Database Table**: `users`
**Features**:
- User registration and login
- Email verification (optional)
- Password reset
- Role-based access (buyer, seller, admin)

### 2. PRODUCT MANAGEMENT
**Location**: `app/Http/Controllers/ProductController.php` & `app/Http/Controllers/Admin/AdminProductController.php`
**Database Table**: `products`
**Features**:
- List all products
- Filter by category
- Add/edit products (sellers only)
- Image upload handling
- Product details view

### 3. SHOPPING CART
**Location**: `app/Http/Controllers/CartController.php`
**Database Table**: `cart_items`, `carts`
**Features**:
- Add/remove items
- Update quantities
- View cart total
- Session-based cart management

### 4. CATEGORIES
**Location**: `app/Http/Controllers/CategoryController.php`
**Database Table**: `categories`
**Features**:
- Browse products by category
- Category management in admin
- Slug-based URLs

---

## File Structure Explanation

```
thrift-platform/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Login/Register
│   │   │   ├── ProductController.php       # Browse products
│   │   │   ├── CartController.php          # Shopping cart
│   │   │   ├── CategoryController.php      # Browse categories
│   │   │   └── Admin/
│   │   │       └── AdminProductController.php  # Seller dashboard
│   │   └── Requests/                       # Form validation
│   ├── Models/
│   │   ├── User.php                        # User model
│   │   ├── Product.php                     # Product model
│   │   ├── Cart.php                        # Cart model
│   │   ├── CartItem.php                    # Cart item model
│   │   └── Category.php                    # Category model
│   └── Services/
│       └── ImageUploadService.php          # Image handling
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php               # Main layout
│       ├── auth/
│       │   ├── login.blade.php             # Login page
│       │   └── register.blade.php          # Register page
│       ├── shop/
│       │   ├── index.blade.php             # Product listing
│       │   └── show.blade.php              # Product details
│       ├── cart/
│       │   └── index.blade.php             # Shopping cart
│       ├── categories/
│       │   ├── index.blade.php             # Category listing
│       │   └── show.blade.php              # Category products
│       └── admin/
│           ├── dashboard.blade.php         # Seller dashboard
│           ├── products/
│           │   ├── index.blade.php         # Manage products
│           │   ├── create.blade.php        # Add product form
│           │   └── edit.blade.php          # Edit product form
│           ├── notifications.blade.php     # Notifications
│           ├── settings.blade.php          # Account settings
│           └── users.blade.php             # User management
├── routes/
│   ├── web.php                             # Web routes
│   └── api.php                             # API routes
├── database/
│   ├── migrations/                         # Database schemas
│   └── seeders/                            # Sample data
└── public/
    ├── css/                                # Compiled CSS
    └── js/                                 # Compiled JS
```

---

## Database Schema

### Users Table
```sql
- id (primary key)
- name (string)
- email (unique string)
- password (hashed string)
- email_verified_at (timestamp, nullable)
- role (enum: buyer, seller, admin) - default: buyer
- phone (string, nullable)
- address (text, nullable)
- avatar (string, nullable)
- created_at, updated_at
```

### Products Table
```sql
- id (primary key)
- name (string)
- slug (unique string) - for URL-friendly names
- description (text)
- price (decimal 8,2)
- original_price (decimal 8,2, nullable)
- size (string, nullable)
- brand (string, nullable)
- condition (enum: new, like-new, good, fair)
- images (json) - array of image paths
- is_available (boolean)
- is_featured (boolean)
- status (enum: active, inactive, sold)
- category_id (foreign key)
- seller_id (foreign key to users)
- created_at, updated_at
```

### Categories Table
```sql
- id (primary key)
- name (string)
- slug (unique string)
- description (text, nullable)
- image (string, nullable)
- created_at, updated_at
```

### Carts Table
```sql
- id (primary key)
- user_id (foreign key)
- created_at, updated_at
```

### Cart Items Table
```sql
- id (primary key)
- cart_id (foreign key)
- product_id (foreign key)
- quantity (integer)
- created_at, updated_at
```

---

## How to Use Each Page

### Public Pages (No Login Required)

#### 1. Homepage / Shop Index
**URL**: `/shop` or `/`
**Controller**: `ProductController@index`
**What it does**:
- Shows all available products
- Allows filtering by category
- Displays 12 products per page
- Shows product price, image, and status

**Code Flow**:
```
User visits /shop
→ ProductController@index
→ Retrieves products from database
→ Returns shop/index.blade.php view
→ Browser displays product grid
```

#### 2. Product Details Page
**URL**: `/shop/{product:slug}`
**Controller**: `ProductController@show`
**What it does**:
- Shows full product details
- Displays all product images
- Shows seller info
- Add to cart button
- Shows related products

**Code Flow**:
```
User clicks on product
→ ProductController@show (passes product slug)
→ Finds product in database
→ Gets related products from same category
→ Returns shop/show.blade.php
→ Browser displays product page
```

#### 3. Categories Page
**URL**: `/categories`
**Controller**: `CategoryController@index`
**What it does**:
- Lists all product categories
- Shows category image and description

**Code Flow**:
```
User visits /categories
→ CategoryController@index
→ Gets all categories from database
→ Returns categories/index.blade.php
→ Browser shows category grid
```

#### 4. Category Products
**URL**: `/categories/{category:slug}`
**Controller**: `CategoryController@show`
**What it does**:
- Shows all products in a category
- Same filtering/pagination as shop index

---

### User Authentication (Auth Required)

#### 1. User Login
**URL**: `/login`
**Controller**: `AuthController@showLoginForm` & `AuthController@login`

**Steps**:
1. User visits `/login`
2. Enters email and password
3. System validates credentials
4. If valid: Creates session and redirects to `/shop`
5. If invalid: Shows error message

#### 2. User Registration
**URL**: `/register`
**Controller**: `AuthController@showRegisterForm` & `AuthController@register`

**Steps**:
1. User visits `/register`
2. Fills out name, email, password
3. System validates input
4. Creates new user account
5. Logs them in automatically
6. Redirects to `/shop`

---

### Shopping Cart (User Pages)

#### 1. View Cart
**URL**: `/cart`
**Controller**: `CartController@index`
**What it does**:
- Shows all items in user's cart
- Shows quantity, price, total
- Remove item button
- Update quantity button
- Proceed to checkout

**Code Flow**:
```
User clicks cart icon
→ CartController@index
→ Gets user's cart and items
→ Calculates total price
→ Returns cart/index.blade.php
→ Browser shows cart contents
```

#### 2. Add to Cart
**URL**: `/cart/{product}` (POST)
**Controller**: `CartController@add`
**What it does**:
- Adds product to user's cart
- Updates quantity if already in cart
- Returns success message

**Code Flow**:
```
User clicks "Add to Cart"
→ Form submitted to CartController@add
→ Validates quantity
→ Creates/updates cart item
→ Returns success message or redirects
```

#### 3. Update Cart
**URL**: `/cart/{cartItem}` (PATCH)
**Controller**: `CartController@update`
**What it does**:
- Updates quantity of item in cart
- Recalculates total

#### 4. Remove from Cart
**URL**: `/cart/{cartItem}` (DELETE)
**Controller**: `CartController@remove`
**What it does**:
- Removes item from cart

---

### Seller Dashboard (Auth Required + Seller Role)

#### 1. Admin Dashboard
**URL**: `/admin/dashboard`
**What it does**:
- Shows seller statistics
- Total products, active listings, sold items
- Quick action buttons
- Links to other admin pages

#### 2. Products Management
**URL**: `/admin/products`
**Controller**: `AdminProductController@index`
**What it does**:
- List all seller's products
- Edit/delete buttons
- Search functionality
- Status display

#### 3. Add New Product
**URL**: `/admin/products/create`
**Controller**: `AdminProductController@create` & `AdminProductController@store`
**Form Fields**:
- Product name
- Description
- Price
- Original price
- Size
- Brand
- Condition (dropdown)
- Category (dropdown)
- Images (upload)
- Status (active/inactive)

**Code Flow**:
```
Seller clicks "Add Product"
→ Shows AdminProductController@create view
→ Seller fills form
→ Submits to AdminProductController@store
→ Validates input
→ Uploads images
→ Saves product to database
→ Redirects to products list
```

#### 4. Edit Product
**URL**: `/admin/products/{product}/edit`
**Controller**: `AdminProductController@edit` & `AdminProductController@update`
**What it does**:
- Pre-fills form with current data
- Update any field
- Upload new images

#### 5. Delete Product
**URL**: `/admin/products/{product}` (DELETE)
**Controller**: `AdminProductController@destroy`
**What it does**:
- Removes product from database
- Deletes associated images

---

## Code Examples

### Example 1: Adding a Product (Seller)

**Controller (AdminProductController@store)**:
```php
public function store(Request $request)
{
    // Validate the input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Handle image uploads
    $images = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $images[] = $path;
        }
    }

    // Create product
    $validated['images'] = json_encode($images);
    $validated['seller_id'] = Auth::id();
    $validated['slug'] = Str::slug($validated['name']);
    
    Product::create($validated);

    return redirect()->route('admin.products.index')
                    ->with('success', 'Product added successfully!');
}
```

**Blade Form (admin/products/create.blade.php)**:
```html
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Product Name -->
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Product Name</label>
        <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg" required>
    </div>

    <!-- Description -->
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Description</label>
        <textarea name="description" class="w-full px-4 py-2 border rounded-lg" required></textarea>
    </div>

    <!-- Price -->
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Price ($)</label>
        <input type="number" name="price" step="0.01" class="w-full px-4 py-2 border rounded-lg" required>
    </div>

    <!-- Category -->
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Category</label>
        <select name="category_id" class="w-full px-4 py-2 border rounded-lg" required>
            <option value="">Select a category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Images -->
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Images</label>
        <input type="file" name="images[]" multiple accept="image/*" class="w-full px-4 py-2 border rounded-lg">
    </div>

    <!-- Submit -->
    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium">
        Add Product
    </button>
</form>
```

---

### Example 2: Browsing Products (Customer)

**Controller (ProductController@index)**:
```php
public function index()
{
    $query = Product::query();

    // Filter by category if provided
    if (request('category')) {
        $query->whereHas('category', function($q) {
            $q->where('slug', request('category'));
        });
    }

    // Get paginated results
    $products = $query->latest()->paginate(12);

    return view('shop.index', compact('products'));
}
```

**Blade View (shop/index.blade.php)**:
```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($products as $product)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
            <!-- Product Image -->
            <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                @php
                    $images = is_string($product->images) 
                        ? json_decode($product->images, true) 
                        : [];
                @endphp
                @if($images)
                    <img src="{{ asset('storage/' . $images[0]) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-64 object-cover">
                @endif
            </div>

            <!-- Product Info -->
            <div class="p-4">
                <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                <p class="text-gray-600">{{ Str::limit($product->description, 100) }}</p>
                
                <!-- Price -->
                <div class="mt-4 flex justify-between items-center">
                    <span class="text-2xl font-bold text-green-600">
                        ${{ number_format($product->price, 2) }}
                    </span>
                </div>

                <!-- View Details Button -->
                <a href="{{ route('shop.show', $product) }}" 
                   class="mt-4 block w-full text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    View Details
                </a>
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination -->
{{ $products->links() }}
```

---

### Example 3: Shopping Cart Operations

**Controller (CartController@add)**:
```php
public function add(Request $request, Product $product)
{
    // Validate quantity
    $quantity = intval($request->get('quantity', 1));
    if ($quantity < 1 || $quantity > 10) {
        $quantity = 1;
    }

    // Get or create user's cart
    $cart = Cart::firstOrCreate([
        'user_id' => Auth::id()
    ]);

    // Check if item already in cart
    $cartItem = $cart->items()->where('product_id', $product->id)->first();

    if ($cartItem) {
        // Update quantity
        $cartItem->update([
            'quantity' => $cartItem->quantity + $quantity
        ]);
    } else {
        // Create new cart item
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity
        ]);
    }

    return redirect()->route('cart.index')
                    ->with('success', 'Added to cart!');
}
```

**Blade View (cart/index.blade.php)**:
```html
@if($cartItems && $cartItems->count() > 0)
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="text-left py-2">Product</th>
                <th class="text-left py-2">Price</th>
                <th class="text-left py-2">Quantity</th>
                <th class="text-left py-2">Total</th>
                <th class="text-left py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
                <tr class="border-b">
                    <td class="py-4">{{ $item->product->name }}</td>
                    <td>${{ number_format($item->product->price, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                   class="w-20 px-2 py-1 border rounded">
                            <button type="submit" class="text-blue-600">Update</button>
                        </form>
                    </td>
                    <td>${{ number_format($item->total_price, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $item) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="text-center py-8 text-gray-600">Your cart is empty</p>
@endif
```

---

## Routes Reference

### Public Routes
```
GET  /                          → Welcome page
GET  /shop                      → Product listing
GET  /shop/{product:slug}       → Product details
GET  /categories                → Category listing
GET  /categories/{category:slug}→ Category products
```

### Auth Routes
```
GET  /login                     → Login form
POST /login                     → Process login
GET  /register                  → Register form
POST /register                  → Process registration
POST /logout                    → Logout
GET  /password/reset            → Reset password
```

### Cart Routes (Auth Required)
```
GET  /cart                      → View cart
POST /cart/{product}            → Add to cart
PATCH /cart/{cartItem}          → Update quantity
DELETE /cart/{cartItem}         → Remove from cart
```

### Admin Routes (Auth + Seller Role Required)
```
GET  /admin/dashboard           → Dashboard
GET  /admin/products            → Product list
GET  /admin/products/create     → Add product form
POST /admin/products            → Save product
GET  /admin/products/{id}/edit  → Edit product form
PATCH /admin/products/{id}      → Update product
DELETE /admin/products/{id}     → Delete product
GET  /admin/notifications       → Notifications
GET  /admin/settings            → Settings
GET  /admin/users               → User management
```

---

## Common Tasks & Solutions

### Task 1: Change Product Price
**File**: `AdminProductController@update`
**Steps**:
1. Click "Edit" on product in `/admin/products`
2. Change price field
3. Click "Save"
4. Price updates in database

### Task 2: Upload Product Images
**File**: `ImageUploadService.php`
**Steps**:
1. When adding/editing product
2. Click "Choose Files"
3. Select up to 10 images
4. Images stored in `storage/app/public/products`
5. Paths saved as JSON in products table

### Task 3: Filter Products by Category
**File**: `ProductController@index`
**Steps**:
1. Visit `/shop?category=mens`
2. Only products in that category shown
3. Filtering done server-side in database query

### Task 4: Add New Category
**File**: `CategoryController@create` (add method if needed)
**Steps**:
1. Create category via admin panel
2. Run: `php artisan db:seed CategorySeeder`
3. Or add manually in database

---

## Troubleshooting

### Images Not Displaying
**Problem**: Product images show as broken
**Solution**:
1. Check file paths in database: `php artisan tinker`
   ```php
   > Product::first()->images
   ```
2. Ensure files exist: `ls storage/app/public/products`
3. Run link command: `php artisan storage:link`

### Cart Not Working
**Problem**: Items don't save to cart
**Solution**:
1. Check user is logged in
2. Verify `cart` table exists: `php artisan migrate`
3. Check browser cookies enabled

### Products Not Showing
**Problem**: Shop page shows no products
**Solution**:
1. Add products via admin dashboard
2. Or run: `php artisan db:seed ProductSeeder`
3. Check `is_available` status is true

---

## Testing Checklist

- [ ] User can register
- [ ] User can login
- [ ] User can view products
- [ ] User can filter by category
- [ ] User can view product details
- [ ] User can add product to cart
- [ ] User can view cart
- [ ] User can update cart quantities
- [ ] User can remove cart items
- [ ] Seller can add product
- [ ] Seller can edit product
- [ ] Seller can delete product
- [ ] Images display correctly
- [ ] Prices calculate correctly
- [ ] Categories work properly

---

## Next Steps

1. **Run migrations**: `php artisan migrate`
2. **Seed data**: `php artisan db:seed` (optional)
3. **Start server**: `php artisan serve`
4. **Visit**: `http://localhost:8000`
5. **Register** as a new user
6. **Test** shopping functionality
7. **Promote** user to seller (in database/tinker)
8. **Test** product management

---

## Support

For any issues, check:
1. `.env` file configuration
2. Database connection
3. File permissions on `storage/` folder
4. Laravel logs: `storage/logs/laravel.log`

Good luck with your defense presentation!
