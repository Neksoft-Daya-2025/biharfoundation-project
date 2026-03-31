# Hostinger Shared Hosting Deployment Guide
## ⚠️ ALL FILES MUST BE IN public_html/

### Current Project Status:
- ✅ **Laravel Version**: 12.0 (requires PHP 8.2+)
- ✅ **PHP Requirement**: PHP ^8.2
- ⚠️ **Hostinger Compatibility**: Most Hostinger shared plans support PHP 8.1-8.3 ✅
- ⚠️ **Important**: On Hostinger shared hosting, ALL files must be in `public_html/`

## 📋 Pre-Deployment Checklist

### 1. PHP Version Check
- ✅ Hostinger shared hosting supports PHP 8.2+ (check your plan)
- Verify in Hostinger control panel: **PHP Version** → Select PHP 8.2 or 8.3

### 2. Required Extensions
Ensure these PHP extensions are enabled (usually enabled by default):
- ✅ `openssl`
- ✅ `pdo`
- ✅ `mbstring`
- ✅ `tokenizer`
- ✅ `xml`
- ✅ `ctype`
- ✅ `json`
- ✅ `fileinfo`
- ✅ `curl`

### 3. File Structure for Hostinger (All in public_html)

**After Restructuring:**
```
public_html/                    ← Document root (ALL files here)
├── index.php                   ← Updated to point to laravel/
├── .htaccess                   ← Protection rules
├── assets/                     ← Theme assets (publicly accessible)
│   ├── css/
│   ├── js/
│   └── images/
├── favicon.ico
├── robots.txt
├── malbi-kitchen-logo.svg
│
└── laravel/                    ← Laravel core (protected by .htaccess)
    ├── .htaccess               ← Denies all access
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/                ← Must be writable (755)
    ├── vendor/
    ├── artisan
    ├── composer.json
    └── .env                    ← Create this on server
```

**⚠️ IMPORTANT:** Run `restructure-for-hostinger.ps1` script first to move Laravel core into `public/laravel/`

## 🚀 Deployment Steps

### Step 0: Restructure Project Locally (REQUIRED)

**Run the restructuring script:**
```powershell
cd laravel-backend
.\restructure-for-hostinger.ps1
```

This will:
- Create `public/laravel/` directory
- Move Laravel core files into `public/laravel/`
- Create protection `.htaccess` files
- Update paths in `public/index.php`

**Or manually restructure** (see `RESTRUCTURE_FOR_HOSTINGER.md`)

### Step 1: Upload Files to Hostinger

**Option A: Using FTP/SFTP**
1. Connect to your Hostinger hosting via FTP
2. Navigate to `public_html/` directory
3. Upload **ALL contents** of `laravel-backend/public/` folder to `public_html/`
   - This includes: `index.php`, `.htaccess`, `assets/`, `laravel/`, etc.

**Option B: Using File Manager**
1. Login to Hostinger hPanel
2. Go to **File Manager**
3. Navigate to `public_html/`
4. Upload all files from `laravel-backend/public/` folder

### Step 2: Verify Paths in public/index.php

The `public/index.php` has been updated to point to `laravel/` subdirectory:

```php
<?php
// Paths point to laravel/ subdirectory
require __DIR__.'/laravel/vendor/autoload.php';
$app = require_once __DIR__.'/laravel/bootstrap/app.php';
```

**✅ Already configured** - No changes needed if you ran the restructuring script.

### Step 3: Install Composer Dependencies

**Via SSH (if available):**
```bash
cd public_html/laravel
composer install --no-dev --optimize-autoloader
```

**Via Hostinger Terminal (if available):**
- Access Terminal in hPanel
- Navigate to `public_html/laravel/`
- Run: `composer install --no-dev --optimize-autoloader`

**If SSH/Terminal not available:**
- Install dependencies locally in `public/laravel/`
- Upload `public/laravel/vendor/` folder via FTP

### Step 4: Set File Permissions

Set these permissions via File Manager or FTP:
```
public_html/laravel/storage/                    → 755 (or 775)
public_html/laravel/storage/framework/          → 755
public_html/laravel/storage/framework/cache/    → 755
public_html/laravel/storage/framework/sessions/ → 755
public_html/laravel/storage/framework/views/    → 755
public_html/laravel/storage/logs/               → 755
public_html/laravel/bootstrap/cache/            → 755
```

### Step 5: Configure Environment

1. Copy `.env.example` to `.env` in `public_html/laravel/` directory
2. Update `.env` with your Hostinger database credentials:

```env
APP_NAME="Malbis Kitchen"
APP_ENV=production
APP_KEY=                    # Generate with: php artisan key:generate
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost          # Usually localhost on Hostinger
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

ADMIN_EMAIL=admin@malbiskitchen.nl
ADMIN_PASSWORD=your_secure_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your_email@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 6: Generate Application Key

**Via SSH/Terminal:**
```bash
cd public_html/laravel
php artisan key:generate
```

**If SSH not available:**
- Generate locally in `public/laravel/`: `php artisan key:generate`
- Copy the `APP_KEY` from local `.env` to server `.env` in `public_html/laravel/`

### Step 7: Run Migrations

**Via SSH/Terminal:**
```bash
cd public_html/laravel
php artisan migrate --force
```

**If SSH not available:**
- Run migrations locally pointing to production database
- Or use Hostinger's phpMyAdmin to import SQL

### Step 8: Optimize for Production

**Via SSH/Terminal:**
```bash
cd public_html/laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**If SSH not available:**
- Create a temporary route to run these commands
- Or run locally and upload cached files

### Step 9: Update .htaccess (if needed)

The default `.htaccess` should work, but if you have issues, update `public_html/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## ✅ Structure Already Configured

The project is now structured for Hostinger shared hosting where ALL files must be in `public_html/`:

- ✅ Laravel core is in `public_html/laravel/` (protected by `.htaccess`)
- ✅ Public assets are in `public_html/assets/` (directly accessible)
- ✅ `index.php` points to `laravel/` subdirectory
- ✅ Protection rules prevent direct access to Laravel core files

**No alternative structure needed** - This is the correct setup for Hostinger shared hosting.

## ⚠️ Common Issues & Solutions

### Issue 1: 500 Internal Server Error
**Solution:**
- Check file permissions (storage, bootstrap/cache)
- Check `.env` file exists and is configured
- Check error logs: `storage/logs/laravel.log`
- Verify `APP_KEY` is set

### Issue 2: Assets Not Loading
**Solution:**
- Ensure `public/assets/` folder is in `public_html/assets/`
- Check file permissions on assets folder
- Verify `APP_URL` in `.env` matches your domain

### Issue 3: Database Connection Error
**Solution:**
- Verify database credentials in `.env`
- Check database host (usually `localhost` on Hostinger)
- Ensure database user has proper permissions

### Issue 4: Composer Not Available
**Solution:**
- Install dependencies locally
- Upload `vendor` folder
- Or use Hostinger's Composer installer in hPanel

### Issue 5: Artisan Commands Not Accessible
**Solution:**
- Use Hostinger Terminal if available
- Or create a web-accessible script to run commands
- Or use cron jobs for scheduled tasks

## 📝 Post-Deployment Checklist

- [ ] PHP version set to 8.2 or 8.3
- [ ] All files uploaded correctly
- [ ] Composer dependencies installed
- [ ] `.env` file configured
- [ ] `APP_KEY` generated
- [ ] File permissions set correctly
- [ ] Database migrations run
- [ ] Cache optimized
- [ ] Assets loading correctly
- [ ] Routes working
- [ ] Admin login accessible

## 🔒 Security Recommendations

1. **Hide .env file**: Ensure `.env` is not accessible via web
2. **Protect storage**: Don't expose `storage` folder
3. **HTTPS**: Enable SSL certificate in Hostinger
4. **Strong passwords**: Use strong admin and database passwords
5. **Regular updates**: Keep Laravel and dependencies updated

## 📞 Hostinger-Specific Notes

- **PHP Version**: Change in hPanel → PHP Configuration
- **Database**: Create in hPanel → MySQL Databases
- **Email**: Configure SMTP settings in `.env`
- **SSL**: Enable in hPanel → SSL/TLS
- **Cron Jobs**: Set up in hPanel → Cron Jobs (for scheduled tasks)

---

**Need Help?** Check Hostinger's documentation or Laravel deployment guide.
