# LuxBid - Laravel Cloud Free Tier Guide

Panduan deployment LuxBid ke **Laravel Cloud Free Tier** dengan konfigurasi optimal.

---

## Free Tier Specifications

Laravel Cloud Free Tier menyediakan:
- ✅ **1 Web Instance** (512MB RAM, shared CPU)
- ✅ **MySQL Database** (1GB storage)
- ✅ **SSL Certificate** (otomatis via Let's Encrypt)
- ✅ **Scheduler** (Laravel cron jobs)
- ✅ **Queue Worker** (1 worker, database driver)
- ✅ **Auto Deployment** dari Git push
- ⚠️ **Bandwidth**: 100GB/bulan
- ⚠️ **Storage**: 1GB untuk aplikasi + database

---

## Persiapan Deployment

### 1. Push ke Repository

```bash
git add .
git commit -m "feat: optimize for Laravel Cloud free tier"
git push origin main
```

### 2. Buat Project di Laravel Cloud

1. Buka [cloud.laravel.com](https://cloud.laravel.com)
2. Pilih **Free Tier**
3. Connect repository **LuxBid**
4. Pilih branch: `main`
5. Region: **Singapore** (terdekat untuk Indonesia)

---

## Environment Variables

Set environment variables berikut di Laravel Cloud dashboard:

### Application

```env
APP_NAME=LuxBid
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-project.laravel.cloud
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id
```

### Database (Auto-provisioned)

Laravel Cloud akan otomatis set database credentials. **Tidak perlu manual config.**

### Email - Brevo Free Tier (300 emails/hari)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=<your-brevo-login>
MAIL_PASSWORD=<your-brevo-api-key>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME=LuxBid
```

**Setup Brevo:**
1. Daftar gratis di [brevo.com](https://www.brevo.com)
2. Verify domain atau gunakan default sender
3. Copy SMTP credentials dari **SMTP & API** tab

### Cache & Queue

```env
CACHE_STORE=database
CACHE_PREFIX=luxbid
QUEUE_CONNECTION=database
SESSION_DRIVER=database
```

### Storage

```env
FILESYSTEM_DISK=local
```

---

## Optimalisasi untuk Free Tier

### 1. Database Optimization

File sudah dikonfigurasi untuk database cache. Tambahkan index untuk performa:

```bash
# Setelah deploy, run via Laravel Cloud terminal:
php artisan migrate
```

Migration sudah termasuk index optimal di:
- `lelang` table: `status`, `tanggal_ditutup`
- `history_lelang` table: `id_lelang`, `id_masyarakat`
- `barang` table: `status`

### 2. Queue Worker Configuration

File `laravel.yaml` sudah dikonfigurasi dengan:
- **1 worker process** (max untuk free tier)
- **128MB memory limit**
- **60s max execution time**
- **100 jobs max per worker**
- **3 max retries**

### 3. Scheduled Tasks

Scheduler berjalan otomatis dengan jobs berikut:

```php
// routes/console.php
Schedule::command('lelang:hapus-barang-kadaluarsa')
    ->dailyAt('01:00')
    ->timezone('Asia/Jakarta');

Schedule::command('lelang:proses-batas-konfirmasi')
    ->hourly()
    ->timezone('Asia/Jakarta');

Schedule::command('lelang:notifikasi-akan-ditutup')
    ->everyFifteenMinutes()
    ->timezone('Asia/Jakarta');
```

### 4. Email Rate Limiting

Untuk avoid exceeding Brevo's 300 emails/day limit:

```php
// app/Jobs/SendEmailJob.php (jika dibuat)
public $tries = 3;
public $timeout = 60;
public $maxExceptions = 2;

// Rate limit: max 12 emails per hour = 288/day (buffer untuk 300 limit)
```

**Monitoring Email Usage:**
- Check Brevo dashboard untuk daily usage
- Jika mendekati limit, prioritaskan email penting (winner notification > bid notification)

---

## Storage Management (1GB Limit)

### File Upload Optimization

**1. Compress Images**

Sudah implemented di `BuktiPembayaranController`:

```php
// Intervention Image compress ke 80% quality
$image->save($path, 80);
```

**2. Set Max Upload Size**

Update `.htaccess` atau `nginx.conf` (Laravel Cloud auto-config):

```
Max upload: 2MB per file
```

**3. Cleanup Old Files**

Tambahkan command untuk hapus file lama:

```bash
php artisan make:command HapusFileLama
```

Scheduled daily untuk hapus:
- Bukti pembayaran > 90 hari (sudah diproses)
- Gambar barang lelang expired > 30 hari

### Monitor Storage Usage

```bash
# Via Laravel Cloud terminal
du -sh storage/app/public/*
```

Jika mendekati 1GB:
- Delete old images manually
- Atau upgrade ke paid tier (10GB storage)

---

## Performance Tips

### 1. Enable Opcache

Laravel Cloud enable opcache by default. Verify:

```bash
php -i | grep opcache
```

### 2. Asset Optimization

Vite sudah configured untuk production build:

```bash
npm run build
# Output: public/build/manifest.json + minified assets
```

### 3. Route & Config Caching

`laravel.yaml` sudah include:

```yaml
build:
  - php artisan config:cache
  - php artisan route:cache
  - php artisan view:cache
  - php artisan event:cache
```

### 4. Database Query Optimization

Gunakan eager loading untuk reduce queries:

```php
// Good
$lelang = Lelang::with('barang', 'pemenang')->get();

// Bad
$lelang = Lelang::all();
foreach ($lelang as $l) {
    $barang = $l->barang; // N+1 query problem
}
```

---

## Monitoring & Maintenance

### 1. Check Application Health

Laravel Cloud provides health check di `/up` endpoint.

Monitor via dashboard:
- Response time
- Error rate
- Memory usage
- Queue depth

### 2. View Logs

```bash
# Install Laravel Cloud CLI
composer global require laravel/cloud-cli

# View logs
cloud logs --follow
```

Atau via dashboard: **Logs → Application**

### 3. Queue Monitoring

Check failed jobs:

```bash
php artisan queue:failed
```

Retry failed jobs:

```bash
php artisan queue:retry all
```

### 4. Database Backup

Laravel Cloud auto-backup database daily (7 days retention di free tier).

Manual backup:

```bash
# Via terminal
php artisan db:backup  # Jika ada package backup
```

---

## Troubleshooting

### Issue: Email Tidak Terkirim

**Check:**
1. Verify Brevo credentials di environment variables
2. Check Brevo dashboard untuk error logs
3. Check queue jobs: `php artisan queue:work --once`

**Solution:**
```bash
# Restart queue worker
php artisan queue:restart

# Check failed jobs
php artisan queue:failed
```

### Issue: Storage Penuh

**Check:**
```bash
du -sh storage/app/public/*
```

**Solution:**
- Delete old files manually
- Implement scheduled cleanup
- Compress images more aggressively
- Upgrade ke paid tier

### Issue: Slow Performance

**Check:**
```bash
# Enable query log di local
DB::enableQueryLog();
// Your code
dd(DB::getQueryLog());
```

**Solution:**
- Add database indexes
- Optimize N+1 queries dengan eager loading
- Cache frequently accessed data
- Consider upgrading tier

### Issue: 502 Bad Gateway

**Check:**
- PHP memory limit exceeded
- Long-running request timeout
- Database connection issues

**Solution:**
```bash
# Check logs
cloud logs --follow

# Restart application
cloud deploy
```

---

## Cost Optimization

### Email Quota Management (300/day limit)

**Priority Queue:**
1. Winner notification (high priority)
2. Payment confirmation (high priority)
3. Bid outbid notification (medium priority)
4. Auction closing reminder (low priority)

**Implementation:**

```php
// Queue with priority
SendEmailJob::dispatch($user, $data)
    ->onQueue('high'); // or 'default' or 'low'
```

Update `laravel.yaml`:

```yaml
workers:
  - name: high-priority
    queue: high
    processes: 1
  - name: default
    queue: default,low
    processes: 1
```

### Bandwidth Optimization (100GB/month)

**Enable Gzip Compression** (Laravel Cloud default)

**Optimize Images:**
- Serve WebP format (modern browsers)
- Use `loading="lazy"` untuk images
- Compress images ke 80% quality

**CDN (Optional):**
- Cloudflare free tier untuk static assets
- Set `ASSET_URL` di `.env`

---

## Scaling Beyond Free Tier

Jika traffic/usage grow, upgrade path:

### Signs You Need to Upgrade:

- ✋ Email quota exceeded (>300/day)
- ✋ Storage full (>1GB)
- ✋ Bandwidth exceeded (>100GB/month)
- ✋ Slow response times (queue backlog)
- ✋ Memory errors (512MB not enough)

### Paid Tier Benefits:

**Starter Plan (~$10/month):**
- 2GB RAM
- 10GB storage
- 500GB bandwidth
- 2 queue workers
- Redis cache
- Daily backups (30 days retention)

**Professional Plan (~$25/month):**
- 4GB RAM
- 25GB storage
- 1TB bandwidth
- Auto-scaling workers
- Redis + Horizon
- Point-in-time database restore

---

## Post-Deployment Checklist

- [ ] Database migrated (`php artisan migrate --force`)
- [ ] Storage linked (`php artisan storage:link`)
- [ ] SSL certificate active (check https://)
- [ ] Environment variables set correctly
- [ ] Email sending works (test registration)
- [ ] Queue worker running (check dashboard)
- [ ] Scheduler running (check activity logs next day)
- [ ] File upload works (test image upload)
- [ ] Payment proof upload works
- [ ] Auction bidding works
- [ ] Email notifications received
- [ ] Admin panel accessible

---

## Security Checklist

- [ ] `APP_DEBUG=false` di production
- [ ] `APP_ENV=production`
- [ ] Strong `APP_KEY` generated
- [ ] Database credentials secure
- [ ] SMTP credentials secure (encrypted variables)
- [ ] HTTPS enforced (Laravel Cloud default)
- [ ] Rate limiting enabled (`throttle` middleware)
- [ ] CSRF protection enabled (Laravel default)
- [ ] XSS protection (Blade `{{ }}` escaping)
- [ ] SQL injection protection (Eloquent ORM)

---

## Support Resources

- **Laravel Cloud Docs**: https://cloud.laravel.com/docs
- **Laravel Docs**: https://laravel.com/docs
- **Brevo Support**: https://help.brevo.com
- **LuxBid Issues**: GitHub Issues di repository

---

## Maintenance Commands

```bash
# View application status
cloud status

# View logs
cloud logs --follow

# View queue status
cloud artisan queue:work --once

# Restart queue worker
cloud artisan queue:restart

# Run artisan command
cloud artisan <command>

# Deploy latest code
cloud deploy

# Enable maintenance mode
cloud artisan down --secret="bypass-token"

# Disable maintenance mode
cloud artisan up
```

---

<div align="center">
<strong>LuxBid pada Laravel Cloud Free Tier</strong><br>
Optimal untuk traffic 1000-5000 pageviews/bulan<br>
<sub>© 2026 LuxBid · TEAM HUNTERS</sub>
</div>
