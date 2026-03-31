# Quick Start - Local Development

## ✅ Project Restored to Standard Structure

All files have been moved back to standard Laravel structure for local development.

## 🚀 Start the Server

### Option 1: Laravel Built-in Server (Recommended)
```bash
cd "C:\Users\ASUS\Desktop\Malbis kitchen\laravel-backend"
php artisan serve
```
Then visit: **http://localhost:8000**

### Option 2: XAMPP
1. Point XAMPP document root to: `laravel-backend/public`
2. Or configure virtual host (see `LOCAL_SETUP.md`)
3. Visit: **http://localhost** (or your configured domain)

## ⚙️ Initial Setup

1. **Create .env file** (if not exists):
   ```bash
   copy .env.example .env
   ```

2. **Generate APP_KEY**:
   ```bash
   php artisan key:generate
   ```

3. **Configure Database** in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=malbis_kitchen
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

## ✅ Verify It Works

- Homepage: `http://localhost:8000/`
- About: `http://localhost:8000/about`
- Services: `http://localhost:8000/services`
- Login: `http://localhost:8000/login`
- Dashboard: `http://localhost:8000/dashboard` (after login)

## 🔧 If You See Errors

1. **Clear caches**:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   ```

2. **Regenerate autoload**:
   ```bash
   composer dump-autoload
   ```

3. **Check file permissions**:
   - `storage/` and `bootstrap/cache/` should be writable

---

**Status:** ✅ Ready for local development!

**For Hostinger later:** Run `restructure-for-hostinger.ps1` when ready to deploy.
