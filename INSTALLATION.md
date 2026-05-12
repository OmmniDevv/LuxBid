<div align="center">

<br/>

# 🚀 LuxBid — Installation Guide

**Panduan instalasi lengkap untuk menjalankan LuxBid di local environment**

by **[TEAM HUNTERS](https://github.com/OmmniDevv)** · XI PPLG 2

<br/>

---

</div>

<br/>

## 📋 Requirements

Pastikan sistem kamu memenuhi semua requirement berikut sebelum memulai:

| Dependency | Versi Minimum | Keterangan |
|------------|---------------|------------|
| **PHP** | `>= 8.2` | Dengan extension: mbstring, pdo_mysql, openssl, tokenizer, xml |
| **Composer** | `>= 2.x` | PHP dependency manager |
| **MySQL / MariaDB** | `>= 8.0` | Database utama |
| **Node.js** | `>= 18.x` | Untuk kompilasi asset Tailwind (wajib) |
| **NPM** | `>= 9.x` | Ikut terinstall bersama Node.js |

> **⚠️ Catatan Windows (Laragon/XAMPP):**  
> Laravel 13 membutuhkan PHP ^8.3. Jika menggunakan PHP 8.5+, jalankan `composer install --ignore-platform-reqs` untuk bypass platform check.

<br/>

---

## ⚙️ Langkah Instalasi

<br/>

### Step 1 — Clone Repository

```bash
git clone https://github.com/OmmniDevv/luxbid.git luxbid
cd luxbid
```

<br/>

### Step 2 — Install PHP Dependencies

```bash
composer install
```

<br/>

### Step 3 — Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan dengan kredensial database kamu:

```env
APP_NAME=LuxBid
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_lelang
DB_USERNAME=root
DB_PASSWORD=your_password_here

SESSION_DRIVER=file
```

<br/>

### Step 4 — Buat Database

Masuk ke MySQL dan buat database baru:

```sql
CREATE DATABASE db_lelang
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

Atau via command line:

```bash
mysql -u root -p -e "CREATE DATABASE db_lelang CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

<br/>

### Step 5 — Migrasi & Seed Database

```bash
php artisan migrate:fresh --seed
```

> Perintah ini akan membuat semua tabel dan mengisi data awal (level, admin, petugas).

<br/>

### Step 6 — Link Storage

```bash
php artisan storage:link
```

<br/>

### Step 7 — Install & Build Frontend Assets

```bash
npm install
npm run dev
```

> Untuk production gunakan `npm run build`

<br/>

### Step 8 — Jalankan Server

```bash
php artisan serve
```

Buka browser dan akses: **http://localhost:8000** 🎉

<br/>

### Step 9 — Setup Scheduler (Production)

> ⚠️ **Penting untuk Production:** Scheduler diperlukan untuk auto-delete barang kadaluarsa (7 hari setelah lelang selesai).

#### Linux / macOS

Tambahkan ke crontab:
```bash
crontab -e
```

Tambahkan baris:
```bash
* * * * * cd /path/to/luxbid && php artisan schedule:run >> /dev/null 2>&1
```

#### Windows (Laragon / XAMPP)

**Otomatis (Recommended):**

Jalankan command berikut di PowerShell (sebagai Administrator):
```powershell
cd C:\path\to\luxbid
schtasks /create /tn "LuxBid Scheduler" /tr "C:\path\to\luxbid\scheduler.bat" /sc minute /f
```

> File `scheduler.bat` sudah tersedia di root proyek.

**Manual via GUI:**

1. Buka **Task Scheduler** (tekan `Win + R`, ketik `taskschd.msc`)
2. Klik **Create Basic Task**
3. Name: `LuxBid Scheduler`
4. Trigger: **Daily**, repeat every **1 minute**
5. Action: **Start a program**
6. Program: `C:\path\to\luxbid\scheduler.bat`
7. Finish

**Verifikasi:**
```bash
# Cek task scheduler
schtasks /query /tn "LuxBid Scheduler"

# Test manual
php artisan lelang:hapus-barang-kadaluarsa

# Lihat daftar scheduled tasks
php artisan schedule:list
```

**Untuk Development:**

Cukup jalankan:
```bash
php artisan schedule:work
```

<br/>

---

## 🔑 Akun Default

| Role | Username | Password | Akses |
|------|----------|----------|-------|
| **Administrator** | `admin` | `admin` | Full access — kelola barang, petugas, laporan |
| **Petugas** | `petugas` | `petugas` | Aktivasi lelang, monitoring, laporan |

> ⚠️ **Penting:** Segera ganti password default setelah pertama kali login!

<br/>

---

## 🔧 Migrasi dari Native PHP (Opsional)

Jika kamu memiliki data dari versi PHP native sebelumnya:

**Copy data upload barang:**
```bash
cp -r /path/to/original/uploads public/uploads
```

**Import data lama** (jika ada backup SQL):
```bash
mysql -u root -p db_lelang < backup_lama.sql
```

<br/>

---

## ❌ Troubleshooting

<br/>

### `sessions table not found`

```bash
php artisan session:table
php artisan migrate
```

Atau cukup set di `.env`:
```env
SESSION_DRIVER=file
```

<br/>

### `storage not linked` / gambar tidak muncul

```bash
php artisan storage:link
```

<br/>

### `.env` tidak terkonfigurasi

```bash
cp .env.example .env
php artisan config:clear
php artisan key:generate
```

<br/>

### Permission error pada `storage` / `cache` (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

Untuk Arch Linux:
```bash
chmod -R 775 storage bootstrap/cache
chown -R $USER:http storage bootstrap/cache
```

<br/>

### `Access denied for user` (MySQL)

Pastikan user MySQL memiliki hak akses penuh ke database:

```sql
GRANT ALL PRIVILEGES ON db_lelang.* TO 'your_user'@'localhost';
FLUSH PRIVILEGES;
```

<br/>

### `npm run dev` error / Tailwind tidak terkompilasi

```bash
npm cache clean --force
rm -rf node_modules
npm install
npm run dev
```

<br/>

### `php artisan migrate` error — koneksi ditolak

Pastikan service MySQL sudah berjalan:

```bash
# Arch Linux
sudo systemctl start mysql
sudo systemctl enable mysql

# Ubuntu / Debian
sudo service mysql start
```

<br/>

---

<div align="center">

<br/>

Butuh bantuan? Buka issue di **[GitHub Repository](https://github.com/OmmniDevv/luxbid)**

<br/>

<sub>© 2026 LuxBid · TEAM HUNTERS · All Rights Reserved</sub>

</div>