# Fix: "Attempt to read property 'name' on null" Error

## Problem
When visiting a product detail page, you get this error:
```
ErrorException
Attempt to read property "name" on null
```

This happens at line 33 in `products/show.blade.php`:
```php
<p>Seller: {{ $product->user->name }}</p>
```

## Root Cause
The product doesn't have a seller assigned to it (`seller_id` is NULL in the database).

## Solutions

### Solution 1: Use the Correct Route (RECOMMENDED)
The main route for product details should be:
```
http://localhost:8000/shop/{product-slug}
```

Not:
```
http://localhost:8000/products/{id}  ❌
```

Make sure you:
1. Click products from `/shop` page
2. They will have proper sellers assigned
3. The route will use the correct controller

### Solution 2: Seed Database with Sample Products
If you haven't seeded yet, run:
```bash
php artisan db:seed
```

This creates 20+ products with sellers already assigned.

### Solution 3: Add Seller to Existing Products
If you manually added products without a seller, run:

```bash
php artisan tinker
Product::update(['seller_id' => 1]);
exit
```

### Solution 4: Fix the View (Already Done)
The view at `resources/views/products/show.blade.php` has been updated to handle NULL sellers:

```php
<p>Seller: {{ $product->seller ? $product->seller->name : 'Unknown Seller' }}</p>
```

Instead of:
```php
<p>Seller: {{ $product->user->name }}</p>  ❌
```

## Quick Checklist

✓ Are you visiting `/shop/{slug}` or `/products/{id}`?
  - Use `/shop/{slug}` (correct route)
  
✓ Did you run `php artisan db:seed`?
  - If no, run it to add sample products
  
✓ Did you create products without a seller?
  - Update them to have seller_id = 1
  
✓ Is the view updated?
  - Yes, it now handles NULL sellers

## After You Fix This

You should see:
- Product details load
- Seller name displays correctly
- Add to cart button works
- Related products show

## Need More Help?

1. Check the URL you're visiting
2. Make sure it says `/shop/product-slug` not `/products/1`
3. Run `php artisan db:seed` if no products exist
4. Clear browser cache (Ctrl+Shift+Delete)
5. Refresh the page (Ctrl+Shift+R)

---

**Status: FIXED** ✓ The code has been updated to handle this error safely.
