# Thrift Platform - Architecture & Flow Diagrams

## 1. Application Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                     THRIFT PLATFORM                         │
│                   E-Commerce System                         │
└─────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│                      CLIENT LAYER                            │
│  (Web Browser - HTML, CSS, JavaScript)                       │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │ Public Pages          │ User Pages   │ Seller Pages │  │
│  │ • Shop listing        │ • Cart       │ • Dashboard  │  │
│  │ • Categories          │ • Checkout   │ • Products   │  │
│  │ • Product details     │ • Account    │ • Orders     │  │
│  │ • Auth pages          │              │              │  │
│  └──────────────────────────────────────────────────────┘  │
└──────────────────────────────────────────────────────────────┘
                            ↕
                    HTTP Requests/Responses
                            ↕
┌──────────────────────────────────────────────────────────────┐
│                    APPLICATION LAYER                         │
│                   (PHP / Laravel)                            │
│                                                              │
│  ┌─────────────────────────────────────────────────────┐   │
│  │              ROUTING (routes/web.php)               │   │
│  │  Directs requests to appropriate controller         │   │
│  └─────────────────────────────────────────────────────┘   │
│                            ↓                                 │
│  ┌─────────────────────────────────────────────────────┐   │
│  │            CONTROLLERS (HTTP Layer)                 │   │
│  │  • ProductController       • CartController         │   │
│  │  • CategoryController      • AdminProductController │   │
│  │  • AuthController                                   │   │
│  │                                                     │   │
│  │  Handle: Validation, Logic, Response               │   │
│  └─────────────────────────────────────────────────────┘   │
│                            ↓                                 │
│  ┌─────────────────────────────────────────────────────┐   │
│  │              MODELS (Business Logic)                │   │
│  │  • Product  • Cart    • CartItem                    │   │
│  │  • User     • Category                              │   │
│  │                                                     │   │
│  │  Handle: Data manipulation, Relationships           │   │
│  └─────────────────────────────────────────────────────┘   │
│                            ↓                                 │
│  ┌─────────────────────────────────────────────────────┐   │
│  │          SERVICES (Utilities)                       │   │
│  │  • ImageUploadService - File handling               │   │
│  └─────────────────────────────────────────────────────┘   │
└──────────────────────────────────────────────────────────────┘
                            ↕
                    SQL Queries
                            ↕
┌──────────────────────────────────────────────────────────────┐
│                    DATA LAYER                                │
│                 (Database + Storage)                         │
│                                                              │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────┐  │
│  │  MySQL/      │  │    File      │  │    Sessions      │  │
│  │  PostgreSQL  │  │   Storage    │  │    Cache         │  │
│  │              │  │              │  │                  │  │
│  │ • Products   │  │ • Images     │  │ • User login     │  │
│  │ • Users      │  │ • Documents  │  │ • Cart data      │  │
│  │ • Carts      │  │              │  │                  │  │
│  │ • Categories │  │              │  │                  │  │
│  └──────────────┘  └──────────────┘  └──────────────────┘  │
└──────────────────────────────────────────────────────────────┘
```

---

## 2. Request/Response Flow

### Example: Customer Adds Product to Cart

```
USER INTERACTION:
┌─────────────────────────────────────┐
│ Customer clicks "Add to Cart"        │
│ • Product ID: 5                     │
│ • Quantity: 2                       │
└─────────────────────────────────────┘
              ↓
BROWSER:
┌─────────────────────────────────────┐
│ POST /cart/5                        │
│ Form Data:                          │
│ • quantity = 2                      │
│ • CSRF token                        │
└─────────────────────────────────────┘
              ↓
ROUTING:
┌─────────────────────────────────────┐
│ routes/web.php                      │
│ Match: POST /cart/{product}         │
│ → CartController@add()              │
└─────────────────────────────────────┘
              ↓
CONTROLLER:
┌─────────────────────────────────────┐
│ CartController@add()                │
│ 1. Validate quantity (1-10)         │
│ 2. Check if product available       │
│ 3. Check if in cart already         │
│ 4. Create/Update CartItem           │
│ 5. Update session cart count        │
└─────────────────────────────────────┘
              ↓
MODEL:
┌─────────────────────────────────────┐
│ CartItem::create([                  │
│   'cart_id' => ...,                 │
│   'product_id' => 5,                │
│   'quantity' => 2                   │
│ ])                                  │
└─────────────────────────────────────┘
              ↓
DATABASE:
┌─────────────────────────────────────┐
│ INSERT INTO cart_items              │
│ VALUES (NULL, 1, 5, 2, ...)         │
└─────────────────────────────────────┘
              ↓
RESPONSE:
┌─────────────────────────────────────┐
│ Redirect to cart/show               │
│ Message: "Added to cart!"           │
│ HTTP 302 Redirect                   │
└─────────────────────────────────────┘
              ↓
BROWSER:
┌─────────────────────────────────────┐
│ Display cart page                   │
│ Show cart item with qty 2           │
│ Display success message             │
└─────────────────────────────────────┘
```

---

## 3. Database Relationships

### Entity Relationship Diagram

```
┌──────────────────┐         ┌──────────────────┐
│     USERS        │         │   CATEGORIES     │
├──────────────────┤         ├──────────────────┤
│ id (PK)          │         │ id (PK)          │
│ name             │         │ name             │
│ email            │         │ slug             │
│ password         │         │ description      │
│ role             │         │ image            │
│ created_at       │         │ is_active        │
└────────┬─────────┘         └──────────────────┘
         │                            ▲
         │ seller_id                  │ category_id
         │                            │
    1:N  │                        1:N │
         │                            │
         │    ┌──────────────────────┐│
         └───→│     PRODUCTS         ││
              ├──────────────────────┤│
              │ id (PK)              ││
              │ name                 ││
              │ slug                 ││
              │ description          ││
              │ price                ││
              │ original_price       ││
              │ size, brand          ││
              │ condition            ││
              │ images (JSON)        ││
              │ status               ││
              │ seller_id (FK)       ││
              │ category_id (FK)     ││
              └──────────┬───────────┘│
                         │            │
         1:N          1:N│            │
         │                │            │
         │ user_id        │            │
         │        product_id           │
         │                │            │
         ▼                ▼            │
    ┌──────────────┐  ┌────────────────┘
    │    CARTS     │  │
    ├──────────────┤  │
    │ id (PK)      │  │
    │ user_id (FK) │  │
    │ created_at   │  │
    └────────┬─────┘  │
             │        │
        1:N  │        │
             │        │
             ▼        │
    ┌──────────────────────┐
    │   CART_ITEMS         │
    ├──────────────────────┤
    │ id (PK)              │
    │ cart_id (FK)  ───┐   │
    │ product_id (FK)──┼───┘
    │ quantity         │
    │ created_at       │
    └──────────────────┘
```

### What Each Line Means:

```
User ──1:N──→ Products    : One user creates many products (as seller)
User ──1:1──→ Cart        : One user has one cart
Cart ──1:N──→ CartItems   : One cart has many items
CartItem ──N:1──→ Product : Many items reference one product
Product ──N:1──→ Category : Many products in one category
Product ──N:1──→ User     : Many products by one seller
```

---

## 4. File Structure & Relationships

```
PROJECT ROOT
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ProductController.php
│   │   │   │   └── Methods: index(), show()
│   │   │   │
│   │   │   ├── CartController.php
│   │   │   │   └── Methods: index(), add(), update(), remove()
│   │   │   │
│   │   │   ├── CategoryController.php
│   │   │   │   └── Methods: index(), show()
│   │   │   │
│   │   │   └── Admin/
│   │   │       └── AdminProductController.php
│   │   │           └── Methods: create(), store(), edit(), update(), destroy()
│   │   │
│   │   └── Requests/ (Form validation)
│   │
│   ├── Models/
│   │   ├── Product.php ←→ relationships: category(), seller(), cartItems()
│   │   ├── User.php ←→ relationships: products(), cart()
│   │   ├── Cart.php ←→ relationships: user(), items()
│   │   ├── CartItem.php ←→ relationships: cart(), product()
│   │   └── Category.php ←→ relationships: products()
│   │
│   └── Services/
│       └── ImageUploadService.php (File handling)
│
├── routes/
│   └── web.php (All route definitions)
│
├── resources/
│   ├── views/
│   │   ├── shop/
│   │   │   ├── index.blade.php ← ProductController@index
│   │   │   └── show.blade.php ← ProductController@show
│   │   │
│   │   ├── cart/
│   │   │   └── index.blade.php ← CartController@index
│   │   │
│   │   ├── categories/
│   │   │   ├── index.blade.php ← CategoryController@index
│   │   │   └── show.blade.php ← CategoryController@show
│   │   │
│   │   └── admin/
│   │       ├── dashboard.blade.php ← Dashboard view
│   │       └── products/
│   │           ├── index.blade.php ← AdminProductController@index
│   │           ├── create.blade.php ← AdminProductController@create
│   │           └── edit.blade.php ← AdminProductController@edit
│   │
│   └── css/
│       └── app.css (Tailwind CSS)
│
└── database/
    ├── migrations/ (Database schemas)
    └── seeders/ (Sample data)
```

---

## 5. User Roles & Permissions

```
┌────────────────────────────────────────────────────────────┐
│                    USER ROLES                              │
└────────────────────────────────────────────────────────────┘

BUYER (Default Role)
├── ✅ Browse products
├── ✅ View product details
├── ✅ Search & filter products
├── ✅ Add items to cart
├── ✅ Manage shopping cart
├── ✅ View cart total
├── ❌ Add products
├── ❌ Edit products
└── ❌ Access admin panel

SELLER (role = 'seller')
├── ✅ All BUYER permissions
├── ✅ Access seller dashboard
├── ✅ View their products
├── ✅ Add new products
├── ✅ Edit their products
├── ✅ Delete their products
├── ✅ Upload images
├── ✅ View sales statistics
├── ❌ Manage other sellers
└── ❌ Manage users

ADMIN (role = 'admin')
├── ✅ All SELLER permissions
├── ✅ Manage all users
├── ✅ Manage all products
├── ✅ Access system settings
├── ✅ View platform statistics
├── ✅ Moderate content
└── ✅ System configuration
```

---

## 6. Page Flow Diagram

```
                        ┌─────────────┐
                        │   WELCOME   │
                        │   PAGE ("/")│
                        └──────┬──────┘
                               │
                ┌──────────────┼──────────────┐
                │              │              │
                ▼              ▼              ▼
         ┌──────────────┐┌──────────────┐┌──────────────┐
         │   REGISTER   ││    LOGIN     ││   SHOP       │
         │  ("/register")│  ("/login")   │  ("/shop")   │
         └────┬─────────┘└──────┬───────┘└──────┬───────┘
              │                 │               │
              └─────────────────┼───────────────┘
                                │
                     ┌──────────┴──────────┐
                     │                     │
                     ▼                     ▼
            ┌─────────────────┐   ┌──────────────────┐
            │  PRODUCT DETAIL │   │   CATEGORIES     │
            │  ("/shop/:id")  │   │  ("/categories") │
            └────┬────────────┘   └────────┬─────────┘
                 │                         │
                 └─────────────┬───────────┘
                               │
                               ▼
                      ┌─────────────────┐
                      │  ADD TO CART    │
                      │  (POST /cart)   │
                      └────────┬────────┘
                               │
                               ▼
                      ┌─────────────────┐
                      │  SHOPPING CART  │
                      │  ("/cart")      │
                      └────────┬────────┘
                               │
                    ┌──────────┴──────────┐
                    │                     │
                    ▼                     ▼
        ┌─────────────────────┐  ┌──────────────────┐
        │ UPDATE CART ITEM    │  │ REMOVE FROM CART │
        │ (PATCH /cart/:id)   │  │ (DELETE /cart)   │
        └─────────────────────┘  └──────────────────┘
                    │                     │
                    └──────────┬──────────┘
                               │
                    (IF SELLER PROMOTED)
                               │
                               ▼
                      ┌─────────────────────┐
                      │ SELLER DASHBOARD    │
                      │ ("/admin/dashboard")│
                      └────────┬────────────┘
                               │
                ┌──────────────┼──────────────┐
                │              │              │
                ▼              ▼              ▼
         ┌────────────┐┌──────────────┐┌─────────────┐
         │  PRODUCTS  ││ ADD PRODUCT  ││ EDIT PRODUCT│
         │  MANAGEMENT││  ("/admin/   ││  ("/admin/  │
         │ ("/admin/  ││   products/  ││   products/ │
         │ products") ││   create")   ││   :id/edit")│
         └────────────┘└──────────────┘└─────────────┘
```

---

## 7. Authentication Flow

```
REGISTRATION FLOW:
┌─────────────┐
│   User      │
│  Submits    │
│  Register   │
│   Form      │
└──────┬──────┘
       │ POST /register
       ▼
┌──────────────────────┐
│ Validate Input:      │
│ • Email required     │
│ • Email unique       │
│ • Password > 8 chars │
└──────┬───────────────┘
       │
       ├─ INVALID ─→ Show errors, redirect back
       │
       └─ VALID ─→
              │
              ▼
       ┌─────────────────┐
       │ Hash Password   │
       │ (bcrypt)        │
       └────────┬────────┘
                │
                ▼
       ┌─────────────────┐
       │ Create User     │
       │ in Database     │
       └────────┬────────┘
                │
                ▼
       ┌──────────────────┐
       │ Create Session   │
       │ Log User In      │
       └────────┬─────────┘
                │
                ▼
       ┌──────────────────┐
       │ Redirect to Shop │
       │ (Authenticated)  │
       └──────────────────┘

LOGIN FLOW:
┌──────────────┐
│  User Login  │
│    Form      │
└──────┬───────┘
       │ POST /login
       ▼
┌─────────────────────────┐
│ Find User by Email      │
└──────┬──────────────────┘
       │
       ├─ NOT FOUND ─→ Show error, redirect back
       │
       └─ FOUND ─→
              │
              ▼
       ┌──────────────────────┐
       │ Verify Password Hash │
       └──────┬───────────────┘
              │
              ├─ INVALID ─→ Show error, redirect back
              │
              └─ VALID ─→
                     │
                     ▼
              ┌─────────────────┐
              │ Create Session  │
              │ Log User In     │
              └────────┬────────┘
                       │
                       ▼
              ┌──────────────────┐
              │ Redirect to Shop │
              │ or Cart          │
              └──────────────────┘
```

---

## 8. Image Upload & Storage Flow

```
USER UPLOADS IMAGES:
┌──────────────────────────┐
│ Seller selects           │
│ images from computer     │
│ (up to 10 images)        │
└──────────┬───────────────┘
           │ POST /admin/products/create
           ▼
┌─────────────────────────────┐
│ Browser sends files         │
│ via multipart/form-data     │
└──────────┬──────────────────┘
           │
           ▼
┌──────────────────────────────┐
│ AdminProductController       │
│ Validates each file:         │
│ • Is image? (JPEG, PNG, GIF) │
│ • Size < 2MB?                │
└──────────┬───────────────────┘
           │
           ├─ INVALID ─→ Show error message
           │
           └─ VALID ─→
                  │
                  ▼
           ┌──────────────────────┐
           │ ImageUploadService   │
           │ • Generate filename  │
           │ • Store in /storage/ │
           │ • app/public/product │
           │ • Return file path   │
           └──────────┬───────────┘
                      │
                      ▼
           ┌──────────────────────┐
           │ Array of Paths:      │
           │ [                    │
           │  'products/img1.jpg' │
           │  'products/img2.jpg' │
           │  'products/img3.jpg' │
           │ ]                    │
           └──────────┬───────────┘
                      │
                      ▼
           ┌──────────────────────┐
           │ Convert to JSON      │
           │ Store in DB          │
           │ products.images      │
           └──────────┬───────────┘
                      │
                      ▼
           ┌──────────────────────┐
           │ Public can now see   │
           │ images on shop page  │
           │ via /storage/app/... │
           └──────────────────────┘

TO DISPLAY IMAGES:
┌──────────────────────┐
│ Blade template needs │
│ to display image     │
└──────────┬───────────┘
           │
           ▼
┌──────────────────────────┐
│ Decode JSON from DB:     │
│ $images = json_decode()  │
│ Returns array of paths   │
└──────────┬───────────────┘
           │
           ▼
┌──────────────────────────┐
│ Build asset URL:         │
│ asset('storage/' . path) │
└──────────┬───────────────┘
           │
           ▼
┌──────────────────────────┐
│ <img src="...">          │
│ Browser downloads image  │
│ and displays             │
└──────────────────────────┘
```

---

## 9. Data Flow for Key Operations

### Adding Product to Cart
```
USER                  BROWSER              CONTROLLER          DATABASE
  │                    │                      │                    │
  ├─ Clicks ───────→   │                      │                    │
  │ "Add to Cart"      │                      │                    │
  │                    │ POST /cart/5 ────→  │                    │
  │                    │ (quantity=2)        │                    │
  │                    │                      ├─ Find Product ────→│
  │                    │                      │← Product data ─────│
  │                    │                      │                    │
  │                    │                      ├─ Check availability│
  │                    │                      │                    │
  │                    │                      ├─ Find Cart Item ──→│
  │                    │                      │← Cart item or null │
  │                    │                      │                    │
  │                    │                      ├─ Create/Update ──→ │
  │                    │                      │    CartItem       │
  │                    │                      │                    │
  │                   ← Redirect to cart ────│                    │
  │                   Display message        │                    │
  │                    │                      │                    │
  └─ Sees "Added"      │                      │                    │
```

---

## 10. Security Flow

```
┌────────────────────────────────────────────────┐
│              SECURITY MEASURES                 │
└────────────────────────────────────────────────┘

INPUT VALIDATION:
Request → Validate in Controller → Validate in Model → Save/Process

PASSWORD HASHING:
User Password → bcrypt() → Hashed Password → Store in DB
(Cannot reverse hash, only verify)

CSRF PROTECTION:
Form → Include @csrf token → Verify token → Allow/Reject request

SESSION MANAGEMENT:
Login → Create Session/Cookie → Verify on each request → Logout delete

AUTHORIZATION:
User Role → Check middleware → Allow/Deny access to route

FILE VALIDATION:
Upload → Check MIME type → Check size → Store securely → Serve with restrictions

DATABASE QUERIES:
User Input → Parameterized Query (no string concat) → SQL Injection prevented
```

---

## Summary

This architecture ensures:
- **Scalability**: Can add features without major refactoring
- **Maintainability**: Clear separation of concerns
- **Security**: Multiple layers of validation and protection
- **User Experience**: Fast, responsive interface
- **Data Integrity**: Proper relationships and constraints

All controlled through the MVC pattern with clean data flow.
