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
Route::post('/login', [MasyarakatAuthController::class, 'login'])->name('login.masyarakat.post');
Route::get('/daftar',  [MasyarakatAuthController::class, 'showRegister'])->name('daftar.masyarakat');
Route::post('/daftar', [MasyarakatAuthController::class, 'register'])->name('daftar.masyarakat.post');
Route::get('/lupa-password', [MasyarakatAuthController::class, 'showLupaPassword'])->name('lupa.password');
Route::post('/lupa-password/step1', [MasyarakatAuthController::class, 'lupaPasswordStep1'])->name('lupa.password.step1');
Route::get('/logout', [MasyarakatAuthController::class, 'logout'])->name('logout');

// Petugas Auth
Route::get('/login-admin',  [PetugasAuthController::class, 'showLogin'])->name('login.petugas');
Route::post('/login-admin', [PetugasAuthController::class, 'login'])->name('login.petugas.post');
Route::get('/logout-admin', [PetugasAuthController::class, 'logout'])->name('logout.petugas');

// ── Masyarakat (protected) ───────────────────────────────────────────────────
Route::prefix('masyarakat')->middleware('masyarakat.auth')->group(function () {
    Route::get('/',                    [MasyarakatController::class, 'index'])->name('masyarakat.index');
    Route::get('/penawaran',           [MasyarakatController::class, 'penawaran'])->name('masyarakat.penawaran');
    Route::post('/penawaran/simpan',   [MasyarakatController::class, 'simpanPenawaran'])->name('masyarakat.penawaran.simpan');
    Route::post('/penawaran/update',   [MasyarakatController::class, 'updatePenawaran'])->name('masyarakat.penawaran.update');
    Route::get('/penawaran/hapus',     [MasyarakatController::class, 'hapusPenawaran'])->name('masyarakat.penawaran.hapus');
    Route::get('/profile',             [MasyarakatController::class, 'profile'])->name('masyarakat.profile');
    Route::post('/profile/update',     [MasyarakatController::class, 'updateProfile'])->name('masyarakat.profile.update');
    Route::post('/profile/password',   [MasyarakatController::class, 'updatePassword'])->name('masyarakat.profile.password');
    Route::post('/profile/foto',       [MasyarakatController::class, 'updateFoto'])->name('masyarakat.profile.foto');
    Route::get('/faktur/{id_lelang}',  [MasyarakatController::class, 'fakturPdf'])->name('masyarakat.faktur');
});

// ── Petugas (protected) ──────────────────────────────────────────────────────
Route::prefix('petugas')->middleware('petugas.auth')->group(function () {
    Route::get('/',                    [PetugasController::class, 'index'])->name('petugas.index');
    Route::get('/barang',              [PetugasController::class, 'barang'])->name('petugas.barang');
    Route::post('/barang/simpan',      [PetugasController::class, 'simpanBarang'])->name('petugas.barang.simpan');
    Route::post('/barang/update',      [PetugasController::class, 'updateBarang'])->name('petugas.barang.update');
    Route::get('/barang/hapus',        [PetugasController::class, 'hapusBarang'])->name('petugas.barang.hapus');
    Route::get('/aktivasi',            [PetugasController::class, 'aktivasi'])->name('petugas.aktivasi');
    Route::post('/aktivasi/simpan',    [PetugasController::class, 'simpanLelang'])->name('petugas.aktivasi.simpan');
    Route::post('/aktivasi/buka',      [PetugasController::class, 'bukaLelang'])->name('petugas.aktivasi.buka');
    Route::post('/aktivasi/tutup',     [PetugasController::class, 'tutupLelang'])->name('petugas.aktivasi.tutup');
    Route::get('/laporan',             [PetugasController::class, 'laporan'])->name('petugas.laporan');
    Route::get('/laporan/pdf',         [PetugasController::class, 'laporanPdf'])->name('petugas.laporan.pdf');
    Route::get('/isi',                 [PetugasController::class, 'isi'])->name('petugas.isi');
    Route::get('/print',               [PetugasController::class, 'print'])->name('petugas.print');
    Route::get('/petugas',             [PetugasController::class, 'petugas'])->name('petugas.petugas');
});

// ── Administrator (protected) ────────────────────────────────────────────────
Route::prefix('administrator')->middleware('petugas.auth')->group(function () {
    Route::get('/',                    [AdministratorController::class, 'index'])->name('administrator.index');
    Route::get('/barang',              [AdministratorController::class, 'barang'])->name('administrator.barang');
    Route::post('/barang/simpan',      [AdministratorController::class, 'simpanBarang'])->name('administrator.barang.simpan');
    Route::post('/barang/update',      [AdministratorController::class, 'updateBarang'])->name('administrator.barang.update');
    Route::get('/barang/hapus',        [AdministratorController::class, 'hapusBarang'])->name('administrator.barang.hapus');
    Route::get('/laporan',             [AdministratorController::class, 'laporan'])->name('administrator.laporan');
    Route::get('/laporan/pdf',         [AdministratorController::class, 'laporanPdf'])->name('administrator.laporan.pdf');
    Route::get('/print',               [AdministratorController::class, 'print'])->name('administrator.print');
    Route::get('/petugas',             [AdministratorController::class, 'petugas'])->name('administrator.petugas');
    Route::post('/petugas/simpan',     [AdministratorController::class, 'simpanPetugas'])->name('administrator.petugas.simpan');
    Route::post('/petugas/update',     [AdministratorController::class, 'updatePetugas'])->name('administrator.petugas.update');
    Route::get('/petugas/hapus',       [AdministratorController::class, 'hapusPetugas'])->name('administrator.petugas.hapus');
});
