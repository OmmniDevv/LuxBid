# LuxBid - Laravel Cloud Deployment Checklist

Quick checklist untuk deployment ke Laravel Cloud Free Tier.

---

## Pre-Deployment

### 1. Code Preparation
- [ ] All changes committed ke Git
- [ ] Tests passing locally (`php artisan test`)
- [ ] No merge conflicts
- [ ] Branch: `main` up to date

```bash
git add .
git commit -m "feat: prepare for Laravel Cloud deployment"
git push origin main
```

### 2. Repository Access
- [ ] Repository accessible di GitHub/GitLab
- [ ] Laravel Cloud punya akses ke repository
- [ ] Deploy keys configured (if private repo)

---

## Laravel Cloud Setup

### 3. Create Project
- [ ] Login ke [cloud.laravel.com](https://cloud.laravel.com)
- [ ] Select **Free Tier** plan
- [ ] Connect repository: **LuxBid**
- [ ] Select branch: `main`
- [ ] Select region: **Singapore** (recommended untuk Indonesia)

### 4. Environment Variables

Copy-paste ke Laravel Cloud Environment Variables panel:

```env
# Application
APP_NAME=LuxBid
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-project.laravel.cloud
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id
APP_FALLBACK_LOCALE=id

# Logging
LOG_LEVEL=error
LOG_CHANNEL=stack

# Cache & Session
CACHE_STORE=database
CACHE_PREFIX=luxbid
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# Storage
FILESYSTEM_DISK=local
```

**Database** akan auto-configured oleh Laravel Cloud. ✅

### 5. Email Configuration (Brevo)

Gunakan kredensial Brevo yang sudah ada:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=<your-brevo-smtp-username>
MAIL_PASSWORD=<your-brevo-smtp-key>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=<your-sender-email>
MAIL_FROM_NAME=LuxBid
```

⚠️ **Note**: Brevo free tier limit = **300 emails/hari**

---

## Initial Deployment

### 6. Trigger First Deploy
- [ ] Click **Deploy** di Laravel Cloud dashboard
- [ ] Wait for build to complete (3-5 menit)
- [ ] Check build logs untuk errors

### 7. Run Initial Commands

Via Laravel Cloud Terminal (Dashboard → Terminal):

```bash
# Run migrations with seeder
php artisan migrate --seed --force

# Verify storage link
php artisan storage:link

# Clear all caches
php artisan optimize:clear

# Warm up caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 8. Verify Services

#### A. Check Web Server
- [ ] Visit: `https://your-project.laravel.cloud`
- [ ] Homepage loads correctly
- [ ] SSL certificate active (🔒 hijau di browser)

#### B. Check Database
```bash
php artisan tinker
>>> \App\Models\Masyarakat::count();
>>> \App\Models\Barang::count();
```

#### C. Check Queue Worker
```bash
# Dashboard → Queue Workers → Status: "Running" ✅
```

#### D. Check Scheduler
```bash
# Check scheduled tasks
php artisan schedule:list

# Test scheduler (will run all due tasks)
php artisan schedule:run
```

---

## Feature Testing

### 9. Test User Flows

#### Registration & Login
- [ ] Register new account (test email verification)
- [ ] Check email received (Brevo dashboard)
- [ ] Login with new account
- [ ] Logout works

#### Auction Features
- [ ] Create new auction (as admin/petugas)
- [ ] Upload gambar barang (max 2MB)
- [ ] View auction list
- [ ] Place bid (as masyarakat)
- [ ] Receive outbid email notification

#### Payment Flow
- [ ] Upload bukti pembayaran
- [ ] Admin verify payment
- [ ] Winner receives confirmation email
- [ ] Check activity logs

#### Wishlist & Ratings
- [ ] Add item to wishlist
- [ ] Remove from wishlist
- [ ] Submit rating after winning
- [ ] View ratings on auction

### 10. Admin Panel
- [ ] Admin login works
- [ ] Dashboard loads with statistics
- [ ] Export lelang ke Excel works
- [ ] Export lelang ke PDF works
- [ ] Activity logs visible

---

## Performance Verification

### 11. Check Metrics

Dashboard → Metrics:
- [ ] Response time < 500ms (average)
- [ ] Memory usage < 400MB (of 512MB available)
- [ ] Queue depth < 10 jobs
- [ ] Error rate < 1%

### 12. Check Logs

Dashboard → Logs:
- [ ] No PHP errors
- [ ] No database connection errors
- [ ] No mail sending errors
- [ ] No queue worker errors

---

## Custom Domain (Optional)

### 13. Add Domain

**Skip this if using default *.laravel.cloud domain**

1. Dashboard → Domains → Add Domain
2. Enter: `luxbid.yourdomain.com`
3. Copy CNAME record provided

### 14. DNS Configuration

Di DNS provider (Cloudflare/Namecheap):

```
Type: CNAME
Name: luxbid
Value: <laravel-cloud-provided-cname>
TTL: Auto
```

Wait 5-10 menit untuk DNS propagation.

### 15. Update APP_URL

```env
APP_URL=https://luxbid.yourdomain.com
```

Klik **Save & Redeploy**.

---

## Post-Deployment Monitoring

### 16. Daily Monitoring (First Week)

**Day 1-3:**
- [ ] Check error logs setiap 4 jam
- [ ] Monitor email quota (Brevo dashboard)
- [ ] Check queue depth
- [ ] Verify scheduler running (check activity_logs table)

**Day 4-7:**
- [ ] Check logs daily
- [ ] Monitor storage usage: `du -sh storage/app/public/*`
- [ ] Check database size: Dashboard → Database → Usage

### 17. Email Quota Management

Login ke [app.brevo.com](https://app.brevo.com):
- [ ] Current usage: X / 300 emails per day
- [ ] Setup alert di Brevo untuk 80% quota (240 emails)

**If approaching limit:**
- Prioritize winner/payment notifications
- Delay low-priority notifications
- Consider upgrading Brevo plan ($25/month = 20k emails)

### 18. Storage Management

Check storage usage:
```bash
du -sh storage/app/public/barang-images/*
du -sh storage/app/public/bukti-pembayaran/*
```

**If approaching 1GB:**
- Implement scheduled cleanup (LARAVEL_CLOUD_FREE_TIER.md)
- Compress images more aggressively
- Delete old expired auction images
- Consider upgrading tier ($10/month = 10GB)

---

## Rollback Plan

### If Deployment Fails

**Option 1: Rollback via Dashboard**
1. Dashboard → Deployments → History
2. Select previous working deployment
3. Click **Rollback**

**Option 2: Fix Forward**
1. Fix issue locally
2. Commit & push fix
3. Auto-deploy triggers

**Option 3: Enable Maintenance Mode**
```bash
cloud artisan down --secret="luxbid-bypass"
# Access via: https://your-project.laravel.cloud/luxbid-bypass
# Fix issue
cloud artisan up
```

---

## Success Criteria

Deployment berhasil jika:
- ✅ Website accessible via HTTPS
- ✅ Users dapat register & login
- ✅ Email notifications terkirim
- ✅ Auction bidding works
- ✅ Payment upload & verification works
- ✅ Queue worker processing jobs
- ✅ Scheduler running (check next day)
- ✅ No errors in logs (24 jam pertama)
- ✅ Response time < 1 detik
- ✅ SSL certificate valid

---

## Support

### Laravel Cloud
- Docs: https://cloud.laravel.com/docs
- Status: https://status.laravel.com
- Support: support@laravel.com

### Brevo (Email)
- Dashboard: https://app.brevo.com
- Support: https://help.brevo.com

### LuxBid
- Repository: GitHub
- Documentation: See `LARAVEL_CLOUD_FREE_TIER.md`

---

**Last Updated**: 2026-06-15  
**Deployment Guide**: `LARAVEL_CLOUD_FREE_TIER.md`  
**Configuration**: `laravel.yaml`, `.env.example`
