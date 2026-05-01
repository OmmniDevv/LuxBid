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
[![DomPDF](https://img.shields.io/badge/DomPDF-3.x-E74C3C?style=for-the-badge)](https://github.com/barryvdh/laravel-dompdf)
[![License](https://img.shields.io/badge/License-MIT-B8860B?style=for-the-badge)](LICENSE)

<br/>

> **LuxBid** adalah platform pelelangan online berbasis web yang dibangun di atas Laravel 13.
> Dirancang untuk pengalaman lelang yang transparan, real-time, dan elegan.

<br/>

**Dibuat oleh [TEAM HUNTERS](https://github.com/OmmniDevv) · XI PPLG 2 · SMKN 7 BALEENDAH**

<br/>

---

</div>

## ✦ Daftar Isi

- [Tech Stack](#-tech-stack)
- [Fitur Utama](#-fitur-utama)
- [Struktur Proyek](#-struktur-proyek)
- [Instalasi](#-instalasi)
- [Konfigurasi Database](#-konfigurasi-database)
- [Akun Default](#-akun-default)
- [Dokumentasi](#-dokumentasi)
- [Changelog](#-changelog)
- [Developer](#-developer)

<br/>

---

## ⚡ Tech Stack

| Kategori | Teknologi |
|----------|-----------|
| **Backend Framework** | Laravel 13 (PHP 8.x) |
| **Database** | MySQL 8.0 / MariaDB |
| **Frontend** | HTML5, CSS3 (Custom Design System), JavaScript Vanilla |
| **Fonts** | Playfair Display, Inter, DM Sans (Google Fonts) |
| **PDF Generation** | barryvdh/laravel-dompdf v3.x |
| **Build Tool** | Vite |
| **Auth** | Session-based (Custom Middleware, dua guard terpisah) |
| **Scheduler** | Laravel Scheduler + Cron |
| **Icons** | Font Awesome 5 |

<br/>

---

## Fitur Utama

### Masyarakat (Peserta Lelang)

| Fitur | Keterangan |
|-------|------------|
| 🔐 Autentikasi | Registrasi, login, logout, lupa password via username + nomor telepon |
| 🏷️ Lelang Aktif | Lihat semua lelang aktif beserta foto barang dan countdown timer |
| 🔨 Penawaran | Ajukan, edit, dan hapus penawaran — minimum kenaikan Rp 1.000 |
| ⏱️ Countdown Timer | Timer 6 menit per lelang, reset otomatis saat ada bid baru |
| 👀 Monitoring | Daftar peserta & penawaran tertinggi per lelang secara real-time |
| 📋 Riwayat | Riwayat penawaran lengkap beserta status menang/kalah |
| 🧾 Faktur PDF | Download faktur resmi PDF untuk lelang yang dimenangkan |
| 👤 Profil | Edit profil, ganti password, upload foto profil |

### Petugas & Administrator

| Fitur | Keterangan |
|-------|------------|
| 🔑 Panel Khusus | Login terpisah dari masyarakat via `/login-admin` |
| 📦 Manajemen Barang | CRUD barang lelang dengan upload hingga 3 foto per barang |
| ⚡ Sesi Lelang | Buat, buka, dan tutup lelang secara manual |
| 📡 Monitoring Real-Time | Auto-refresh penawaran setiap 3 detik |
| 👨‍💼 Manajemen Petugas | Kelola akun petugas (admin only) |
| 📊 Laporan PDF | Laporan hasil lelang lengkap — cetak & download PDF |
| 🗑️ Auto-Hapus Barang | Barang dihapus otomatis 7 hari setelah lelang selesai (scheduler) |

### Halaman Publik

| Halaman | URL |
|---------|-----|
| Kontak | `/kontak` |
| Bantuan & FAQ | `/bantuan` |
| Kebijakan Privasi | `/kebijakan-privasi` |

<br/>

---

## Struktur Proyek

```
luxbid/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── HapusBarangKadaluarsa.php   ← Scheduler harian
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Traits/
│   │   │   │   └── LelangTrait.php          ← Shared logic (enrich + upload)
│   │   │   ├── Auth/
│   │   │   │   ├── MasyarakatAuthController.php
│   │   │   │   └── PetugasAuthController.php
│   │   │   ├── HomeController.php
│   │   │   ├── MasyarakatController.php
│   │   │   ├── PetugasController.php
│   │   │   ├── AdministratorController.php
│   │   │   └── StaticPageController.php
│   │   └── Middleware/
│   │       ├── MasyarakatAuth.php
│   │       ├── PetugasAuth.php
│   │       └── AdminOnly.php
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
│       ├── auth/
│       ├── layouts/
│       ├── masyarakat/
│       ├── petugas/
│       ├── administrator/
│       ├── static/
│       └── shared/
│           ├── laporan_pdf.blade.php        ← Preview laporan browser
│           ├── laporan_pdf_doc.blade.php    ← Template dompdf laporan
│           └── faktur_pdf.blade.php         ← Template dompdf faktur
├── routes/
│   ├── web.php
│   └── console.php                          ← Scheduler registration
├── public/
│   ├── assets/
│   └── uploads/
│       ├── barang/                          ← Foto barang lelang
│       └── profile/                         ← Foto profil masyarakat
├── database/
│   ├── migrations/
│   └── seeders/
├── CHANGELOG.md
└── README.md
```

<br/>

---

## Instalasi

### Prasyarat

- PHP >= 8.1 dengan ekstensi: `mbstring`, `openssl`, `xml`, `zip`, `iconv`, `dom`
- Composer
- Node.js & npm
- MySQL 8.0 / MariaDB

### Langkah Instalasi

**1. Clone repository**
```bash
git clone https://github.com/OmmniDevv/luxbid.git
cd luxbid
```

**2. Install dependencies PHP**
```bash
composer install
```

**3. Install dependencies JavaScript**
```bash
npm install
```

**4. Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Konfigurasi `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_lelang
DB_USERNAME=root
DB_PASSWORD=your_password

SESSION_DRIVER=file
CACHE_STORE=file
APP_TIMEZONE=Asia/Jakarta
```

**6. Migrate & seed database**
```bash
php artisan migrate
php artisan db:seed
```

**7. Build assets**
```bash
npm run build
# atau untuk development:
npm run dev
```

**8. Jalankan server**
```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

### Setup Scheduler (Production)

Tambahkan baris berikut ke crontab server:
```bash
* * * * * cd /path/to/luxbid && php artisan schedule:run >> /dev/null 2>&1
```

Scheduler akan menjalankan penghapusan barang kadaluarsa setiap hari pukul **01.00 WIB**.

<br/>

---

## Konfigurasi Database

Struktur tabel yang digunakan:

```
tb_level          → Level akses (administrator / petugas)
tb_petugas        → Akun admin dan petugas
tb_masyarakat     → Akun peserta lelang
tb_barang         → Data barang yang dilelang
tb_gambar_barang  → Foto barang (maks 3 per barang)
tb_lelang         → Sesi lelang
history_lelang    → Riwayat penawaran
```

<br/>

---

## Akun Default

Setelah menjalankan seeder, akun berikut tersedia:

| Role | Username | Password |
|------|----------|----------|
| **Administrator** | `admin` | `admin123` |
| **Petugas** | `petugas` | `petugas123` |

> ⚠️ Segera ganti password setelah pertama kali login di production.

<br/>

---

## Dokumentasi

Dokumentasi lengkap proyek tersedia di repository terpisah:

**[📚 github.com/OmmniDevv/dokumentasi-LuxBid](https://github.com/OmmniDevv/dokumentasi-LuxBid)**

### 📄 Dokumen

| Dokumen | Deskripsi |
|---------|-----------|
| [📋 SRS LuxBid v1.2.0](https://github.com/OmmniDevv/dokumentasi-LuxBid/tree/main/dokumen) | Software Requirements Specification — kebutuhan fungsional & non-fungsional sistem |
| [🎤 Script Presentasi](https://github.com/OmmniDevv/dokumentasi-LuxBid/tree/main/dokumen) | Naskah presentasi lengkap proyek LuxBid |

### 🗂️ Diagram UML

| Diagram | Deskripsi |
|---------|-----------|
| [📌 Use Case Diagram](https://github.com/OmmniDevv/dokumentasi-LuxBid/tree/main/uml) | Interaksi aktor (Masyarakat, Petugas, Administrator) dengan sistem |
| [🗃️ Entity Relationship Diagram](https://github.com/OmmniDevv/dokumentasi-LuxBid/tree/main/uml) | Relasi antar entitas database |
| [🧩 Class Diagram](https://github.com/OmmniDevv/dokumentasi-LuxBid/tree/main/uml) | Struktur kelas dan hubungan antar model |
| [🔄 Activity Diagrams](https://github.com/OmmniDevv/dokumentasi-LuxBid/tree/main/uml) | Alur aktivitas proses bisnis utama |
| [⚡ Sequence Diagrams](https://github.com/OmmniDevv/dokumentasi-LuxBid/tree/main/uml) | Urutan interaksi antar komponen sistem |

<br/>

---

## Changelog

Lihat riwayat perubahan lengkap di **[CHANGELOG.md](CHANGELOG.md)**.

Versi terbaru: **[1.3.0] — 2026-05-01**

Perubahan utama di v1.3.0:
- Field nama penjual pada pendataan barang
- Nama penjual tampil di laporan, faktur PDF, dan detail lelang

Perubahan utama di v1.2.0:
- Faktur PDF untuk pemenang lelang
- Laporan PDF dengan dompdf
- Lupa password via username + nomor telepon
- Minimum bid Rp 1.000
- Penghapusan barang otomatis (scheduler)
- Halaman statis: Kontak, Bantuan, Kebijakan Privasi
- Timezone Asia/Jakarta

<br/>

---

## Developer

<div align="center">

<br/>

**Dibangun dengan ❤️ oleh TEAM HUNTERS**

<br/>

| | |
|:--:|:--|
| <img src="https://github.com/OmmniDevv.png" width="60" style="border-radius:50%"> | **OmmniDevv** · Lead Developer<br/>[![GitHub](https://img.shields.io/badge/GitHub-OmmniDevv-181717?style=flat&logo=github)](https://github.com/OmmniDevv) |

<br/>

| Info | Detail |
|------|--------|
| **Tim** | TEAM HUNTERS |
| **Kelas** | XI PPLG 2 |
| **Sekolah** | SMKN 7 Baleendah, Kab. Bandung |
| **Tahun** | 2026 |
| **GitHub** | [github.com/OmmniDevv](https://github.com/OmmniDevv) |

<br/>

---

<sub>© 2026 LuxBid · TEAM HUNTERS · MIT License · All Rights Reserved</sub>

</div>
