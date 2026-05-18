# How to Reset and Seed Your Database

## Problem
You got this error:
```
SQLSTATE[23000]: Integrity constraint violation: 19 UNIQUE constraint failed: categories.slug
```

This happens when categories with the same slug already exist in the database.

## Solution

### Option 1: Quick Reset (Recommended)
Run this command to delete the old database and start fresh:

```bash
cd /Users/geetskuike/thrift-platform

# Delete the old database
rm database/database.sqlite

# Create fresh database and seed it
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

### Option 2: Fresh Command
Laravel has a built-in command for this:

```bash
php artisan migrate:fresh --seed
```

This will:
1. Drop all tables
2. Run migrations to recreate them
3. Seed the database with sample data

## What Gets Added

After running either command, you'll have:

- **6 Product Categories:**
  - Women's Clothing
  - Men's Clothing
  - Shoes
  - Accessories
  - Bags & Purses
  - Jewelry

- **6 Sample Products** with:
  - Real prices and descriptions
  - Product images
  - Category assignments
  - Seller assignments

- **Test User Account:**
  - Email: `seller@thriftplatform.com`
  - Password: `password`
  - Role: Seller

## After Seeding

1. Start your development servers:
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

2. Visit the shop:
```
http://localhost:8000/shop
```

3. You should see 6 products with images and details!

## Troubleshooting

**Still getting UNIQUE constraint error?**
- Make sure you deleted the database.sqlite file completely
- Check that no other process is using the database
- Try running: `php artisan migrate:fresh --seed`

**Products not showing?**
- Make sure both servers are running (Laravel + Vite)
- Check that you see "6 products" in the shop page
- Verify the database was seeded (check the output from db:seed)

**Getting other errors?**
- Run: `php artisan config:clear`
- Run: `php artisan cache:clear`
- Try the reset process again
