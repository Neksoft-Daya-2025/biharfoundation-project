# Hostinger Deployment Checklist

## ✅ Pre-Deployment

- [ ] Verify Hostinger plan supports PHP 8.2+
- [ ] Check available disk space
- [ ] Note database credentials from Hostinger
- [ ] Note FTP/SFTP credentials

## 📤 Upload Files

- [ ] Upload entire `laravel-backend` folder to server root (outside public_html)
- [ ] Copy `public` folder contents to `public_html`
- [ ] Verify all files uploaded correctly

## ⚙️ Configuration

- [ ] Set PHP version to 8.2 or 8.3 in Hostinger hPanel
- [ ] Copy `.env.example` to `.env`
- [ ] Configure database credentials in `.env`
- [ ] Configure mail settings in `.env`
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_URL=https://yourdomain.com`
- [ ] For live payments: set `MOLLIE_KEY` in `.env` (Mollie API key from [Mollie Dashboard](https://www.mollie.com/dashboard))

## 🔑 Security

- [ ] Generate `APP_KEY` (run `php artisan key:generate`)
- [ ] Set file permissions:
  - [ ] `storage/` → 755
  - [ ] `storage/framework/` → 755
  - [ ] `storage/logs/` → 755
  - [ ] `bootstrap/cache/` → 755
- [ ] Verify `.env` is not web-accessible

## 📦 Dependencies

- [ ] Install Composer dependencies (`composer install --no-dev`)
- [ ] Or upload `vendor` folder if Composer unavailable

## 🗄️ Database

- [ ] Create database in Hostinger hPanel
- [ ] Create database user
- [ ] Run migrations (`php artisan migrate`)
- [ ] Verify database connection

## 🚀 Optimization

- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`

## ✅ Testing

- [ ] Visit homepage - should load correctly
- [ ] Check assets loading (CSS, JS, images)
- [ ] Test admin login (`/login`)
- [ ] Test dashboard (`/dashboard`)
- [ ] Test API endpoints
- [ ] Check error logs for issues

## 🔧 Post-Deployment

- [ ] Set up SSL certificate (HTTPS)
- [ ] Configure cron jobs (if needed)
- [ ] Set up email notifications
- [ ] Monitor error logs
- [ ] Backup database regularly

---

**Quick Test URLs:**
- Homepage: `https://yourdomain.com/`
- Login: `https://yourdomain.com/login`
- Dashboard: `https://yourdomain.com/dashboard`
- API Test: `https://yourdomain.com/api/settings`
