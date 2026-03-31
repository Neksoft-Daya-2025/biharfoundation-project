# Local Development Setup - XAMPP

## ✅ Structure Restored

The project has been restored to standard Laravel structure for local development:

```
laravel-backend/
├── app/                    ← Application code
├── bootstrap/              ← Bootstrap files
├── config/                 ← Configuration
├── database/               ← Migrations
├── public/                 ← Document root (point XAMPP here)
│   ├── index.php          ← Entry point
│   ├── .htaccess
│   └── assets/            ← Theme assets
├── resources/              ← Views, CSS, JS
├── routes/                 ← Route definitions
├── storage/                ← Storage (must be writable)
├── vendor/                 ← Composer dependencies
├── artisan                 ← Artisan CLI
└── composer.json
```

## 🚀 Setup for XAMPP

### Step 1: Configure XAMPP Virtual Host

1. Open `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
2. Add this configuration:

```apache
<VirtualHost *:80>
    DocumentRoot "C:/Users/ASUS/Desktop/Malbis kitchen/laravel-backend/public"
    ServerName malbis.local
    <Directory "C:/Users/ASUS/Desktop/Malbis kitchen/laravel-backend/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

3. Open `C:\Windows\System32\drivers\etc\hosts` (as Administrator)
4. Add this line:
```
127.0.0.1    malbis.local
```

5. Restart Apache in XAMPP Control Panel

6. Visit: `http://malbis.local`

### Step 2: Alternative - Use Laravel's Built-in Server

```bash
cd "C:\Users\ASUS\Desktop\Malbis kitchen\laravel-backend"
php artisan serve
```

Then visit: `http://localhost:8000`

### Step 3: Configure Environment

1. Copy `.env.example` to `.env`:
   ```bash
   copy .env.example .env
   ```

2. Generate application key:
   ```bash
   php artisan key:generate
   ```

3. Configure database in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=malbis_kitchen
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. Run migrations:
   ```bash
   php artisan migrate
   ```

## ✅ Verification

Check if everything works:
- ✅ `php artisan --version` - Should show Laravel version
- ✅ `http://localhost:8000` or `http://malbis.local` - Should load homepage
- ✅ Assets load correctly (`/assets/css/style.css`)

## 🔧 Troubleshooting

### Issue: "Failed to open stream"
- **Solution**: Make sure you're accessing via web server, not file://
- Use `php artisan serve` or configure XAMPP virtual host

### Issue: "Class not found"
- **Solution**: Run `composer dump-autoload`

### Issue: "Permission denied" on storage
- **Solution**: Set permissions on `storage/` and `bootstrap/cache/` folders

### Issue: Database connection error
- **Solution**: Check `.env` database credentials match your XAMPP MySQL setup

---

**For Hostinger deployment later:** Use the `restructure-for-hostinger.ps1` script when ready to deploy.
