# Step-by-Step Setup Guide - Visual Version

## ⚠️ IMPORTANT: This is a Laravel PHP Project

This project CANNOT run in a browser-only environment. You must run it on your local machine with PHP installed.

---

## 📋 Prerequisites

Before starting, make sure you have:

```
✅ PHP 8.1+ installed
✅ Composer installed
✅ Node.js installed
✅ MySQL OR SQLite
✅ Git (to pull the code)
```

Check if you have them:
```bash
php --version
composer --version
node --version
npm --version
```

If any are missing, install them:
- **PHP**: https://www.php.net/downloads
- **Composer**: https://getcomposer.org/download
- **Node.js**: https://nodejs.org

---

## 🚀 COMPLETE SETUP (Copy & Paste)

Open Terminal/Command Prompt and run this:

```bash
# 1. Clone/Navigate to project
cd /path/to/thrift-platform

# 2. Install PHP dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Create SQLite database file
touch database/database.sqlite

# 6. Run database migrations (creates tables)
php artisan migrate

# 7. Populate with sample data
php artisan db:seed

# 8. Create image storage link
php artisan storage:link

# 9. Install Node dependencies
npm install

# 10. Start Laravel development server
php artisan serve
```

**In a SECOND Terminal window, run:**
```bash
npm run dev
```

**Then open browser:**
```
http://localhost:8000
```

---

## 📸 Visual Step-by-Step

### STEP 1: Clone/Get the Project

```
Your Computer
    ↓
Terminal/Command Prompt
    ↓
Navigate to project folder
    ↓
cd /path/to/thrift-platform
```

### STEP 2: Install Dependencies

```
Run: composer install
    ↓
Installs all PHP packages
    ↓
Creates vendor/ folder
```

### STEP 3: Set Up Environment

```
Run: cp .env.example .env
    ↓
Creates .env file with configuration
    ↓
(Windows: copy .env.example .env)
```

### STEP 4: Generate App Key

```
Run: php artisan key:generate
    ↓
Creates unique encryption key
    ↓
Outputs: Application key set successfully.
```

### STEP 5: Create Database

```
SQLite Path:
/vercel/share/v0-project/database/database.sqlite

Run: touch database/database.sqlite
    ↓
Creates empty database file
    ↓
(Windows: type NUL > database\database.sqlite)
```

### STEP 6: Create Database Tables

```
Run: php artisan migrate
    ↓
Reads migration files
    ↓
Creates all database tables:
  - users
  - categories
  - products
  - cart_items
  - notifications
  - ... etc
    ↓
Status: Migration successful ✓
```

### STEP 7: Add Sample Data

```
Run: php artisan db:seed
    ↓
Reads seeder files
    ↓
Adds:
  - 2 sample users
  - 5 categories
  - 20+ products
  - Sample images
    ↓
Status: Database seeding completed ✓
```

### STEP 8: Set Up Image Storage

```
Run: php artisan storage:link
    ↓
Creates link to storage folder
    ↓
Images can now be accessed
    ↓
Status: The [public/storage] link has been connected ✓
```

### STEP 9: Install Frontend Dependencies

```
Run: npm install
    ↓
Installs JavaScript packages
    ↓
Creates node_modules/ folder
```

### STEP 10: Start Laravel Server

**Terminal Window 1:**
```
Run: php artisan serve
    ↓
Starts Laravel development server
    ↓
Output: Laravel development server started: http://127.0.0.1:8000
```

**Terminal Window 2:**
```
Run: npm run dev
    ↓
Compiles CSS and JavaScript
    ↓
Watches for changes
```

### STEP 11: Access the App

```
Open Browser:
    ↓
http://localhost:8000
    ↓
You should see:
  ✅ Homepage
  ✅ Shop with 20+ products
  ✅ Product images
  ✅ Shopping cart
  ✅ Login page
```

---

## 🎯 What You Should See

### After Setup - Shop Page
```
http://localhost:8000/shop

┌─────────────────────────────────┐
│  THRIFT PLATFORM                │
│  ▼ Shop                         │
├─────────────────────────────────┤
│ ┌──────────┐  ┌──────────┐      │
│ │ Product1 │  │ Product2 │  ... │
│ │ Image    │  │ Image    │      │
│ │ $45.99   │  │ $32.99   │      │
│ └──────────┘  └──────────┘      │
└─────────────────────────────────┘
```

### Product Detail Page
```
http://localhost:8000/shop/vintage-watch

┌──────────────────────────────────────┐
│  Vintage Watch                       │
├──────────────────────────────────────┤
│ [Image Gallery]    │ Description     │
│ [Thumbnails]       │ Price: $45.99   │
│                    │ Original: $89.99│
│                    │ Brand: Rolex    │
│                    │ Condition: Good │
│                    │ [Add to Cart]   │
└──────────────────────────────────────┘
```

### Shopping Cart
```
http://localhost:8000/cart

┌──────────────────────┬────────────────┐
│ Product  │ Qty │ Price│ Subtotal     │
├──────────────────────┼────────────────┤
│ Watch    │ 1   │ $45  │ $45.00       │
│ Jacket   │ 2   │ $32  │ $64.00       │
├──────────────────────┼────────────────┤
│ TOTAL                        │ $109.00  │
└──────────────────────────────┘
```

### Seller Dashboard
```
http://localhost:8000/admin/dashboard
(Login: admin@example.com / password)

┌────────────────────────────────────┐
│ Dashboard                          │
├────────────────────────────────────┤
│ Total Products:  20                │
│ Active Listings: 18                │
│ Pending Items:   2                 │
│ Sold Items:      5                 │
├────────────────────────────────────┤
│ [Add New Product] [Manage Products]│
│ [View Notifications] [Settings]    │
└────────────────────────────────────┘
```

---

## 🔐 Sample Login Accounts

After running `php artisan db:seed`, use these to login:

**Account 1: Seller/Admin**
```
Email:    admin@example.com
Password: password
Role:     Seller (can add/edit products)
```

**Account 2: Customer/Buyer**
```
Email:    buyer@example.com
Password: password
Role:     Customer (can browse and buy)
```

---

## 📁 Project Structure After Setup

```
thrift-platform/
├── app/
│   ├── Models/                    ← Database models
│   │   ├── Product.php
│   │   ├── User.php
│   │   ├── Cart.php
│   │   └── Category.php
│   └── Http/Controllers/          ← Request handlers
│       ├── ProductController.php
│       ├── CartController.php
│       └── CategoryController.php
├── routes/
│   └── web.php                    ← URL routes
├── resources/views/               ← HTML templates
│   ├── shop/
│   ├── cart/
│   ├── admin/
│   └── layouts/
├── database/
│   ├── migrations/                ← Table definitions
│   ├── seeders/                   ← Sample data
│   └── database.sqlite            ← ✨ Created by you
├── public/
│   └── storage/ → (links to storage/app/public)
├── storage/
│   └── app/
│       └── public/
│           └── products/          ← Product images
├── .env                           ← ✨ Created by you
├── .env.example                   ← Template (don't edit)
├── composer.json                  ← PHP dependencies
├── package.json                   ← Node dependencies
└── artisan                        ← Laravel command tool
```

---

## ✅ Verification Checklist

After completing setup:

- [ ] Can you see home page at http://localhost:8000?
- [ ] Do you see products at http://localhost:8000/shop?
- [ ] Do product images show up?
- [ ] Can you click a product to see details?
- [ ] Can you add items to cart?
- [ ] Can you see cart at http://localhost:8000/cart?
- [ ] Can you login with admin@example.com?
- [ ] Can you see dashboard at /admin/dashboard?
- [ ] Can you add a new product from dashboard?

If all are ✓, you're ready for your defense!

---

## 🐛 Common Issues & Fixes

### Issue: "php: command not found"
**Fix:** PHP is not installed or not in PATH
```bash
# Check if PHP is installed
php --version

# If not, install PHP:
# macOS: brew install php
# Windows: Download from php.net
# Linux: sudo apt install php php-sqlite3
```

### Issue: "SQLSTATE[HY000]: General error: 1 no such table"
**Fix:** Migrations didn't run
```bash
php artisan migrate
php artisan db:seed
```

### Issue: "Class 'PDO' not found"
**Fix:** PHP SQLite extension not enabled
```bash
# Check php.ini, ensure these lines exist:
extension=pdo_sqlite
# Restart server after fix
```

### Issue: "Images not showing"
**Fix:** Storage link not created
```bash
php artisan storage:link
```

### Issue: "Connection refused at http://localhost:8000"
**Fix:** Laravel server not running
```bash
# Make sure you're in project directory
cd /path/to/thrift-platform

# Start server
php artisan serve

# Should output: Laravel development server started: http://127.0.0.1:8000
```

### Issue: "npm: command not found"
**Fix:** Node.js not installed
```bash
# Install Node.js from nodejs.org
# Then run: npm install
```

---

## 🎓 Understanding the Flow

```
User visits http://localhost:8000/shop
    ↓
Browser sends request to Laravel
    ↓
routes/web.php checks URL pattern
    ↓
Matches route for /shop
    ↓
Calls ProductController@index
    ↓
Controller queries Product model
    ↓
Model fetches data from database
    ↓
Controller passes data to view
    ↓
resources/views/shop/index.blade.php renders HTML
    ↓
Browser displays shop page with products
```

---

## 📚 Files to Reference

| Need | File | Path |
|------|------|------|
| Database info | DATABASE_SETUP.md | /vercel/share/v0-project/ |
| API endpoints | API_REFERENCE.md | /vercel/share/v0-project/ |
| Code examples | CODE_SHOWCASE.md | /vercel/share/v0-project/ |
| For defense | DEFENSE_PRESENTATION.md | /vercel/share/v0-project/ |

---

## 🎉 You're Ready!

Once you complete all steps:

1. **Your shop is live** with 20+ products
2. **Images are showing** properly
3. **Shopping cart works** - add/remove items
4. **Admin panel works** - manage products
5. **Everything is ready** for your internship defense!

**Time to complete setup:** 15-20 minutes

---

## Next Steps

1. Complete this setup guide
2. Test the application (verify checklist)
3. Read DEFENSE_PRESENTATION.md
4. Practice your demo
5. You're ready for defense! 🚀

Good luck!
