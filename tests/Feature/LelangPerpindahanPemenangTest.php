<?php

namespace Tests\Feature;

use App\Mail\LelangPemenangMail;
use App\Models\Barang;
use App\Models\HistoryLelang;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\Petugas;
use App\Models\RiwayatPemenangLelang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class LelangPerpindahanPemenangTest extends TestCase
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

    private function sessionMasyarakat(Masyarakat $user): array
    {
        return ['id_user' => $user->id_user, 'username' => $user->username, 'status' => 'login'];
    }

    public function test_pemenang_batalkan_lempar_ke_penawar_kedua()
    {
        Mail::fake();

        $petugas    = Petugas::factory()->create();
        $barang     = Barang::factory()->create();
        $pemenang1  = Masyarakat::factory()->create(['email' => 'pemenang1@test.com']);
        $pemenang2  = Masyarakat::factory()->create(['email' => 'pemenang2@test.com']);

        $lelang = Lelang::factory()->create([
            'id_barang'         => $barang->id_barang,
            'id_petugas'        => $petugas->id_petugas,
            'status'            => 'ditutup',
            'id_user'           => $pemenang1->id_user,
            'harga_akhir'       => 200000,
            'status_konfirmasi' => 'menunggu_konfirmasi',
            'nomor_faktur'      => 'LXB-TEST1',
            'batas_konfirmasi'  => now()->addDays(2),
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $pemenang1->id_user,
            'penawaran_harga' => 200000,
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $pemenang2->id_user,
            'penawaran_harga' => 180000,
        ]);

        $response = $this->withSession($this->sessionMasyarakat($pemenang1))
            ->post(route('masyarakat.konfirmasi_kemenangan.batalkan', $lelang->id_lelang), [
                'catatan' => 'Tidak jadi beli',
            ]);

        $response->assertRedirect(route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang));
        $response->assertSessionHas('info');

        $lelang->refresh();
        $this->assertEquals($pemenang2->id_user, $lelang->id_user);
        $this->assertEquals(180000, $lelang->harga_akhir);
        $this->assertEquals('menunggu_konfirmasi', $lelang->status_konfirmasi);
        $this->assertNotNull($lelang->nomor_faktur);
        $this->assertNotNull($lelang->batas_konfirmasi);

        $this->assertDatabaseHas('riwayat_pemenang_lelang', [
            'id_lelang' => $lelang->id_lelang,
            'id_user'   => $pemenang1->id_user,
            'status'    => 'dibatalkan',
        ]);

        $this->assertDatabaseHas('riwayat_pemenang_lelang', [
            'id_lelang' => $lelang->id_lelang,
            'id_user'   => $pemenang2->id_user,
            'status'    => 'aktif',
        ]);

        Mail::assertQueued(LelangPemenangMail::class, fn($m) => $m->hasTo('pemenang2@test.com'));
    }

    public function test_command_auto_cancel_timeout_lelang()
    {
        Mail::fake();

        $petugas    = Petugas::factory()->create();
        $barang     = Barang::factory()->create();
        $pemenang1  = Masyarakat::factory()->create(['email' => 'pemenang1@test.com']);
        $pemenang2  = Masyarakat::factory()->create(['email' => 'pemenang2@test.com']);

        $lelang = Lelang::factory()->create([
            'id_barang'         => $barang->id_barang,
            'id_petugas'        => $petugas->id_petugas,
            'status'            => 'ditutup',
            'id_user'           => $pemenang1->id_user,
            'harga_akhir'       => 200000,
            'status_konfirmasi' => 'menunggu_konfirmasi',
            'nomor_faktur'      => 'LXB-TEST1',
            'batas_konfirmasi'  => now()->subHour(),
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $pemenang1->id_user,
            'penawaran_harga' => 200000,
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $pemenang2->id_user,
            'penawaran_harga' => 180000,
        ]);

        Artisan::call('lelang:proses-batas-konfirmasi');

        $lelang->refresh();
        $this->assertEquals($pemenang2->id_user, $lelang->id_user);
        $this->assertEquals(180000, $lelang->harga_akhir);
        $this->assertEquals('menunggu_konfirmasi', $lelang->status_konfirmasi);
        $this->assertStringContainsString('Dibatalkan otomatis', $lelang->catatan_admin);

        $this->assertDatabaseHas('riwayat_pemenang_lelang', [
            'id_lelang' => $lelang->id_lelang,
            'id_user'   => $pemenang1->id_user,
            'status'    => 'dibatalkan',
        ]);

        Mail::assertQueued(LelangPemenangMail::class, fn($m) => $m->hasTo('pemenang2@test.com'));
    }

    public function test_tidak_ada_penawar_pengganti_status_selesai()
    {
        $petugas    = Petugas::factory()->create();
        $barang     = Barang::factory()->create();
        $pemenang1  = Masyarakat::factory()->create(['email' => 'pemenang1@test.com']);

        $lelang = Lelang::factory()->create([
            'id_barang'         => $barang->id_barang,
            'id_petugas'        => $petugas->id_petugas,
            'status'            => 'ditutup',
            'id_user'           => $pemenang1->id_user,
            'harga_akhir'       => 200000,
            'status_konfirmasi' => 'menunggu_konfirmasi',
            'nomor_faktur'      => 'LXB-TEST1',
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $pemenang1->id_user,
            'penawaran_harga' => 200000,
        ]);

        $response = $this->withSession($this->sessionMasyarakat($pemenang1))
            ->post(route('masyarakat.konfirmasi_kemenangan.batalkan', $lelang->id_lelang), [
                'catatan' => 'Tidak jadi beli',
            ]);

        $response->assertRedirect(route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang));

        $lelang->refresh();
        $this->assertEquals('selesai', $lelang->status_konfirmasi);
        $this->assertStringContainsString('Tidak ada penawar pengganti', $lelang->catatan_admin);

        $this->assertDatabaseHas('riwayat_pemenang_lelang', [
            'id_lelang' => $lelang->id_lelang,
            'id_user'   => $pemenang1->id_user,
            'status'    => 'dibatalkan',
        ]);
    }

    public function test_riwayat_pemenang_tercatat_saat_konfirmasi()
    {
        Mail::fake();

        $petugas    = Petugas::factory()->create();
        $barang     = Barang::factory()->create();
        $pemenang   = Masyarakat::factory()->create(['email' => 'pemenang@test.com']);

        $lelang = Lelang::factory()->create([
            'id_barang'         => $barang->id_barang,
            'id_petugas'        => $petugas->id_petugas,
            'status'            => 'ditutup',
            'id_user'           => $pemenang->id_user,
            'harga_akhir'       => 200000,
            'status_konfirmasi' => 'menunggu_konfirmasi',
            'nomor_faktur'      => 'LXB-TEST1',
        ]);

        $response = $this->withSession($this->sessionMasyarakat($pemenang))
            ->post(route('masyarakat.konfirmasi_kemenangan.konfirmasi', $lelang->id_lelang));

        $response->assertRedirect(route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang));

        $this->assertDatabaseHas('riwayat_pemenang_lelang', [
            'id_lelang' => $lelang->id_lelang,
            'id_user'   => $pemenang->id_user,
            'status'    => 'dikonfirmasi',
        ]);
    }

    public function test_penawar_yang_sudah_dibatalkan_tidak_dipilih_lagi()
    {
        Mail::fake();

        $petugas    = Petugas::factory()->create();
        $barang     = Barang::factory()->create();
        $pemenang1  = Masyarakat::factory()->create(['email' => 'pemenang1@test.com']);
        $pemenang2  = Masyarakat::factory()->create(['email' => 'pemenang2@test.com']);
        $pemenang3  = Masyarakat::factory()->create(['email' => 'pemenang3@test.com']);

        $lelang = Lelang::factory()->create([
            'id_barang'         => $barang->id_barang,
            'id_petugas'        => $petugas->id_petugas,
            'status'            => 'ditutup',
            'id_user'           => $pemenang1->id_user,
            'harga_akhir'       => 300000,
            'status_konfirmasi' => 'menunggu_konfirmasi',
            'nomor_faktur'      => 'LXB-TEST1',
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $pemenang1->id_user,
            'penawaran_harga' => 300000,
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $pemenang2->id_user,
            'penawaran_harga' => 280000,
        ]);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $pemenang3->id_user,
            'penawaran_harga' => 250000,
        ]);

        $this->withSession($this->sessionMasyarakat($pemenang1))
            ->post(route('masyarakat.konfirmasi_kemenangan.batalkan', $lelang->id_lelang));

        $lelang->refresh();
        $this->assertEquals($pemenang2->id_user, $lelang->id_user);

        $this->withSession($this->sessionMasyarakat($pemenang2))
            ->post(route('masyarakat.konfirmasi_kemenangan.batalkan', $lelang->id_lelang));

        $lelang->refresh();
        $this->assertEquals($pemenang3->id_user, $lelang->id_user);
        $this->assertEquals(250000, $lelang->harga_akhir);

        Mail::assertQueued(LelangPemenangMail::class, 2);
    }
}
