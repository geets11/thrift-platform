# Seeder Unique Constraint Error - FIXED

## What Was Wrong

The CategorySeeder was trying to insert categories without clearing old ones first. This caused the "UNIQUE constraint failed: categories.slug" error when seeding multiple times.

### Before (Broken)
```php
public function run()
{
    $categories = [
        ['name' => "Women's Clothing", ...],
        // ...
    ];

    foreach ($categories as $category) {
        Category::create($category);  // ❌ Fails if slug already exists
    }
}
```

### After (Fixed)
```php
public function run()
{
    Category::truncate();  // ✅ Clear old data first

    $categories = [
        ['name' => "Women's Clothing", ...],
        // ...
    ];

    foreach ($categories as $category) {
        Category::create($category);  // ✅ Now succeeds
    }
}
```

## What Was Changed

### 1. CategorySeeder.php
- Added `Category::truncate();` at the start
- This clears all existing categories before inserting new ones
- Prevents UNIQUE constraint violations

### 2. ProductSeeder.php
- Added `Product::truncate();` at the start
- Changed user creation to use `firstOrCreate()` instead of always creating new
- This prevents duplicate user errors

## How to Fix Your Database Now

### Quick Fix
```bash
php artisan migrate:fresh --seed
```

This single command will:
1. Drop all tables
2. Run migrations to recreate them
3. Seed with the fixed seeders

### Manual Fix
```bash
rm database/database.sqlite
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

## What You'll Get

After running the fixed seeders:

✅ 6 Categories with unique slugs
✅ 6 Sample products
✅ 1 Test seller account
✅ All relationships properly set up
✅ Ready to browse in the shop

## No More Errors!

The seeders now:
- Clear old data before inserting
- Handle duplicate users gracefully
- Work reliably every time you run them

You can run `php artisan db:seed` multiple times without errors.
