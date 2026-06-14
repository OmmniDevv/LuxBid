# Changelog

> Semua perubahan penting pada project **LuxBid** didokumentasikan di sini.  
> Format mengikuti [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

---

## [Unreleased]

### ✨ Ditambahkan

| Fitur | Keterangan |
|-------|------------|
| **Sistem Konfirmasi Kemenangan** | Pemenang lelang wajib konfirmasi dalam 24 jam via email link atau halaman konfirmasi. Status tracking: `menunggu_konfirmasi`, `dikonfirmasi`, `dibatalkan`, `selesai`. Scheduled job otomatis mengirim reminder H-1 dan memproses timeout |
| **Auto-Reassignment Pemenang** | Jika pemenang tidak konfirmasi dalam 24 jam, sistem otomatis assign ke bidder tertinggi berikutnya. Proses berulang hingga ada yang konfirmasi atau tidak ada bidder tersisa |
| **Wishlist System** | User dapat menyimpan barang favorit ke wishlist. Toggle wishlist via AJAX, badge counter real-time, halaman dedicated `/masyarakat/wishlist` |
| **Rating & Review System** | Pemenang dapat memberikan rating 1-5 bintang dan komentar setelah konfirmasi kemenangan. Rating ditampilkan di detail barang dengan rata-rata dan jumlah review |
| **Bukti Pembayaran** | Upload bukti transfer (JPG/PNG max 5MB) setelah konfirmasi menang. Admin dapat verifikasi (terima/tolak) dengan catatan. Email notifikasi otomatis ke user |
| **Riwayat Penawaran User** | Halaman `/masyarakat/riwayat` menampilkan semua lelang yang pernah diikuti dengan status menang/kalah. Detail page menampilkan timeline lengkap semua bid user |
| **Enhanced Admin Dashboard** | Statistik baru: jumlah menunggu konfirmasi, jumlah bukti bayar pending verifikasi, total pendapatan. Quick action cards ke halaman penting |
| **Export Laporan Excel** | Export laporan lelang ke format `.xlsx` via `maatwebsite/excel`. Support filter by status konfirmasi. Kolom lengkap: barang, tanggal, harga, pemenang, invoice, bukti bayar |
| **Activity Log Viewer** | Audit trail aktivitas admin/petugas: tambah/update/hapus barang, buka/tutup lelang, verifikasi bukti bayar. Filter by action type & date range. Pagination 50 per page |
| **Enhanced Search & Filter** | Filter laporan by status konfirmasi dengan dropdown. Export button respect filter yang aktif. UI streamlined dengan reset button |
| **Kategori Barang** | Model `Kategori`, migration `tb_kategori`, `KategoriSeeder`, dan kolom `id_kategori` di `tb_barang` — sistem kategorisasi barang lelang |
| **Email Notifikasi Lengkap** | Mailable baru: `WelcomeMail`, `OutbidMail`, `AuctionOpenedMail`, `AuctionClosedMail`, `AuctionWonMail`, `ResetCodeMail`, `LelangPemenangMail`, `ReminderKonfirmasiMail`, `BatalKonfirmasiMail`, `PemenangBaruMail`, `BuktiPembayaranStatusMail`. Semua queued untuk background processing |
| **Alur Lupa Password (Email)** | Halaman `lupa_verifikasi.blade.php` dan `lupa_selesai.blade.php` — reset password via kode verifikasi yang dikirim ke email |
| **Laravel Cloud Config** | File `LARAVEL_CLOUD.md` — panduan lengkap deployment ke Laravel Cloud dengan konfigurasi optimal |

### 🔄 Perubahan

| Komponen | Keterangan |
|----------|------------|
| **Model Lelang** | Kolom baru: `nomor_faktur`, `status_konfirmasi`, `tanggal_konfirmasi`, `batas_konfirmasi`, `catatan_admin`, `bukti_pembayaran`, `tanggal_bayar`. Relasi baru: `pemenang`, `ratings` |
| **Model Masyarakat** | Relasi baru: `wishlist`, `ratings`, `riwayatPemenang` |
| **Model Barang** | Relasi baru: `wishlist`, `ratings` via `hasManyThrough` |
| **Admin Navigation** | Link baru: Activity Log (administrator only) |
| **Laporan Page** | Export Excel button, enhanced filtering UI |

### 🧪 Testing

| Coverage | Keterangan |
|----------|------------|
| **53 Tests, 159 Assertions** | Full test suite untuk semua fitur baru: konfirmasi kemenangan, wishlist, rating, bukti pembayaran, riwayat. 100% passing |
| **Feature Tests** | `LelangKonfirmasiTest`, `LelangTimeoutTest`, `WishlistTest`, `RatingFeatureTest`, `BuktiPembayaranTest` dengan session auth helpers |
| **Factory Support** | `KategoriFactory` untuk test data generation |

---

## [1.6.0] — 2026-06-04

### 🎨 UI Overhaul

| Komponen | Keterangan |
|----------|------------|
| **`luxbid.css`** | File CSS baru (`public/assets/luxbid.css`, ~1390 baris) — design system terpusat untuk seluruh aplikasi |
| **Landing Page (`home.blade.php`)** | Redesign besar-besaran: layout, warna, tipografi, dan komponen diperbarui secara menyeluruh |
| **Layout Petugas (`layouts/petugas.blade.php`)** | Refactor besar sidebar dan struktur layout panel petugas/admin |
| **Halaman Auth** | `login.blade.php`, `login_masyarakat.blade.php`, `daftar_masyarakat.blade.php`, `lupa_password.blade.php` — UI diperbarui sepenuhnya |
| **Dashboard Masyarakat** | `masyarakat/index.blade.php` — tampilan diperbarui |
| **Dashboard Admin/Petugas** | `administrator/index.blade.php`, `petugas/index.blade.php` — tampilan diperbarui |
| **Halaman Statis** | `bantuan.blade.php`, `kebijakan.blade.php`, `kontak.blade.php` — UI diperbarui konsisten dengan tema baru |

---

## [1.5.1] — 2026-05-26

### 🐛 Diperbaiki

| Bug | Solusi |
|-----|--------|
| **Hapus barang gagal** | `PetugasController@hapusBarang` diperbaiki — penghapusan cascade (foto fisik + record terkait) ditangani dengan benar |

---

## [1.5.0] — 2026-05-12

### ✨ Ditambahkan

| Fitur | Keterangan |
|-------|------------|
| **INSTALLATION.md** | Panduan instalasi lengkap ditambahkan |
| **Build Assets** | `package-lock.json`, `public/build/manifest.json`, `public/build/assets/` — hasil build Vite disertakan |

### 🎨 Perubahan UI

| Halaman | Keterangan |
|---------|-----------|
| **Semua halaman** | Penyesuaian minor icon dan tampilan pasca-refactor v1.4.2 |
| **Halaman penawaran masyarakat** | Perbaikan tampilan dan interaksi |
| **Panel petugas/admin** | Perbaikan konsistensi tampilan barang, laporan, aktivasi |
| **petugas.blade.php** | Perbaikan teks/label pada halaman manajemen petugas |

### 🔄 Lainnya

| Komponen | Keterangan |
|----------|------------|
| **Logo** | File `public/assets/images/logo.png` diperbarui |
| **README.md** | Diperbarui dengan informasi tambahan |
| **`scheduler.bat`** | File batch scheduler untuk Windows ditambahkan |
| **`HapusBarangKadaluarsa` command** | Penyesuaian minor pada command scheduler |

---

## [1.4.2] — 2026-05-12

### 🎨 Refactor UI

| Aspek | Perubahan |
|-------|-----------|
| **Emoji Unicode → Bootstrap Icons** | Semua emoji unicode di UI diganti dengan Bootstrap Icons untuk tampilan yang lebih konsisten dan profesional |
| **Bootstrap Icons CDN** | Ditambahkan ke semua layout (masyarakat, petugas, home, auth, static pages) |

### 📝 Detail Perubahan Icon

| Halaman | Emoji Lama | Icon Baru |
|---------|------------|-----------|
| **Home (Landing Page)** | 📝🔍💰🏆🔒⚡📊📱👤 | bi-pencil-square, bi-search, bi-cash-coin, bi-trophy, bi-shield-lock, bi-lightning-charge, bi-bar-chart, bi-phone, bi-person |
| **Auth (Login/Register)** | 👤🛡️🔑🎉📝 | bi-person-circle, bi-shield-shaded, bi-key, bi-check-circle, bi-pencil-square |
| **Masyarakat Dashboard** | 🏆📋✅🎯🔨📦🔍✏️🔒📷📊🏅⚡ | bi-trophy, bi-card-list, bi-check-circle, bi-bullseye, bi-hammer, bi-box-seam, bi-search, bi-pencil-square, bi-lock, bi-camera, bi-bar-chart-line, bi-award, bi-lightning-charge |
| **Petugas/Admin Panel** | 📦⚡💰👥📊🗑️🏆🔓🔒✅⚠️📋📡 | bi-box-seam, bi-lightning-charge, bi-cash-coin, bi-people, bi-bar-chart, bi-trash, bi-trophy, bi-unlock, bi-lock, bi-check-circle, bi-exclamation-triangle, bi-card-list, bi-broadcast |
| **Halaman Kontak** | 💬📧🏢🕐 | bi-chat-dots, bi-envelope-at, bi-building, bi-clock |

### ✨ Peningkatan

| Fitur | Keterangan |
|-------|------------|
| **Konsistensi Visual** | Semua icon menggunakan Bootstrap Icons dengan style yang seragam |
| **Performa** | Icon vector lebih ringan dan scalable dibanding emoji unicode |
| **Aksesibilitas** | Icon lebih mudah dibaca di berbagai device dan browser |

---

## [1.4.1] — 2026-05-12

### 🐛 Diperbaiki

| Bug | Solusi |
|-----|--------|
| **Scheduler command error (foreign key)** | Command `lelang:hapus-barang-kadaluarsa` gagal karena foreign key constraint. Diperbaiki dengan menghapus data dalam urutan: `history_lelang` → `tb_lelang` → `gambar_barang` → `tb_barang` |

### 📚 Dokumentasi

| File | Perubahan |
|------|-----------|
| **README.md** | Tambah section "Setup Scheduler (Production)" dengan instruksi lengkap untuk Linux/macOS dan Windows (Laragon/XAMPP). Tambah catatan Windows di prasyarat tentang PHP 8.3+ requirement. Tambah `scheduler.bat` di struktur proyek |
| **INSTALLATION.md** | Tambah Step 9 — Setup Scheduler dengan instruksi detail Windows Task Scheduler (otomatis & manual via GUI). Tambah catatan Windows di requirements tentang PHP version compatibility. Tambah command verifikasi scheduler |
| **scheduler.bat** | File batch baru untuk Windows Task Scheduler — menjalankan `php artisan schedule:run` setiap menit |

### ⚙️ Infrastruktur

| Komponen | Keterangan |
|----------|------------|
| **Windows Task Scheduler** | Setup otomatis via `schtasks` command untuk menjalankan Laravel scheduler setiap menit di Windows environment |

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
