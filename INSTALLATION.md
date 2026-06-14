# LuxBid — Panduan Instalasi Production

## Checklist Pre-Deploy

- [ ] PHP 8.3+ dengan ekstensi: `pdo_mysql`, `gd`, `mbstring`, `openssl`, `tokenizer`, `xml`
- [ ] MySQL 8.0+
- [ ] Composer 2.x
- [ ] Node.js 18.x (untuk build assets, tidak perlu di server)

---

## Langkah Instalasi

### 1. Upload & Dependensi

```bash
git clone <repo-url> /var/www/luxbid
cd /var/www/luxbid
composer install --no-dev --optimize-autoloader
```

### 2. Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` — pastikan nilai berikut benar:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=luxbid
DB_USERNAME=luxbid_user
DB_PASSWORD=<strong_password>

QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=2525
MAIL_USERNAME=<brevo_login>
MAIL_PASSWORD=<brevo_key>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME=LuxBid
```

### 3. Database

```bash
php artisan migrate --force
php artisan db:seed --force
```

### 4. Build Assets

Jalankan di local lalu upload folder `public/build/`, atau install Node di server:

```bash
npm install && npm run build
```

### 5. Storage Link

```bash
php artisan storage:link
```

### 6. Optimasi Cache

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. Permission

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 8. Web Server (Nginx)

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/luxbid/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 9. Queue Worker (Supervisor)

Buat file `/etc/supervisor/conf.d/luxbid-worker.conf`:

```ini
[program:luxbid-worker]
command=php /var/www/luxbid/artisan queue:work --tries=3 --timeout=60 --sleep=3
directory=/var/www/luxbid
user=www-data
autostart=true
autorestart=true
stdout_logfile=/var/log/luxbid-worker.log
```

```bash
supervisorctl reread
supervisorctl update
supervisorctl start luxbid-worker
```

### 10. Scheduler (Cron)

```bash
crontab -e
```

Tambahkan:

```
* * * * * cd /var/www/luxbid && php artisan schedule:run >> /dev/null 2>&1
```

---

## Verifikasi

```bash
# Cek aplikasi berjalan
curl -I https://yourdomain.com

# Cek queue worker aktif
supervisorctl status luxbid-worker

# Cek scheduler
php artisan schedule:list

# Jalankan tests
php artisan test
```

---

## Rollback Migration

```bash
php artisan migrate:rollback
```

## Reset Cache Setelah Update

```bash
php artisan optimize:clear
php artisan optimize
```
