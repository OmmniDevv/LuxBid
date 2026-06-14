<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Hapus barang kadaluarsa setiap hari pukul 01:00 WIB
Schedule::command('lelang:hapus-barang-kadaluarsa')->dailyAt('01:00')->timezone('Asia/Jakarta');

// Proses batas konfirmasi setiap jam
Schedule::command('lelang:proses-batas-konfirmasi')->hourly()->timezone('Asia/Jakarta');

// Notifikasi lelang akan ditutup setiap 15 menit
Schedule::command('lelang:notifikasi-akan-ditutup')->everyFifteenMinutes()->timezone('Asia/Jakarta');
