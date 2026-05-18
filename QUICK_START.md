# Thrift Platform - Quick Start Guide

## 5-Minute Setup

### Prerequisites
- PHP 8.0+
- MySQL or PostgreSQL
- Composer
- Node.js & npm

### Installation

```bash
# 1. Navigate to project directory
cd /path/to/thrift-platform

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Configure database in .env
# DB_DATABASE=thrift_platform
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 7. Run migrations
php artisan migrate

# 8. (Optional) Seed sample data
php artisan db:seed

# 9. Create storage link for images
php artisan storage:link

# 10. Start development servers (in separate terminals)
php artisan serve           # http://localhost:8000
npm run dev               # Tailwind CSS compilation
```

---

## Testing the Application

### Step 1: Create an Account
1. Visit `http://localhost:8000`
2. Click "Register"
3. Enter name, email, password
4. Click "Register"

### Step 2: Browse Products
1. You're now logged in on the shop page
2. See all available products
3. Click any product to view details

### Step 3: Add to Cart
1. On product page, enter quantity
2. Click "Add to Cart"
3. View cart by clicking cart icon

### Step 4: Become a Seller
To test seller features:

```bash
php artisan tinker
> $user = User::first();
> $user->update(['role' => 'seller']);
> exit
```

Then visit `/admin/dashboard`

### Step 5: Add Your First Product
1. Go to `/admin/products/create`
2. Fill in product details:
   - Name: "Vintage Leather Jacket"
   - Price: 45.99
   - Category: Select from dropdown
   - Upload images
   - Set condition and size
3. Click "Add Product"
4. View it on shop page

---

## File Structure Overview

```
app/
├── Http/Controllers/
│   ├── ProductController.php      ← Browse products
│   ├── CartController.php         ← Shopping cart
│   ├── CategoryController.php     ← Browse categories
│   └── Admin/AdminProductController.php  ← Manage products
├── Models/
│   ├── User.php                   ← User with roles
│   ├── Product.php                ← Product details
│   ├── Cart.php                   ← Shopping cart
│   ├── Category.php               ← Product categories
│   └── CartItem.php               ← Items in cart
└── Services/
    └── ImageUploadService.php     ← Image handling

resources/views/
├── shop/
│   ├── index.blade.php           ← Product listing
│   └── show.blade.php            ← Product details
├── cart/index.blade.php          ← Shopping cart view
├── categories/
│   ├── index.blade.php           ← Category listing
│   └── show.blade.php            ← Category products
└── admin/
    ├── dashboard.blade.php       ← Seller dashboard
    └── products/
        ├── index.blade.php       ← Manage products
        ├── create.blade.php      ← Add product form
        └── edit.blade.php        ← Edit product form

routes/
├── web.php                        ← All web routes
└── api.php                        ← API routes (optional)

database/
├── migrations/                    ← Database schemas
└── seeders/                       ← Sample data
```

---

## Common Routes

| URL | What It Does |
|-----|--------------|
| `/` | Homepage |
| `/shop` | Browse products |
| `/shop/{slug}` | View product details |
| `/categories` | Browse categories |
| `/cart` | View shopping cart |
| `/login` | Login page |
| `/register` | Register page |
| `/admin/dashboard` | Seller dashboard |
| `/admin/products` | Manage products |
| `/admin/products/create` | Add new product |

---

## Key Code Locations

### When you need to...

**Add a new field to products:**
1. Create migration: `php artisan make:migration add_field_to_products`
2. Add field in migration
3. Run: `php artisan migrate`
4. Add field to `$fillable` in `Product.php`

**Change product listing page design:**
Edit: `resources/views/shop/index.blade.php`

**Change product detail page design:**
Edit: `resources/views/shop/show.blade.php`

**Modify shopping cart behavior:**
Edit: `app/Http/Controllers/CartController.php`

**Add new seller features:**
Create new controller in: `app/Http/Controllers/Admin/`
Add route in: `routes/web.php`

**Style the application:**
Edit: `resources/css/app.css` or Tailwind classes in views

---

## Database Schema Quick Reference

### Users Table
- id, name, email, password, role (buyer/seller/admin)

### Products Table
- id, name, slug, description, price, original_price
- size, brand, condition, images (JSON), status
- is_available, is_featured, category_id, seller_id

### Categories Table
- id, name, slug, description, image, is_active

### Carts Table
- id, user_id

### Cart Items Table
- id, cart_id, product_id, quantity

---

## Artisan Commands

```bash
# Database
php artisan migrate                  # Run migrations
php artisan migrate:rollback         # Undo migrations
php artisan db:seed                  # Seed sample data

# Development
php artisan serve                    # Start dev server
php artisan tinker                   # Interactive shell

# Code Generation
php artisan make:model Product       # Create model
php artisan make:controller ProductController  # Create controller
php artisan make:migration create_products_table  # Create migration

# Maintenance
php artisan cache:clear              # Clear cache
php artisan config:cache             # Cache config
php artisan storage:link             # Link storage folder
```

---

## Debugging Tips

**Check Laravel logs:**
```bash
tail -f storage/logs/laravel.log
```

**Use Tinker to test code:**
```bash
php artisan tinker
> Product::all()  # Get all products
> User::first()   # Get first user
```

**Check all routes:**
```bash
php artisan route:list
```

**Test database connection:**
```bash
php artisan tinker
> DB::connection()->getPDO()
```

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| 500 error | Check `storage/logs/laravel.log` |
| Images not showing | Run `php artisan storage:link` |
| Database connection error | Check `.env` file, run `php artisan migrate` |
| Routes not working | Run `php artisan cache:clear` |
| CSS not loading | Run `npm run dev` in another terminal |
| "CSRF token mismatch" | Ensure `@csrf` is in all forms |
| Module not found | Run `composer install` or `npm install` |

---

## Next Steps

1. **Explore the code** - Read through controllers to understand flow
2. **Add features** - Follow examples in `API_REFERENCE.md`
3. **Customize styling** - Edit Blade templates and Tailwind CSS
4. **Test thoroughly** - Try all features before defense
5. **Document changes** - Keep track of modifications

---

## Getting Help

**In the code:**
- Check `COMPLETE_SETUP_GUIDE.md` for detailed explanations
- Check `API_REFERENCE.md` for code examples
- Check `DEFENSE_CHECKLIST.md` for what to demo

**Run commands to debug:**
```bash
php artisan route:list          # See all routes
php artisan tinker              # Test code
tail -f storage/logs/laravel.log # Watch errors
```

---

## Success Checklist

- [ ] Application running on localhost:8000
- [ ] Can register new user
- [ ] Can view products on shop page
- [ ] Can add product to cart
- [ ] Can edit cart items
- [ ] Can log in as seller
- [ ] Can add new product
- [ ] Can view seller dashboard
- [ ] Images uploading and displaying
- [ ] Prices calculating correctly

---

**You're ready! Start with: `php artisan serve`**
