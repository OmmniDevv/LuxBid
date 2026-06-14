<?php

namespace Tests\Feature;

use App\Mail\LelangBerakhirPesertaMail;
use App\Mail\LelangPemenangMail;
use App\Models\Barang;
use App\Models\HistoryLelang;
use App\Models\Kategori;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\Petugas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LelangEmailPenawarKalahTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class,
        ]);
        \DB::table('tb_level')->insertOrIgnore([
            ['id_level' => 1, 'level' => 'administrator'],
            ['id_level' => 2, 'level' => 'petugas'],
        ]);
    }

    public function test_lelang_ditutup_kirim_email_ke_pemenang_dan_penawar_kalah()
    {
        Mail::fake();

        $petugas    = Petugas::factory()->create();
        $kategori   = Kategori::factory()->create(['nama_kategori' => 'Elektronik']);
        $barang     = Barang::factory()->create(['harga_awal' => 100000, 'id_kategori' => $kategori->id_kategori]);
        $lelang     = Lelang::factory()->create(['id_barang' => $barang->id_barang, 'id_petugas' => $petugas->id_petugas, 'status' => 'dibuka']);

        $pemenang   = Masyarakat::factory()->create(['email' => 'pemenang@test.com']);
        $penawar1   = Masyarakat::factory()->create(['email' => 'penawar1@test.com']);
        $penawar2   = Masyarakat::factory()->create(['email' => 'penawar2@test.com']);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $pemenang->id_user,
            'penawaran_harga' => 300000,
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $penawar1->id_user,
            'penawaran_harga' => 250000,
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $penawar2->id_user,
            'penawaran_harga' => 200000,
        ]);

        app(\App\Services\LelangService::class)->tutup($lelang, $pemenang->id_user, 300000);

        // Pemenang dapat LelangPemenangMail
        Mail::assertQueued(LelangPemenangMail::class, fn($m) => $m->hasTo('pemenang@test.com'));

        // Penawar yang kalah dapat LelangBerakhirPesertaMail (2 orang)
        Mail::assertQueued(LelangBerakhirPesertaMail::class, 2);
        Mail::assertQueued(LelangBerakhirPesertaMail::class, fn($m) => $m->hasTo('penawar1@test.com'));
        Mail::assertQueued(LelangBerakhirPesertaMail::class, fn($m) => $m->hasTo('penawar2@test.com'));
    }

    public function test_email_penawar_kalah_berisi_rekomendasi_lelang_serupa()
    {
        Mail::fake();

        $petugas  = Petugas::factory()->create();
        $kategori = Kategori::factory()->create(['nama_kategori' => 'Elektronik']);
        $barang1  = Barang::factory()->create(['nama_barang' => 'Laptop Lenovo', 'harga_awal' => 5000000, 'id_kategori' => $kategori->id_kategori]);
        $barang2  = Barang::factory()->create(['nama_barang' => 'Laptop Dell', 'harga_awal' => 6000000, 'id_kategori' => $kategori->id_kategori]);
        $barang3  = Barang::factory()->create(['nama_barang' => 'Laptop HP', 'harga_awal' => 5500000, 'id_kategori' => $kategori->id_kategori]);

        $lelang1 = Lelang::factory()->create(['id_barang' => $barang1->id_barang, 'id_petugas' => $petugas->id_petugas, 'status' => 'dibuka']);
        $lelang2 = Lelang::factory()->create(['id_barang' => $barang2->id_barang, 'id_petugas' => $petugas->id_petugas, 'status' => 'dibuka']);
        $lelang3 = Lelang::factory()->create(['id_barang' => $barang3->id_barang, 'id_petugas' => $petugas->id_petugas, 'status' => 'dibuka']);

        $pemenang = Masyarakat::factory()->create(['email' => 'pemenang@test.com']);
        $penawar  = Masyarakat::factory()->create(['email' => 'penawar@test.com']);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang1->id_lelang,
            'id_barang'       => $barang1->id_barang,
            'id_user'         => $pemenang->id_user,
            'penawaran_harga' => 6000000,
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang1->id_lelang,
            'id_barang'       => $barang1->id_barang,
            'id_user'         => $penawar->id_user,
            'penawaran_harga' => 5500000,
        ]);

        app(\App\Services\LelangService::class)->tutup($lelang1, $pemenang->id_user, 6000000);

        Mail::assertQueued(LelangBerakhirPesertaMail::class, function($mail) use ($barang2, $barang3) {
            // Email harus memiliki rekomendasi lelang
            $this->assertNotEmpty($mail->rekomendasi);

            // Rekomendasi harus dari kategori yang sama dan masih dibuka
            $namaBarang = array_column($mail->rekomendasi, 'nama_barang');
            $this->assertContains($barang2->nama_barang, $namaBarang);

            return $mail->hasTo('penawar@test.com');
        });
    }

    public function test_email_penawar_kalah_tanpa_rekomendasi_jika_tidak_ada_lelang_serupa()
    {
        Mail::fake();

        $petugas    = Petugas::factory()->create();
        $kategori   = Kategori::factory()->create(['nama_kategori' => 'Elektronik']);
        $barang     = Barang::factory()->create(['harga_awal' => 100000, 'id_kategori' => $kategori->id_kategori]);
        $lelang     = Lelang::factory()->create(['id_barang' => $barang->id_barang, 'id_petugas' => $petugas->id_petugas, 'status' => 'dibuka']);

        $pemenang   = Masyarakat::factory()->create(['email' => 'pemenang@test.com']);
        $penawar    = Masyarakat::factory()->create(['email' => 'penawar@test.com']);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $pemenang->id_user,
            'penawaran_harga' => 200000,
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $penawar->id_user,
            'penawaran_harga' => 150000,
        ]);

        app(\App\Services\LelangService::class)->tutup($lelang, $pemenang->id_user, 200000);

        Mail::assertQueued(LelangBerakhirPesertaMail::class, function($mail) {
            // Tidak ada rekomendasi karena tidak ada lelang lain yang masih dibuka dengan kategori sama
            $this->assertEmpty($mail->rekomendasi);
            return $mail->hasTo('penawar@test.com');
        });
    }
}
