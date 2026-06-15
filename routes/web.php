<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\Auth\MasyarakatAuthController;
use App\Http\Controllers\Auth\PetugasAuthController;

// ── Public ───────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kontak',           [StaticPageController::class, 'kontak'])->name('kontak');
Route::get('/bantuan',          [StaticPageController::class, 'bantuan'])->name('bantuan');
Route::get('/kebijakan-privasi',[StaticPageController::class, 'kebijakan'])->name('kebijakan');
Route::get('/check-timer', [PetugasController::class, 'checkTimer'])->name('petugas.checkTimer');

// Masyarakat Auth
Route::get('/login',  [MasyarakatAuthController::class, 'showLogin'])->name('login.masyarakat');
Route::post('/login', [MasyarakatAuthController::class, 'login'])->name('login.masyarakat.post')->middleware('throttle:5,1');
Route::get('/daftar',  [MasyarakatAuthController::class, 'showRegister'])->name('daftar.masyarakat');
Route::post('/daftar', [MasyarakatAuthController::class, 'register'])->name('daftar.masyarakat.post')->middleware('throttle:3,1');
Route::get('/daftar/verifikasi',         [MasyarakatAuthController::class, 'showVerifikasiDaftar'])->name('daftar.verifikasi');
Route::post('/daftar/verifikasi',        [MasyarakatAuthController::class, 'prosesVerifikasiDaftar'])->name('daftar.verifikasi.post');
Route::post('/daftar/kirim-ulang',       [MasyarakatAuthController::class, 'kirimUlangVerifikasiDaftar'])->name('daftar.verifikasi.kirimulang');
Route::get('/lupa-password', [MasyarakatAuthController::class, 'showLupaPassword'])->name('lupa.password');
Route::post('/lupa-password', [MasyarakatAuthController::class, 'lupaPasswordStep1'])->name('lupa.password.step1')->middleware('throttle:3,1');
Route::get('/lupa-password/verifikasi', [MasyarakatAuthController::class, 'showVerifikasi'])->name('lupa.password.verifikasi');
Route::post('/lupa-password/verifikasi', [MasyarakatAuthController::class, 'prosesVerifikasi'])->name('lupa.password.verifikasi.post')->middleware('throttle:5,1');
Route::post('/lupa-password/kirim-ulang', [MasyarakatAuthController::class, 'kirimUlang'])->name('lupa.password.kirimulang')->middleware('throttle:2,1');
Route::get('/lupa-password/selesai', [MasyarakatAuthController::class, 'selesai'])->name('lupa.password.selesai');
Route::get('/logout', [MasyarakatAuthController::class, 'logout'])->name('logout');

// Petugas Auth
Route::get('/login-admin',  [PetugasAuthController::class, 'showLogin'])->name('login.petugas');
Route::post('/login-admin', [PetugasAuthController::class, 'login'])->name('login.petugas.post')->middleware('throttle:5,1');
Route::get('/logout-admin', [PetugasAuthController::class, 'logout'])->name('logout.petugas');

// ── Masyarakat (protected) ───────────────────────────────────────────────────
Route::prefix('masyarakat')->middleware('masyarakat.auth')->group(function () {
    Route::get('/',                    [MasyarakatController::class, 'index'])->name('masyarakat.index');
    Route::get('/penawaran',           [MasyarakatController::class, 'penawaran'])->name('masyarakat.penawaran');
    Route::post('/penawaran/simpan',   [MasyarakatController::class, 'simpanPenawaran'])->name('masyarakat.penawaran.simpan')->middleware('throttle:10,1');
    Route::post('/penawaran/update',   [MasyarakatController::class, 'updatePenawaran'])->name('masyarakat.penawaran.update');
    Route::delete('/penawaran/{id}',   [MasyarakatController::class, 'hapusPenawaran'])->name('masyarakat.penawaran.hapus');
    Route::get('/profile',             [MasyarakatController::class, 'profile'])->name('masyarakat.profile');
    Route::post('/profile/update',     [MasyarakatController::class, 'updateProfile'])->name('masyarakat.profile.update')->middleware('throttle:5,1');
    Route::post('/profile/password',   [MasyarakatController::class, 'updatePassword'])->name('masyarakat.profile.password')->middleware('throttle:5,1');
    Route::post('/profile/foto',       [MasyarakatController::class, 'updateFoto'])->name('masyarakat.profile.foto')->middleware('throttle:3,1');
    Route::get('/faktur/{id_lelang}',  [MasyarakatController::class, 'fakturPdf'])->name('masyarakat.faktur_pdf');
    Route::get('/wishlist',            [\App\Http\Controllers\WishlistController::class, 'index'])->name('masyarakat.wishlist');
    Route::post('/wishlist/toggle/{id_barang}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('masyarakat.wishlist.toggle');
    Route::post('/rating/{id_lelang}', [\App\Http\Controllers\RatingController::class, 'store'])->name('masyarakat.rating.store');
    Route::post('/bukti-pembayaran/{id_lelang}', [\App\Http\Controllers\BuktiPembayaranController::class, 'upload'])->name('masyarakat.bukti_bayar.upload');
    Route::get('/riwayat', [\App\Http\Controllers\RiwayatController::class, 'index'])->name('masyarakat.riwayat');
    Route::get('/riwayat/{id_lelang}', [\App\Http\Controllers\RiwayatController::class, 'detail'])->name('masyarakat.riwayat.detail');
    Route::get('/lelang/{id_lelang}/konfirmasi-kemenangan', [\App\Http\Controllers\MasyarakatKonfirmasiController::class, 'show'])->name('masyarakat.konfirmasi_kemenangan');
    Route::post('/lelang/{id_lelang}/konfirmasi-kemenangan/konfirmasi', [\App\Http\Controllers\MasyarakatKonfirmasiController::class, 'konfirmasi'])->name('masyarakat.konfirmasi_kemenangan.konfirmasi');
    Route::post('/lelang/{id_lelang}/konfirmasi-kemenangan/batalkan', [\App\Http\Controllers\MasyarakatKonfirmasiController::class, 'batalkan'])->name('masyarakat.konfirmasi_kemenangan.batalkan');
});

// ── Petugas (protected) ──────────────────────────────────────────────────────
Route::prefix('petugas')->middleware('petugas.auth')->group(function () {
    Route::get('/',                    [PetugasController::class, 'index'])->name('petugas.index');
    Route::get('/barang',              [PetugasController::class, 'barang'])->name('petugas.barang');
    Route::post('/barang/simpan',      [PetugasController::class, 'simpanBarang'])->name('petugas.barang.simpan');
    Route::post('/barang/update',      [PetugasController::class, 'updateBarang'])->name('petugas.barang.update');
    Route::delete('/barang/{id}',      [PetugasController::class, 'hapusBarang'])->name('petugas.barang.hapus');
    Route::get('/aktivasi',            [PetugasController::class, 'aktivasi'])->name('petugas.aktivasi');
    Route::post('/aktivasi/simpan',    [PetugasController::class, 'simpanLelang'])->name('petugas.aktivasi.simpan');
    Route::post('/aktivasi/buka',      [PetugasController::class, 'bukaLelang'])->name('petugas.aktivasi.buka');
    Route::post('/aktivasi/tutup',     [PetugasController::class, 'tutupLelang'])->name('petugas.aktivasi.tutup');
    Route::get('/laporan',             [PetugasController::class, 'laporan'])->name('petugas.laporan');
    Route::post('/laporan/update-status', [PetugasController::class, 'updateStatusKonfirmasi'])->name('petugas.laporan.update_status');
    Route::get('/laporan/faktur/{id_lelang}', [PetugasController::class, 'fakturPdf'])->name('petugas.faktur_pdf');
    Route::get('/laporan/pdf',         [PetugasController::class, 'laporanPdf'])->name('petugas.laporan.pdf');
    Route::get('/isi',                 [PetugasController::class, 'isi'])->name('petugas.isi');
    Route::get('/print',               [PetugasController::class, 'print'])->name('petugas.print');
    Route::get('/petugas',             [PetugasController::class, 'petugas'])->name('petugas.petugas');
});

// ── Administrator (protected) ────────────────────────────────────────────────
Route::prefix('administrator')->middleware(['petugas.auth', 'admin.only'])->group(function () {
    Route::get('/',                    [AdministratorController::class, 'index'])->name('administrator.index');
    Route::get('/barang',              [AdministratorController::class, 'barang'])->name('administrator.barang');
    Route::post('/barang/simpan',      [AdministratorController::class, 'simpanBarang'])->name('administrator.barang.simpan');
    Route::post('/barang/update',      [AdministratorController::class, 'updateBarang'])->name('administrator.barang.update');
    Route::delete('/barang/{id}',      [AdministratorController::class, 'hapusBarang'])->name('administrator.barang.hapus');
    Route::get('/laporan',             [AdministratorController::class, 'laporan'])->name('administrator.laporan');
    Route::post('/laporan/update-status', [AdministratorController::class, 'updateStatusKonfirmasi'])->name('administrator.laporan.update_status');
    Route::post('/laporan/verifikasi-bukti/{id_lelang}', [\App\Http\Controllers\BuktiPembayaranController::class, 'verifikasi'])->name('administrator.bukti_bayar.verifikasi');
    Route::get('/laporan/export', [AdministratorController::class, 'exportLaporan'])->name('administrator.laporan.export');
    Route::get('/laporan/faktur/{id_lelang}', [AdministratorController::class, 'fakturPdf'])->name('administrator.faktur_pdf');
    Route::get('/activity-log', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('administrator.activity_log');
    Route::get('/laporan/pdf',         [AdministratorController::class, 'laporanPdf'])->name('administrator.laporan.pdf');
    Route::get('/print',               [AdministratorController::class, 'print'])->name('administrator.print');
    Route::get('/petugas',             [AdministratorController::class, 'petugas'])->name('administrator.petugas');
    Route::post('/petugas/simpan',     [AdministratorController::class, 'simpanPetugas'])->name('administrator.petugas.simpan');
    Route::post('/petugas/update',     [AdministratorController::class, 'updatePetugas'])->name('administrator.petugas.update');
    Route::delete('/petugas/{id}',     [AdministratorController::class, 'hapusPetugas'])->name('administrator.petugas.hapus');
});
