# Hostinger Shared Hosting - All Files in public_html Structure

## 📁 Required File Structure

Since Hostinger shared hosting requires all files to be in `public_html`, use this structure:

```
public_html/                    ← Your document root (everything goes here)
├── index.php                  ← Laravel entry point (updated paths)
├── .htaccess                  ← Main .htaccess (protects Laravel core)
├── favicon.ico
├── robots.txt
├── malbi-kitchen-logo.svg
│
├── assets/                    ← Theme assets (publicly accessible)
│   ├── css/
│   ├── js/
│   └── images/
│
└── laravel/                   ← Laravel core (protected by .htaccess)
    ├── .htaccess              ← Denies all access
    ├── .env                   ← Environment config
    ├── .env.example
    ├── artisan
    ├── composer.json
    ├── composer.lock
    │
    ├── app/                   ← Application code
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   └── Middleware/
    │   ├── Models/
    │   └── Providers/
    │
    ├── bootstrap/             ← Bootstrap files
    │   ├── app.php
    │   ├── cache/             ← Must be writable (755)
    │   └── providers.php
    │
    ├── config/                ← Configuration files
    │   ├── app.php
    │   ├── database.php
    │   └── ...
    │
    ├── database/              ← Database migrations
    │   ├── migrations/
    │   └── seeders/
    │
    ├── resources/             ← Views and assets source
    │   ├── views/
    │   ├── css/
    │   └── js/
    │
    ├── routes/                ← Route definitions
    │   ├── web.php
    │   └── dashboard-routes.php
    │
    ├── storage/               ← Storage (must be writable - 755)
    │   ├── app/
    │   ├── framework/
    │   │   ├── cache/
    │   │   ├── sessions/
    │   │   └── views/
    │   └── logs/
    │
    └── vendor/                ← Composer dependencies
        └── ...
```

## 🔄 Migration Steps

### Step 1: Restructure Locally

1. **Create `laravel` folder inside `public/`:**
   ```bash
   cd laravel-backend
   mkdir public/laravel
   ```

2. **Move Laravel core files to `public/laravel/`:**
   - Move: `app/`, `bootstrap/`, `config/`, `database/`, `resources/`, `routes/`, `storage/`, `vendor/`
   - Move: `artisan`, `composer.json`, `composer.lock`, `.env.example`
   - Keep: `public/` contents (index.php, .htaccess, assets/) stay in `public/`

3. **Update `public/index.php`:**
   - Change paths from `__DIR__.'/../` to `__DIR__.'/laravel/`

4. **Create protection `.htaccess` files:**
   - `public/.htaccess` - Main routing + protection rules
   - `public/laravel/.htaccess` - Deny all access

### Step 2: Upload to Hostinger

1. **Upload entire `public/` folder contents to `public_html/`:**
   - Upload: `index.php`, `.htaccess`, `assets/`, `favicon.ico`, etc.
   - Upload: `laravel/` folder with all Laravel core files

2. **Set permissions:**
   ```
   laravel/storage/              → 755
   laravel/storage/framework/    → 755
   laravel/storage/logs/         → 755
   laravel/bootstrap/cache/      → 755
   ```

### Step 3: Configure

1. **Create `.env` in `public_html/laravel/`:**
   ```env
   APP_NAME="Malbis Kitchen"
   APP_ENV=production
   APP_KEY=
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

2. **Generate APP_KEY:**
   - Via SSH: `cd public_html/laravel && php artisan key:generate`
   - Or copy from local `.env`

## 🔒 Security Features

### 1. `.htaccess` Protection Rules

**`public_html/.htaccess`** protects Laravel core:
- Blocks direct access to `laravel/app/`, `laravel/config/`, etc.
- Protects `.env` files
- Allows only `index.php` to access Laravel

**`public_html/laravel/.htaccess`** denies all:
- Complete denial of direct web access
- Only accessible via PHP includes

### 2. File Permissions

Set correct permissions:
- `laravel/storage/` → 755 (writable)
- `laravel/bootstrap/cache/` → 755 (writable)
- Other directories → 755 (readable)

## ⚠️ Important Notes

1. **All files must be in `public_html/`** - This structure works within that constraint

2. **Laravel core is protected** - `.htaccess` rules prevent direct access to sensitive files

3. **Paths are updated** - `index.php` points to `laravel/` subdirectory

4. **Assets remain public** - `assets/` folder is directly accessible (as intended)

5. **Storage must be writable** - Set permissions on `laravel/storage/` and `laravel/bootstrap/cache/`

## 🚀 Deployment Checklist

- [ ] Restructure files locally (move Laravel core to `public/laravel/`)
- [ ] Update `public/index.php` paths
- [ ] Create protection `.htaccess` files
- [ ] Upload everything to `public_html/`
- [ ] Set file permissions (storage, bootstrap/cache)
- [ ] Create `.env` in `public_html/laravel/`
- [ ] Generate `APP_KEY`
- [ ] Run migrations
- [ ] Test website functionality
- [ ] Verify Laravel core is protected (try accessing `/laravel/app/` - should be denied)

## 🔍 Testing Security

After deployment, test that Laravel core is protected:

1. Try accessing: `https://yourdomain.com/laravel/app/`
   - Should return: 403 Forbidden or 404 Not Found

2. Try accessing: `https://yourdomain.com/laravel/.env`
   - Should return: 403 Forbidden

3. Try accessing: `https://yourdomain.com/`
   - Should load: Your Laravel application ✅

4. Try accessing: `https://yourdomain.com/assets/css/style.css`
   - Should load: CSS file ✅

---

**This structure ensures:**
- ✅ All files in `public_html/` (Hostinger requirement)
- ✅ Laravel core protected from direct access
- ✅ Assets publicly accessible
- ✅ Standard Laravel functionality maintained
