# Database & Product Setup Guide

## The Problem
You're seeing an empty shop because the database hasn't been populated with products and categories yet.

## The Solution
Follow these steps ON YOUR LOCAL MACHINE (not in this browser environment):

---

## Step 1: Set Up Environment File

```bash
cd /path/to/thrift-platform
cp .env.example .env
```

---

## Step 2: Generate App Key

```bash
php artisan key:generate
```

Expected output: `Application key set successfully.`

---

## Step 3: Create Database

**Option A: Using SQLite (Recommended for Development)**

The SQLite database file will be created automatically.

```bash
touch database/database.sqlite
```

**Option B: Using MySQL/MariaDB**

Update your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=thrift_platform
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

Then create the database:
```bash
mysql -u root -p -e "CREATE DATABASE thrift_platform;"
```

---

## Step 4: Run Migrations

```bash
php artisan migrate
```

This creates all necessary tables:
- users (users who browse/sell)
- categories (product categories)
- products (thrift items)
- cart_items (shopping cart)
- And more...

Expected output:
```
Running migrations
  2025_01_01_000000_create_users_table
  2025_05_23_172520_create_categories_table
  2025_05_23_201341_create_products_table
  ... (more migrations)
```

---

## Step 5: Seed the Database with Sample Data

This creates sample categories, users, and products automatically.

```bash
php artisan db:seed
```

Or seed specific seeders:

```bash
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder
```

---

## Step 6: Set Up Storage Links

For images to work properly:

```bash
php artisan storage:link
```

---

## Step 7: Run the Application

**Terminal 1 - Start Laravel Server:**
```bash
php artisan serve
```

You should see:
```
Laravel development server started: http://127.0.0.1:8000
```

**Terminal 2 - Compile Assets (if needed):**
```bash
npm install
npm run dev
```

---

## Step 8: Access the Application

Open your browser and visit:
```
http://localhost:8000
```

You should now see:
✅ Products in the shop
✅ Product images
✅ Categories
✅ Shopping cart functionality

---

## If You See Errors...

### "SQLSTATE[HY000]: General error: 1 no such table"
**Solution:** Run migrations first
```bash
php artisan migrate
php artisan db:seed
```

### "Images not showing"
**Solution:** Create storage link
```bash
php artisan storage:link
```

### "Class not found" errors
**Solution:** Restart the server and clear cache
```bash
php artisan config:cache
php artisan cache:clear
php artisan view:clear
```

### "Connection refused"
**Solution:** Make sure database is running (if using MySQL)
```bash
# Check if MySQL is running (macOS/Linux)
mysql -u root -p
# Press Ctrl+C to exit
```

---

## Complete Command Sequence

Copy and paste this to set everything up at once:

```bash
# Navigate to project
cd /path/to/thrift-platform

# Create environment
cp .env.example .env

# Generate key
php artisan key:generate

# Create SQLite database
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Create storage link for images
php artisan storage:link

# Install npm dependencies (if not done yet)
npm install

# Start Laravel server
php artisan serve

# In another terminal:
npm run dev
```

Then visit: http://localhost:8000

---

## What Gets Seeded?

When you run `php artisan db:seed`, you get:

### Sample Users (2)
- admin@example.com (Seller)
- buyer@example.com (Buyer)
Both with password: `password`

### Sample Categories (5)
- Clothing & Apparel
- Accessories
- Home & Decor
- Electronics
- Sports & Outdoors

### Sample Products (20+)
Each with:
- Product name and description
- Price and original price
- Size, brand, condition
- Multiple images
- Category assignment

---

## Testing the Shop

After seeding:

1. **View Products**
   - Go to http://localhost:8000/shop
   - See all 20+ products

2. **View Product Details**
   - Click any product
   - See images, description, price
   - See "Add to Cart" button

3. **Shopping Cart**
   - Add items to cart
   - Go to http://localhost:8000/cart
   - Update quantities
   - Remove items

4. **Seller Dashboard**
   - Login as seller: admin@example.com / password
   - Go to http://localhost:8000/admin/dashboard
   - See your products
   - Add/edit/delete products

---

## Customizing Sample Data

To add more products with custom data:

### Edit ProductSeeder.php

File: `database/seeders/ProductSeeder.php`

Add products like this:

```php
Product::create([
    'name' => 'Vintage Leather Jacket',
    'description' => 'Authentic leather jacket from the 90s',
    'price' => 45.99,
    'original_price' => 89.99,
    'size' => 'L',
    'brand' => 'Levi\'s',
    'condition' => 'Good',
    'category_id' => 1,
    'seller_id' => 1,
    'is_available' => true,
    'is_featured' => true,
    'images' => json_encode([
        'products/jacket1.jpg',
        'products/jacket2.jpg',
    ]),
]);
```

Then run:
```bash
php artisan migrate:refresh --seed
```

---

## Production Deployment

For deployment to production (Vercel, Heroku, etc.):

1. Use database service (Railway, Vercel Postgres, etc.)
2. Update .env with production credentials
3. Run migrations: `php artisan migrate --force`
4. Seed data: `php artisan db:seed`
5. Deploy

---

## Database Structure

```
users
├── id, name, email, password
├── role (customer, seller, admin)
└── relationships: products, cart

categories
├── id, name, slug
└── relationships: products

products
├── id, name, slug, description
├── price, original_price
├── size, brand, condition
├── images (JSON array)
├── category_id, seller_id
└── status (active, inactive, sold)

cart_items
├── id, quantity
├── product_id, cart_id
└── total_price (calculated)

notifications
├── id, type, message
└── user_id
```

---

## Troubleshooting Checklist

- [ ] .env file created
- [ ] php artisan key:generate ran
- [ ] Database file/server exists
- [ ] Migrations ran (php artisan migrate)
- [ ] Database seeded (php artisan db:seed)
- [ ] Storage linked (php artisan storage:link)
- [ ] Laravel server running (php artisan serve)
- [ ] Can access http://localhost:8000
- [ ] Products visible in /shop
- [ ] Can add items to cart
- [ ] Can login as admin@example.com

---

## Quick Test

After everything is set up, test with these URLs:

```
http://localhost:8000/                    → Home page
http://localhost:8000/shop                → Product listing (should show 20+ items)
http://localhost:8000/shop/vintage-watch  → Product detail
http://localhost:8000/cart                → Shopping cart
http://localhost:8000/login               → Login page
http://localhost:8000/admin/dashboard     → Admin dashboard (logged in only)
```

---

## Need More Help?

Check these files:
- **COMPLETE_SETUP_GUIDE.md** - Detailed explanations
- **QUICK_START.md** - 5-minute setup
- **API_REFERENCE.md** - Code examples

---

**Good luck! Once seeded, your shop will look amazing! 🎉**
