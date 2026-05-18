# Database Setup Guide - Thrift Platform

## Quick Start (Already Done!)

The following has already been configured for you:

### ✅ Environment File (.env)
- Created `.env` file with SQLite database configuration
- Generated `APP_KEY` for encryption
- Database set to: `database/database.sqlite`

### ✅ Database Directory
- Created `database/` directory
- Created empty `database/database.sqlite` file with proper permissions

### ✅ Environment Configuration
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## Next Steps - Run These Commands

Once you have the project locally, run these commands in order:

### 1. Install Composer Dependencies
```bash
composer install
```

### 2. Database Setup
```bash
# Run migrations to create all tables
php artisan migrate

# Seed the database with dummy data (categories and products)
php artisan db:seed
```

### 3. Start Development Servers
Run these in separate terminal windows:

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
# Server runs on http://localhost:8000
```

**Terminal 2 - Frontend Assets (Tailwind CSS, etc):**
```bash
npm run dev
```

## What Gets Created

### Database Tables
- `users` - User accounts
- `categories` - Product categories (6 created)
- `products` - Products (24 created - 4 per category)
- `sessions` - User sessions
- `cache` - Cache data
- `jobs` - Queue jobs
- And other Laravel system tables

### Sample Data

**6 Categories Created:**
1. Women's Clothing
2. Men's Clothing
3. Shoes
4. Accessories
5. Bags & Purses
6. Jewelry

**24 Products Created:**
- 4 products in each category
- Each with realistic pricing, descriptions, brands, and conditions
- All marked as active and available for purchase

**Sample Seller Account:**
- Email: `seller@thriftplatform.com`
- Password: `password`
- Role: Seller

## Database File Location

The SQLite database file will be created at:
```
/your-project-path/database/database.sqlite
```

SQLite stores everything in a single file - no server needed! This is perfect for local development.

## Troubleshooting

### Error: "Database file at path [laravel] does not exist"
- This means the `.env` file is missing or `DB_DATABASE` is not set correctly
- Solution: Copy the provided `.env` file and ensure `DB_DATABASE=database/database.sqlite` is set

### Error: "SQLSTATE[HY000]: General error: 1 no such table"
- Tables haven't been created yet
- Solution: Run `php artisan migrate`

### Error: "No products showing in shop"
- Database seeded but products not appearing
- Solution: Run `php artisan db:seed` to populate dummy data

### Permission Denied on database.sqlite
- SQLite file doesn't have write permissions
- Solution: Run `chmod 666 database/database.sqlite`

## Accessing the Application

After starting both servers:

1. **Shop Page:** http://localhost:8000/shop
   - View all 24 products
   - Filter by category
   - Search products
   - Sort by price/popularity
   - Add items to cart

2. **Admin/Dashboard:** http://localhost:8000/dashboard
   - View user account
   - Manage listings
   - View orders

## Database Connection Details

**Type:** SQLite (File-based)
**Host:** Local file
**Port:** None (file-based)
**Database:** `database/database.sqlite`
**Username:** Not needed
**Password:** Not needed

This is configured in `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

## Resetting the Database

To start fresh:

```bash
# Delete and recreate database
rm database/database.sqlite
touch database/database.sqlite

# Run migrations again
php artisan migrate

# Seed with dummy data
php artisan db:seed
```

Or in one command:
```bash
php artisan migrate:fresh --seed
```

## Next Steps

1. Follow the setup commands above
2. Visit http://localhost:8000/shop
3. See all 24 products in 6 categories
4. Test filtering, searching, and sorting
5. Browse individual products
6. Add items to cart

Everything is ready to go! 🎉
