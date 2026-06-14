# LuxBid — Deployment ke Laravel Cloud

Panduan deployment **LuxBid** ke [Laravel Cloud](https://cloud.laravel.com) dengan konfigurasi optimal untuk production.

---

## Prerequisites

- Akun Laravel Cloud (beta access atau subscription aktif)
- Repository GitHub/GitLab dengan akses deploy keys
- Database MySQL (disediakan otomatis oleh Laravel Cloud)
- SMTP credentials (Brevo/Mailgun/SES untuk email)

---

## 1. Persiapan Repository

### Pastikan File Konfigurasi Ada

Laravel Cloud membutuhkan file konfigurasi berikut (sudah tersedia di repo):

```bash
# Cek keberadaan file
ls -la .env.example composer.json package.json vite.config.js
```

### Update `.env.example`

Pastikan `.env.example` berisi semua environment variables yang dibutuhkan:

```env
APP_NAME=LuxBid
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"

SESSION_DRIVER=database
SESSION_LIFETIME=120

VITE_APP_NAME="${APP_NAME}"
```

### Commit Semua Perubahan

```bash
git add .
git commit -m "chore: prepare for Laravel Cloud deployment"
git push origin main
```

---

## 2. Setup Project di Laravel Cloud

### 2.1 Create New Project

1. Login ke [cloud.laravel.com](https://cloud.laravel.com)
2. Klik **"New Project"**
3. Pilih repository **LuxBid**
4. Pilih branch: `main`
5. Region: pilih yang terdekat dengan user mayoritas (Singapore/Tokyo untuk Indonesia)

### 2.2 Environment Configuration

Laravel Cloud akan otomatis detect Laravel project. Set environment variables:

#### Database (Auto-provisioned)
Laravel Cloud akan create MySQL database otomatis. No action needed.

#### Mail Configuration
Tambahkan SMTP credentials di **Environment Variables**:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=your_brevo_email
MAIL_PASSWORD=your_brevo_api_key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

#### Session & Queue
```
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

---

## 3. Build Configuration

Laravel Cloud menggunakan **Nixpacks** untuk build. Konfigurasi otomatis detect:

### PHP Version
Pastikan `composer.json` specify PHP 8.3+:

```json
{
  "require": {
    "php": "^8.3"
  }
}
```

### Build Commands (Auto-detected)
Laravel Cloud akan run:

```bash
composer install --no-dev --optimize-autoloader
npm install && npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Custom Build Script (Optional)

Jika perlu custom build steps, tambahkan `build.sh`:

```bash
#!/bin/bash
set -e

# Composer install
composer install --no-dev --optimize-autoloader --no-interaction

# NPM build
npm ci --no-audit
npm run build

# Laravel optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage link
php artisan storage:link
```

Lalu tambahkan ke `.laravelcloud.yml`:

```yaml
build:
  commands:
    - bash build.sh
```

---

## 4. Deployment Configuration

### 4.1 Deploy Script

Laravel Cloud will auto-run migrations. Default deploy script:

```bash
php artisan migrate --force
php artisan optimize
```

### 4.2 Queue Worker

Laravel Cloud automatically provisions queue workers. Configure di dashboard:

- **Queue Connection:** `database` (default)
- **Worker Processes:** 1-2 (scale based on email volume)
- **Timeout:** 60s
- **Max Tries:** 3

### 4.3 Scheduler

Laravel Cloud automatically runs Laravel scheduler. No cron setup needed.

Scheduled jobs akan run otomatis:
- `ProsesBatasKonfirmasi` — setiap 30 menit
- `lelang:hapus-barang-kadaluarsa` — setiap hari 01:00 WIB

---

## 5. Database Migration

### Initial Migration

Setelah first deploy, run migrations via Laravel Cloud terminal:

```bash
php artisan migrate --seed --force
```

Atau via dashboard: **Deployments → Run Command**

### Subsequent Deploys

Migrations run otomatis pada setiap deployment.

---

## 6. Storage & Assets

### Public Assets

Laravel Cloud otomatis build dan serve assets via Vite. File di `public/build/` akan accessible.

### File Uploads

Laravel Cloud provides persistent storage. Configure di `.env`:

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=ap-southeast-1
AWS_BUCKET=luxbid-uploads
```

Atau gunakan Laravel Cloud Storage (included):

```env
FILESYSTEM_DISK=cloud
```

### Update Storage Config

Edit `config/filesystems.php` jika perlu custom disk:

```php
'cloud' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
],
```

---

## 7. Custom Domain

### 7.1 Add Domain

1. Go to **Project Settings → Domains**
2. Click **"Add Domain"**
3. Enter: `luxbid.yourdomain.com`
4. Laravel Cloud will provide DNS records

### 7.2 Update DNS

Di DNS provider (Cloudflare/Namecheap/Route53), tambahkan:

```
Type: CNAME
Name: luxbid
Value: <laravel-cloud-provided-cname>
TTL: Auto
```

### 7.3 SSL Certificate

Laravel Cloud otomatis provision SSL via Let's Encrypt. Wait 5-10 menit setelah DNS propagate.

### 7.4 Update Environment

```env
APP_URL=https://luxbid.yourdomain.com
```

Redeploy untuk apply changes.

---

## 8. Monitoring & Logs

### Application Logs

View logs di dashboard: **Logs → Application**

Atau via CLI:

```bash
# Install Laravel Cloud CLI
composer global require laravel/cloud-cli

# View logs
cloud logs --follow
```

### Queue Monitoring

Laravel Cloud includes **Horizon** integration (optional). Enable di dashboard.

### Performance Monitoring

Laravel Cloud provides basic metrics:
- Response time
- Memory usage
- Queue depth
- Error rate

---

## 9. Environment Variables Management

### Via Dashboard

1. Go to **Project Settings → Environment**
2. Click **"Add Variable"**
3. Enter key & value
4. Click **"Save & Redeploy"**

### Via CLI (Advanced)

```bash
cloud env:set MAIL_HOST=smtp.new-provider.com
cloud env:set MAIL_PASSWORD=new_password
cloud deploy
```

### Secrets Management

Untuk sensitive data (API keys, passwords), use **Encrypted Variables**:

1. Enable encryption di project settings
2. Add variable dengan checkbox "Encrypted"
3. Values will be encrypted at rest

---

## 10. Scaling & Performance

### Horizontal Scaling

Laravel Cloud auto-scales based on traffic. Configure di dashboard:

- **Min Instances:** 1
- **Max Instances:** 5 (adjust based on traffic)
- **Scale Up Threshold:** 70% CPU or 80% memory
- **Scale Down Threshold:** 30% CPU for 5 minutes

### Database Optimization

#### Enable Query Caching

```env
DB_CACHE_ENABLED=true
```

#### Connection Pooling

Laravel Cloud uses PgBouncer-style pooling. Default config optimal untuk most apps.

### Redis Cache (Optional)

Upgrade plan untuk Redis instance:

```env
CACHE_DRIVER=redis
REDIS_HOST=<laravel-cloud-provided>
REDIS_PASSWORD=<laravel-cloud-provided>
REDIS_PORT=6379
```

Update `config/cache.php`:

```php
'default' => env('CACHE_DRIVER', 'redis'),
```

---

## 11. Backup & Disaster Recovery

### Database Backups

Laravel Cloud automatically backup database:
- **Frequency:** Daily
- **Retention:** 30 days (adjust in settings)
- **Point-in-time restore:** Available

### Restore from Backup

Via dashboard: **Database → Backups → Restore**

### Application Code Backup

Code is in Git. Rollback via:

1. **Deployments → History**
2. Select previous deployment
3. Click **"Rollback"**

---

## 12. Troubleshooting

### Deployment Fails

**Check build logs:**

```bash
cloud logs --build
```

**Common issues:**
- Composer dependencies conflict → update `composer.json`
- NPM build fails → check `package.json` scripts
- Missing environment variables → verify `.env` in dashboard

### Queue Not Processing

**Check queue worker status:**

Dashboard → **Queue Workers → Status**

**Restart workers:**

```bash
cloud queue:restart
```

### Slow Performance

**Enable opcache:**

Laravel Cloud enables opcache by default. Verify via:

```bash
cloud tinker
>>> phpinfo(INFO_GENERAL);
```

**Check query performance:**

Enable Laravel Debugbar (local only) or use Laravel Telescope:

```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

---

## 13. Cost Optimization

### Resource Right-Sizing

Start dengan:
- **1 web instance** (1GB RAM, 1 vCPU)
- **1 queue worker**
- **Shared MySQL** (default)

Scale up berdasarkan metrics.

### Asset Optimization

```bash
# Optimize images before deployment
npm install -D vite-plugin-image-optimizer
```

Update `vite.config.js`:

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import ImageOptimizer from 'vite-plugin-image-optimizer';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        ImageOptimizer(),
    ],
});
```

---

## 14. Security Best Practices

### Force HTTPS

Laravel Cloud enforces HTTPS by default. Verify di `app/Providers/AppServiceProvider.php`:

```php
public function boot()
{
    if (app()->environment('production')) {
        \URL::forceScheme('https');
    }
}
```

### Rate Limiting

Already configured di `routes/web.php`:

```php
Route::post('/login', ...)->middleware('throttle:5,1');
```

Adjust throttle limits based on usage patterns.

### Environment Security

Never commit `.env` atau sensitive keys. Use Laravel Cloud's encrypted environment variables.

---

## 15. Post-Deployment Checklist

- [ ] Run `php artisan migrate --seed --force`
- [ ] Verify custom domain & SSL active
- [ ] Test email sending (registration, notifications)
- [ ] Test queue worker (submit bid, check outbid email)
- [ ] Test file upload (barang gambar, bukti pembayaran)
- [ ] Verify scheduler running (check `activity_logs` table)
- [ ] Set up monitoring alerts (Laravel Cloud dashboard)
- [ ] Configure backup retention (30 days recommended)
- [ ] Test payment proof upload & admin verification workflow
- [ ] Verify wishlist & rating features working
- [ ] Test auto-reassignment when winner timeout

---

## 16. Maintenance Mode

### Enable Maintenance

```bash
cloud artisan down --secret="bypass-token"
```

Access site via: `https://yourdomain.com/bypass-token`

### Disable Maintenance

```bash
cloud artisan up
```

---

## Support & Resources

- **Laravel Cloud Docs:** https://cloud.laravel.com/docs
- **Status Page:** https://status.laravel.com
- **Support:** support@laravel.com
- **LuxBid Repo:** https://github.com/your-org/luxbid

---

<div align="center">
<sub>© 2026 LuxBid · TEAM HUNTERS · Deployed with ❤️ on Laravel Cloud</sub>
</div>
