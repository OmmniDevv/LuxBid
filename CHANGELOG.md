# Changelog

> Semua perubahan penting pada project **LuxBid** didokumentasikan di sini.  
> Format mengikuti [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

---

## [1.1.0] — 2026-05-01

### ✨ Ditambahkan

| Fitur | Keterangan |
|-------|------------|
| **Halaman Profil** | `/masyarakat/profile` — upload foto profil (auto-submit), edit nama/username/email/telepon dengan konfirmasi password, ganti password dengan validasi password lama |
| **Dark / Light Mode** | Tombol toggle sun/moon di semua navbar, state persisten via `localStorage`, tanpa flash saat navigasi antar halaman |
| **Countdown Timer** | Timer 6 menit per lelang aktif, otomatis reset saat ada bid baru, auto-close lelang via endpoint `/check-timer` |
| **Daftar Peserta** | List semua penawar di detail modal, diurutkan dari penawaran tertinggi |
| **Branding** | Nama diganti menjadi "Lux Bid" (two-tone), logo dari `assets/images/logo.png`, footer "Made by TEAM HUNTERS" |
| **LICENSE** | MIT License 2026 — TEAM HUNTERS |
| **`.gitignore`** | Standard Laravel gitignore |

### 🐛 Diperbaiki

| Bug | Solusi |
|-----|--------|
| Dark mode tidak aktif di halaman auth | `modern.css` belum di-load — sekarang sudah ditambahkan ke semua halaman auth |
| Eye toggle & ikon gembok tidak center vertikal di profile | Gunakan `.profile-pw-wrap` dengan `position:relative`, kedua ikon pakai `position:absolute; top:50%; transform:translateY(-50%)` |
| Username tampil literal `{{ $user->username }}` | Diperbaiki dengan escape syntax yang benar |
| HTML tags muncul di `<title>` | `Lux<span>Bid</span>` diperbaiki menjadi plain text `Lux Bid` |
| XSS/escaping bug di aktivasi dan isi view | `{{ }}` diganti `{!! !!}` untuk output HTML span |
| Bidding masih bisa setelah lelang berakhir | Backend guard di `simpanPenawaran` + frontend disable tombol saat timer = 0 |
| `petugas/aktivasi` 500 error | `$lelang_aktif` tidak diteruskan ke partial `isi.blade.php` — sudah diperbaiki |
| Sessions table missing | `SESSION_DRIVER` diubah dari `database` ke `file` |

---

## [1.0.0] — 2026-04-30

### ✨ Fitur Baru

| Fitur | Keterangan |
|-------|------------|
| **Countdown Timer Lelang** | Setiap lelang aktif memiliki timer 6 menit, reset otomatis saat ada bid baru, ditampilkan di card lelang, detail modal, dan form penawaran |
| **Auto-Close Lelang** | Saat timer habis, penawar tertinggi otomatis ditetapkan sebagai pemenang via endpoint `/check-timer` (di-poll client setiap 10 detik) |
| **Daftar Penawar** | Detail modal menampilkan semua penawar diurutkan dari bid tertinggi, dengan badge peringkat dan highlight pemenang |
| **Minimum Bid Enforcement** | Minimum bid diset ke `penawaran_tertinggi + 1` untuk mencegah penawaran dengan nilai yang sama |

### 🔄 Perubahan (Konversi ke Laravel)

- Dikonversi dari native PHP (file-based routing) ke **Laravel 13** arsitektur MVC
- `koneksi.php` digantikan dengan Laravel Eloquent ORM dan Query Builder
- Navigasi antar file digantikan dengan named routes di `routes/web.php`
- `$_SESSION` PHP digantikan dengan Laravel `session()` helper (file driver)
- Pattern `include '../layouts/header.php'` digantikan dengan Blade `@extends` / `@yield`
- Raw `mysqli_query()` digantikan dengan Eloquent models dan relationships
- File upload tetap di `public/uploads/barang/` (path sama dengan versi asli)
- Auth dibagi menjadi dua sistem independen: middleware `masyarakat.auth` dan `petugas.auth`

### 🐛 Bug Fix

| Bug | Solusi |
|-----|--------|
| Modal edit penawaran merusak layout tabel | Modal dirender di dalam baris tabel sehingga tombol submit tersembunyi — semua modal dipindahkan ke luar loop tabel |
| Barang baru otomatis membuat lelang | Penambahan barang tidak lagi otomatis membuat sesi lelang — keduanya sepenuhnya terpisah |
| Sessions table missing | `SESSION_DRIVER` diubah dari `database` ke `file` |
| `petugas/aktivasi` 500 error | Variabel `$lelang_aktif` tidak terdefinisi di partial `@include('petugas.isi')` — diperbaiki dengan meneruskannya dari controller |
| Link hapus petugas error | URL string concatenation yang salah — diganti dengan `<form method="post">` dan CSRF token |
| Masyarakat bisa akses manajemen lelang | Semua route buka/tutup/buat lelang kini dilindungi middleware `petugas.auth` |

### 🏗️ Keputusan Struktural

- Struktur database dipertahankan persis sama: `tb_masyarakat` dan `tb_petugas` tetap tabel terpisah, `tb_level` hanya berisi `administrator` dan `petugas`
- Dua auth guard sepenuhnya terpisah: `masyarakat` (session key `status=login`) dan `petugas` (session key `id_level`)
- Kolom `timer_end` (DATETIME, nullable) ditambahkan ke `tb_lelang` untuk fitur countdown
- Asset (`assets/`, `uploads/`) disalin langsung ke `public/` untuk mempertahankan semua path CSS/JS/gambar asli
- Admin dan Petugas berbagi views/controllers yang sama, dibedakan via `session('id_level') == 1`

---

<div align="center">
<sub>© 2026 LuxBid · TEAM HUNTERS · All Rights Reserved</sub>
</div>
