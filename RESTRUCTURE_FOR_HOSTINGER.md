# Restructure Project for Hostinger (All Files in public_html)

## 🎯 Goal
Restructure the Laravel project so ALL files can be placed in `public_html/` while keeping Laravel core protected.

## 📋 Step-by-Step Instructions

### Step 1: Create Laravel Subdirectory in Public

```bash
cd laravel-backend
mkdir public/laravel
```

### Step 2: Move Laravel Core Files

Move these folders/files from `laravel-backend/` to `laravel-backend/public/laravel/`:

**Folders to move:**
- `app/` → `public/laravel/app/`
- `bootstrap/` → `public/laravel/bootstrap/`
- `config/` → `public/laravel/config/`
- `database/` → `public/laravel/database/`
- `resources/` → `public/laravel/resources/`
- `routes/` → `public/laravel/routes/`
- `storage/` → `public/laravel/storage/`
- `vendor/` → `public/laravel/vendor/` (or install via composer on server)

**Files to move:**
- `artisan` → `public/laravel/artisan`
- `composer.json` → `public/laravel/composer.json`
- `composer.lock` → `public/laravel/composer.lock`
- `.env.example` → `public/laravel/.env.example`

### Step 3: Update public/index.php

The `public/index.php` has been updated to point to `laravel/` subdirectory.

### Step 4: Create Protection Files

1. **`public/.htaccess`** - Already updated with protection rules
2. **`public/laravel/.htaccess`** - Create this file to deny all access

### Step 5: Keep Public Assets

Keep these in `public/` (they'll go to `public_html/` root):
- `assets/` folder (CSS, JS, images)
- `favicon.ico`
- `malbi-kitchen-logo.svg`
- `robots.txt`
- `index.php` (updated)
- `.htaccess` (updated)

## 📁 Final Structure

```
laravel-backend/
├── public/                    ← Upload ALL of this to public_html/
│   ├── index.php              ← Updated paths
│   ├── .htaccess              ← Protection rules
│   ├── assets/                ← Theme assets
│   ├── favicon.ico
│   ├── robots.txt
│   ├── malbi-kitchen-logo.svg
│   │
│   └── laravel/               ← Laravel core (protected)
│       ├── .htaccess          ← Deny all
│       ├── app/
│       ├── bootstrap/
│       ├── config/
│       ├── database/
│       ├── resources/
│       ├── routes/
│       ├── storage/
│       ├── vendor/
│       ├── artisan
│       ├── composer.json
│       └── .env.example
│
└── (other files - not needed for deployment)
```

## 🚀 Upload to Hostinger

1. **Upload entire `public/` folder contents to `public_html/`:**
   - All files and folders inside `public/` go directly to `public_html/`
   - This includes `index.php`, `.htaccess`, `assets/`, and `laravel/`

2. **Set permissions:**
   ```
   public_html/laravel/storage/           → 755
   public_html/laravel/storage/framework/ → 755
   public_html/laravel/storage/logs/      → 755
   public_html/laravel/bootstrap/cache/   → 755
   ```

3. **Create `.env`:**
   - Copy `.env.example` to `.env` in `public_html/laravel/`
   - Configure with your Hostinger database credentials

4. **Generate APP_KEY:**
   - Via SSH: `cd public_html/laravel && php artisan key:generate`
   - Or copy from local `.env`

## ✅ Verification

After upload, verify:
- ✅ Website loads at `https://yourdomain.com/`
- ✅ Assets load: `https://yourdomain.com/assets/css/style.css`
- ✅ Laravel core protected: `https://yourdomain.com/laravel/app/` returns 403
- ✅ Admin login works: `https://yourdomain.com/login`

---

**Note:** This structure ensures everything is in `public_html/` while maintaining security through `.htaccess` protection rules.
