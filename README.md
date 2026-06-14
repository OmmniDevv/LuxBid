# LuxBid — Platform Lelang Barang Mewah

Aplikasi web lelang berbasis Laravel 13 dengan fitur real-time timer, notifikasi email, manajemen barang & peserta.

## Tech Stack

- **Backend:** PHP 8.3, Laravel 13
- **Frontend:** Blade, Tailwind CSS v4, Vite
- **Database:** MySQL 8+
- **Queue:** Laravel Database Queue
- **Image Processing:** Intervention Image v3 (GD)
- **PDF:** barryvdh/laravel-dompdf

## Requirements

- PHP >= 8.3 dengan ekstensi: `pdo_mysql`, `gd`, `mbstring`, `openssl`, `tokenizer`, `xml`
- MySQL >= 8.0
- Composer >= 2.x
- Node.js >= 18.x + npm

## Setup Cepat (Development)

```bash
# 1. Clone & install dependencies
git clone <repo-url> luxbid
cd luxbid
composer install
npm install

# 2. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 3. Edit .env — isi DB_*, MAIL_* (lihat bagian Konfigurasi)

# 4. Buat database & jalankan migration + seeder
php artisan migrate --seed

# 5. Build assets & jalankan server
composer dev
```

Akses: `http://127.0.0.1:8000`

Login default:
- Admin: `admin` / `admin`
- Petugas: `petugas` / `petugas`

## Konfigurasi .env

```env
APP_NAME=LuxBid
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=luxbid
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=2525
MAIL_USERNAME=<brevo_login>
MAIL_PASSWORD=<brevo_key>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@luxbid.id
MAIL_FROM_NAME=LuxBid
```

## Menjalankan Queue Worker

Email notifikasi (outbid, lelang dibuka/ditutup/menang) dikirim via queue:

```bash
php artisan queue:work --tries=3 --timeout=60
```

## Menjalankan Tests

```bash
php artisan test
```

## Fitur Utama

### Core Auction Features
- **Auth** — Register/login masyarakat dengan verifikasi email, login petugas/admin
- **Manajemen Barang** — CRUD barang dengan upload gambar (auto-resize ke WebP 1200px)
- **Sistem Lelang** — Buka/tutup lelang, timer otomatis reset 6 menit per bid
- **Penawaran** — Submit bid dengan validasi min (+Rp1.000) dan max (20× harga awal)

### Winner Management
- **Konfirmasi Kemenangan** — Pemenang wajib konfirmasi dalam 24 jam, auto-reassignment jika timeout
- **Bukti Pembayaran** — Upload & verifikasi bukti transfer dengan approval workflow
- **Rating & Review** — System rating 1-5 bintang dengan komentar untuk pemenang

### User Experience
- **Wishlist** — Save barang favorit dengan counter real-time
- **Riwayat Penawaran** — Track semua lelang yang pernah diikuti dengan detail bid
- **Notifikasi Email** — 10+ email templates untuk berbagai event (queued)

### Admin Tools
- **Enhanced Dashboard** — Metrics: pending confirmations, payment verifications, total revenue
- **Activity Log** — Audit trail dengan filter by action & date range
- **Export Excel** — Download laporan lengkap dengan filter status
- **Laporan PDF** — Generate faktur & laporan dengan dompdf
