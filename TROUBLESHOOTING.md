# Troubleshooting: Products Not Showing on Shop Page

## Status Check - Run This First!

Before trying anything else, visit this URL in your browser while Laravel is running:

```
http://localhost:8000/debug/check
```

This will show you:
- ✓ How many products are in the database
- ✓ How many categories are in the database  
- ✓ Whether Laravel can connect to the database
- ✓ Any connection errors

If you see JSON output with `"total_products": 24`, then **your database is working fine** and the issue is with the view or controller.

---

## Scenario 1: Debug Check Shows "total_products": 24

**Problem:** Database is connected and has products, but shop page shows nothing.

**Solution:**
1. Clear Laravel cache:
   ```bash
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   php artisan config:clear
   ```

2. Restart Laravel server:
   ```bash
   # Kill the old server
   pkill php
   
   # Start fresh
   php artisan serve
   ```

3. Visit `/shop` page again - products should now appear

---

## Scenario 2: Debug Check Shows Error

**Error:** "Could not find driver" or "connection refused"

**Solutions:**

### Option A: Ensure SQLite is in the database directory
```bash
# Check if file exists
ls -lh database/database.sqlite

# If missing, recreate it
python3 init-db.py
```

### Option B: Check .env file
```bash
# Make sure DB_CONNECTION and DB_DATABASE are set correctly
grep "DB_" .env

# Should show:
# DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite
```

### Option C: Regenerate database
```bash
# Backup old database
mv database/database.sqlite database/database.sqlite.bak

# Create new database with all tables and products
python3 init-db.py

# Restart Laravel
pkill php
php artisan serve
```

---

## Scenario 3: Database File is 0 bytes (empty)

**Problem:** `database/database.sqlite` exists but is completely empty

**Solution:**
```bash
# Delete empty file
rm database/database.sqlite

# Recreate with all tables and data
python3 init-db.py

# Verify it has data
python3 -c "import sqlite3; conn = sqlite3.connect('database/database.sqlite'); c = conn.cursor(); c.execute('SELECT COUNT(*) FROM products'); print(f'Products: {c.fetchone()[0]}')"

# Restart Laravel
pkill php
php artisan serve
```

---

## Scenario 4: Products Show in Debug But Not on Shop Page

**Problem:** `/debug/check` shows 24 products, but `/shop` page still shows "No products found"

**Solution:**

1. **Check if migrations table exists:**
   ```bash
   python3 -c "import sqlite3; conn = sqlite3.connect('database/database.sqlite'); c = conn.cursor(); c.execute('SELECT COUNT(*) FROM migrations'); print(f'Migrations recorded: {c.fetchone()[0]}')"
   ```
   
   If output is 0 or error:
   ```bash
   # Recreate migrations table
   python3 init-db.py
   ```

2. **Clear Laravel cache again:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

3. **Restart server:**
   ```bash
   pkill php
   php artisan serve
   ```

---

## Scenario 5: Getting "Unknown column" or Database Errors

**Problem:** Laravel shows SQL errors like "Unknown column in field list"

**Solution:**

This means the database schema doesn't match what Laravel expects. Fix it:

```bash
# 1. Delete corrupted database
rm database/database.sqlite

# 2. Delete Laravel's cache files
rm -rf bootstrap/cache/*

# 3. Create fresh database
python3 init-db.py

# 4. Clear all Laravel caches
php artisan cache:clear
php artisan config:clear

# 5. Restart
pkill php
php artisan serve
```

---

## Quick Commands Reference

**Check database has data:**
```bash
python3 -c "import sqlite3; conn = sqlite3.connect('database/database.sqlite'); c = conn.cursor(); c.execute('SELECT COUNT(*) FROM products'); print(f'Total: {c.fetchone()[0]}')"
```

**Check all categories:**
```bash
python3 -c "import sqlite3; conn = sqlite3.connect('database/database.sqlite'); c = conn.cursor(); c.execute('SELECT name, is_active FROM categories'); [print(f'{r[0]}: {\"✓\" if r[1] else \"✗\"}') for r in c.fetchall()]"
```

**Clear all Laravel caches:**
```bash
php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear
```

**Restart everything:**
```bash
pkill php
pkill npm
php artisan serve &
npm run dev &
```

---

## What to Check

- ✓ Database file exists: `ls -lh database/database.sqlite` (should be > 1KB)
- ✓ Database has tables: `python3 -c "import sqlite3; conn = sqlite3.connect('database/database.sqlite'); c = conn.cursor(); c.execute(\"SELECT name FROM sqlite_master WHERE type='table'\"); [print(r[0]) for r in c.fetchall()]"`
- ✓ Products exist: Use `/debug/check` endpoint
- ✓ Categories exist: Use `/debug/check` endpoint
- ✓ .env file has correct DB settings: `grep "DB_" .env`
- ✓ Laravel can read .env: Check if there are errors when starting `php artisan serve`

---

## Still Not Working?

1. **Check PHP version** - Must be 8.1+:
   ```bash
   php --version
   ```

2. **Check Composer is installed:**
   ```bash
   composer --version
   ```

3. **Reinstall dependencies:**
   ```bash
   composer install
   npm install
   ```

4. **View actual Laravel logs:**
   ```bash
   tail -100 storage/logs/laravel.log
   ```

5. **Run migrations manually (if database was corrupted):**
   ```bash
   php artisan migrate:refresh --seed
   ```

---

## Need Help?

If none of these work, provide:
1. Output from `/debug/check` endpoint
2. Output from: `php --version`
3. Output from: `ls -lh database/database.sqlite`
4. Output from: `grep "DB_" .env`
5. Last 50 lines from: `tail -50 storage/logs/laravel.log`

This will help diagnose the issue!
