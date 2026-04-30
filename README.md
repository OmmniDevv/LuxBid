<div align="center">

<br/>

```
██╗     ██╗   ██╗██╗  ██╗██████╗ ██╗██████╗
██║     ██║   ██║╚██╗██╔╝██╔══██╗██║██╔══██╗
██║     ██║   ██║ ╚███╔╝ ██████╔╝██║██║  ██║
██║     ██║   ██║ ██╔██╗ ██╔══██╗██║██║  ██║
███████╗╚██████╔╝██╔╝ ██╗██████╔╝██║██████╔╝
╚══════╝ ╚═════╝ ╚═╝  ╚═╝╚═════╝ ╚═╝╚═════╝
```

### ✦ Platform Pelelangan Daring yang Elegan & Modern ✦

<br/>

[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-B8860B?style=for-the-badge)](LICENSE)

<br/>

> **LuxBid** adalah platform pelelangan online berbasis web yang dibangun di atas Laravel 13,  

<br/>

**Dibuat oleh [TEAM HUNTERS](https://github.com/OmmniDevv) · XI PPLG 2 · SMKN 7 BALEENDAH**

<br/>

---

</div>

<br/>

## ✦ Daftar Isi

- [Tech Stack](#-tech-stack)
- [Fitur Utama](#-fitur-utama)
- [Struktur Proyek](#-struktur-proyek)
- [Instalasi](#-instalasi)
- [Konfigurasi Database](#-konfigurasi-database)
- [Akun Default](#-akun-default)
- [Changelog](#-changelog)
- [Credits](#-credits)

<br/>

---

## ⚡ Tech Stack

| Kategori | Teknologi |
|----------|-----------|
| **Backend** | Laravel 13, PHP 8.x |
| **Database** | MySQL / MariaDB |
| **Frontend** | Bootstrap, Custom Design System |
| **Fonts** | Playfair Display, DM Sans (Google Fonts) |
| **Build Tool** | Vite |
| **Auth** | Session-based (Custom Middleware) |

<br/>

---

## Fitur Utama

<br/>

### Masyarakat (Peserta Lelang)

| Fitur | Keterangan |
|-------|------------|
| 🔐 Autentikasi | Registrasi, login, logout, lupa password via nomor telepon |
| 🏷️ Lelang Aktif | Lihat semua lelang aktif beserta foto barang |
| 🔨 Penawaran | Ajukan, edit, dan hapus penawaran harga |
| ⏱️ Countdown Timer | Timer 6 menit per lelang, reset otomatis saat ada bid baru |
| 👀 Monitoring | Lihat daftar peserta & penawaran tertinggi per lelang secara real-time |
| 📋 Riwayat | Riwayat penawaran lengkap beserta status menang/kalah |
| 👤 Profil | Edit profil dan ganti password |

<br/>

### Petugas & Administrator

| Fitur | Keterangan |
|-------|------------|
| 🔑 Panel Khusus | Login terpisah dari masyarakat |
| 📦 Manajemen Barang | CRUD barang lelang dengan upload hingga 3 foto |
| ⚡ Sesi Lelang | Buat, buka, dan tutup lelang secara manual |
| 📡 Monitoring Real-Time | Auto-refresh penawaran setiap 3 detik |
| 👨‍💼 Manajemen Petugas | Kelola akun petugas (admin only) |
| 📊 Laporan | Laporan hasil lelang lengkap + cetak PDF |

<br/>

---

## Struktur Proyek

```
luxbid/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── MasyarakatAuthController.php
│   │   │   │   └── PetugasAuthController.php
│   │   │   ├── HomeController.php
│   │   │   ├── MasyarakatController.php
│   │   │   ├── PetugasController.php
│   │   │   └── AdministratorController.php
│   │   └── Middleware/
│   │       ├── MasyarakatAuth.php
│   │       └── PetugasAuth.php
│   └── Models/
│       ├── Masyarakat.php
│       ├── Petugas.php
│       ├── Level.php
│       ├── Barang.php
│       ├── GambarBarang.php
│       ├── Lelang.php
│       └── HistoryLelang.php
├── resources/
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── masyarakat/
│       ├── petugas/
│       └── administrator/
├── public/
│   ├── assets/
│   └── uploads/barang/
└── database/
    ├── migrations/
    └── seeders/
```

<br/>

---

## Instalasi

**1. Clone repository**
```bash
git clone https://github.com/OmmniDevv/luxbid.git
cd luxbid
```

**2. Install dependencies**
```bash
composer install
npm install
```

**3. Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Konfigurasi database di `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_lelang
DB_USERNAME=root
DB_PASSWORD=your_password
```

**5. Migrate & seed database**
```bash
php artisan migrate
php artisan db:seed
```

**6. Build assets & jalankan server**
```bash
npm run dev
php artisan serve
```

Buka browser dan akses: **http://localhost:8000**

<br/>

---

## Konfigurasi Database

Struktur tabel yang digunakan:

```
tb_level          → Level akses (Admin / Petugas)
tb_petugas        → Akun admin dan petugas
tb_masyarakat     → Akun peserta lelang
tb_barang         → Data barang yang dilelang
tb_lelang         → Sesi lelang
history_lelang    → Riwayat penawaran
```

<br/>

---

## Akun Default

Setelah menjalankan seeder, akun berikut tersedia:

| Role | Username | Password |
|------|----------|----------|
| **Admin** | `admin` | `admin123` |
| **Petugas** | `petugas` | `petugas123` |

> ⚠️ Segera ganti password setelah pertama kali login di production.

<br/>

---

## Changelog

<br/>

### [1.1.0] — 2026-05-01

**Ditambahkan**

| Fitur | Keterangan |
|-------|------------|
| **Halaman Profil** | `/masyarakat/profile` — upload foto profil, edit data diri, ganti password |
| **Dark / Light Mode** | Toggle sun/moon di semua navbar, persisten via `localStorage` tanpa flash |
| **Countdown Timer** | Timer 6 menit per lelang, reset saat ada bid baru, auto-close via `/check-timer` |
| **Daftar Peserta** | List penawar di detail modal, diurutkan dari penawaran tertinggi |
| **Branding** | Nama "Lux Bid" two-tone, logo baru, footer "Made by TEAM HUNTERS" |

**Diperbaiki**

| Bug | Solusi |
|-----|--------|
| Dark mode tidak aktif di halaman auth | `modern.css` ditambahkan ke semua halaman auth |
| Ikon gembok & eye toggle tidak center di profile | `position:absolute; top:50%; transform:translateY(-50%)` |
| `petugas/aktivasi` 500 error | `$lelang_aktif` diteruskan ke partial `isi.blade.php` |
| Bidding masih bisa setelah lelang berakhir | Backend guard + frontend disable tombol saat timer = 0 |

<br/>

### [1.0.0] — 2026-04-30

**Fitur Baru**

| Fitur | Keterangan |
|-------|------------|
| **Countdown Timer Lelang** | Timer 6 menit per lelang, reset saat bid baru, tampil di card & modal |
| **Auto-Close Lelang** | Pemenang otomatis ditetapkan saat timer habis via `/check-timer` |
| **Daftar Penawar** | Detail modal tampilkan semua penawar + badge peringkat + highlight pemenang |
| **Minimum Bid** | Minimum bid = `penawaran_tertinggi + 1` untuk cegah bid sama |

**🔄 Konversi ke Laravel**

- Native PHP → Laravel 13 MVC, `koneksi.php` → Eloquent ORM
- `$_SESSION` → Laravel `session()`, file-based routing → named routes
- `include layouts` → Blade `@extends/@yield`, raw `mysqli_query` → Eloquent models
- Auth dibagi dua: middleware `masyarakat.auth` dan `petugas.auth`

**Bug Fix**

| Bug | Solusi |
|-----|--------|
| Modal edit penawaran merusak layout tabel | Semua modal dipindahkan ke luar loop tabel |
| Barang baru otomatis membuat lelang | Pembuatan barang & lelang dipisah sepenuhnya |
| Sessions table missing | `SESSION_DRIVER` diubah ke `file` |
| Link hapus petugas error | Diganti `<form method="post">` + CSRF token |

> Lihat detail lengkap di [CHANGELOG.md](CHANGELOG.md)

<br/>

---

## Credits

<div align="center">

<br/>

**Dibangun dengan ❤️ oleh Team Hunters**

### TEAM HUNTERS

| | |
|--|--|
| **GitHub** | [@OmmniDevv](https://github.com/OmmniDevv) |
| **Kelas** | XI PPLG 2 |
| **Project** | Laravel 13 |

<br/>

---

<sub>© 2026 LuxBid · TEAM HUNTERS · All Rights Reserved</sub>

</div>