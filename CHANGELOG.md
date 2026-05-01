# Changelog

> Semua perubahan penting pada project **LuxBid** didokumentasikan di sini.  
> Format mengikuti [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

---

## [1.4.0] — 2026-05-02

### ✨ Ditambahkan

| Fitur | Keterangan |
|-------|------------|
| **Hamburger Menu Mobile** | Tombol hamburger fungsional di navbar landing page — menu overlay fullscreen dengan semua link navigasi, ikon berubah jadi ✕ saat terbuka, otomatis tutup saat link diklik |
| **Field Email di Registrasi** | Form pendaftaran masyarakat kini menyertakan field email (opsional), konsisten dengan halaman profil |

### 🐛 Diperbaiki

| Bug | Solusi |
|-----|--------|
| Hamburger menu menimpa konten (z-index) | Menu mobile dipindah ke luar elemen `<nav>` agar tidak terbatas stacking context navbar |
| Dark mode tidak berlaku di mobile menu | Tambah `[data-theme="dark"]` override untuk `#ln-links` dan `mn-links.open` di `modern.css` |
| Dark mode tidak berlaku di halaman auth & static | Tambah dark mode override di akhir `modern.css` untuk `body`, `card-auth`, `split-left`, halaman kontak/bantuan/kebijakan |
| Foto profil tidak center di mobile | Tambah `flex-direction:column; align-items:center` di `@media(max-width:600px)` untuk `.profile-foto-section` |
| Tombol dm-toggle terpotong di navbar mobile | Sembunyikan teks logout (sisakan ikon), kecilkan avatar dan brand badge di `≤600px` |
| Modal Tambah/Edit Barang terpotong | Tambah class `modal-tall` dengan `align-items:flex-start` dan `overflow-y:auto` |
| Link "Masuk sebagai Admin" di halaman login peserta | Dihapus — akses admin tersedia via tombol "Login Staff" di navbar halaman utama |
| Hamburger menu panel tidak estetik | `mn-links.open` diubah dari fullscreen ke dropdown `height:auto`, padding dikurangi, font diperkecil, item aktif punya border-left gold |

### 🎨 Perubahan UI & Responsivitas

| Aspek | Keterangan |
|-------|------------|
| **Viewport no-zoom** | Semua 14 halaman diupdate dengan `maximum-scale=1, user-scalable=no` |
| **Font mobile landing page** | `.h1` dikecilkan ke `clamp(1.8rem,8vw,2.8rem)`, `.ttl`, `.hsub`, `.stat-n`, `.step-n` disesuaikan di `≤768px` |
| **Font mobile panel** | `.page-title`, `.stat-card-n`, `.btn-m`, `.card-m-title` dikecilkan di `≤600px` |
| **Layout mobile panel** | `page-header` column, `stat-grid` 2 kolom, tabel font lebih kecil, modal full-width |
| **Login Peserta** | Link "Lupa Password?" dipindah ke tepat di bawah field password (inline) |

---

## [1.3.0] — 2026-05-02

### ✨ Ditambahkan

| Fitur | Keterangan |
|-------|------------|
| **Field Nama Penjual** | Kolom `nama_penjual` (nullable) ditambahkan ke tabel `tb_barang` via migration. Data lama tidak terpengaruh (nilai default NULL) |
| **Form Pendataan Barang** | Field "Nama Penjual" ditambahkan di form tambah dan edit barang pada panel petugas dan administrator |
| **Tabel Daftar Barang** | Kolom "Penjual" ditampilkan di tabel daftar barang pada panel petugas dan administrator |
| **Detail Modal Penawaran** | Nama penjual ditampilkan di detail modal lelang pada halaman penawaran masyarakat (hanya jika terisi) |
| **Laporan Hasil Lelang** | Kolom "Penjual" ditambahkan di tabel laporan pada panel petugas dan administrator, termasuk versi cetak dan PDF |
| **Faktur PDF Pemenang** | Informasi penjual/pemilik barang ditampilkan di bagian detail barang pada faktur PDF |
| **Field Email di Registrasi** | Form pendaftaran masyarakat kini menyertakan field email (opsional), konsisten dengan halaman profil |

### 🐛 Diperbaiki

| Bug | Solusi |
|-----|--------|
| Modal Tambah/Edit Barang terpotong | Tambah class `modal-tall` dengan `align-items:flex-start` dan `overflow-y:auto` pada body modal |
| Link "Masuk sebagai Admin" di halaman login peserta | Dihapus — akses admin tersedia via tombol "Login Staff" di navbar halaman utama |

### 🎨 Perubahan UI

| Halaman | Perubahan |
|---------|-----------|
| Login Peserta | Link "Lupa Password?" dipindah ke tepat di bawah field password (inline), link "Masuk sebagai Admin" dihapus |

---

## [1.2.0] — 2026-05-01

### ✨ Ditambahkan

| Fitur | Keterangan |
|-------|------------|
| **Fitur Lupa Password** | Reset password via verifikasi `username + nomor_telepon`. Password baru digenerate otomatis (12 karakter, kombinasi huruf besar/kecil/angka/simbol), ditampilkan sekali dengan tombol salin |
| **Halaman Statis** | Tiga halaman baru: `/kontak` (info kontak + tombol WhatsApp), `/bantuan` (panduan 6 langkah + 7 FAQ accordion), `/kebijakan-privasi` (10 seksi lengkap) — desain konsisten dengan tema LuxBid |
| **Laporan PDF (dompdf)** | Tombol **Generate**, **Print**, dan **Download PDF** di halaman laporan petugas & admin. PDF digenerate server-side via `barryvdh/laravel-dompdf`, nama file format `laporan_[username]_[tanggal]_[jam].pdf` |
| **Faktur PDF Pemenang** | Pemenang lelang dapat mengunduh faktur resmi dari halaman riwayat penawaran. Faktur berisi nomor unik `LXB-XXXXXXXX`, detail barang, harga akhir, instruksi pembayaran, dan kontak admin. Hanya bisa diakses oleh pemenang yang bersangkutan (guard 403) |
| **Minimum Bid Rp 1.000** | Penawaran baru wajib minimal Rp 1.000 lebih tinggi dari penawaran tertinggi saat ini. Divalidasi di backend (`simpanPenawaran` & `updatePenawaran`) dan frontend (atribut `min` + hint teks) |
| **Penghapusan Barang Otomatis** | Laravel Scheduler menjalankan `lelang:hapus-barang-kadaluarsa` setiap hari pukul 01.00 WIB. Barang beserta foto fisiknya dihapus 7 hari setelah lelang ditutup dan ada pemenang. Data lelang tetap dipertahankan untuk laporan |
| **Timezone Asia/Jakarta** | `config/app.php` diubah dari `UTC` ke `Asia/Jakarta`. Semua tampilan tanggal/waktu (termasuk laporan PDF) menggunakan WIB |
| **Link Staff Login** | Tombol "Login Staff" subtle di navbar halaman utama (hanya tampil saat belum login), mengarah ke `/login-admin` |
| **Section CTA Melelang** | Section besar bertema gelap sebelum footer di halaman utama: alur 4 langkah cara melelang barang + 6 keuntungan bergabung + tombol konsultasi ke `/kontak` |

### 🐛 Diperbaiki

| Bug | Solusi |
|-----|--------|
| Download PDF laporan membuka halaman preview | Pisahkan view dompdf (`laporan_pdf_doc.blade.php`) dari view preview browser (`laporan_pdf.blade.php`) |
| Toolbar "Tutup/Print" ikut masuk ke dalam PDF | View dompdf tidak menerima variabel `$mode`, toolbar selalu dirender — diperbaiki dengan view terpisah tanpa toolbar |
| `iconv` extension tidak aktif | Baris `;extension=iconv` di `/etc/php/php.ini` diaktifkan agar `barryvdh/laravel-dompdf` dapat diinstall |

### 🔒 Keamanan

| Aspek | Keterangan |
|-------|------------|
| **Faktur hanya untuk pemenang** | Route `/masyarakat/faktur/{id_lelang}` memvalidasi `session('id_user') == lelang.id_user` dan `status == ditutup`, abort 403 jika tidak sesuai |
| **Null-safety barang terhapus** | Semua view yang menampilkan data barang (laporan, print, aktivasi, riwayat, dashboard) di-guard dengan `?? '[Data tidak tersedia]'` agar tidak error setelah barang dihapus otomatis |

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
