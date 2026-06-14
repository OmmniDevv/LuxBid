<?php

namespace Tests\Feature;

use App\Mail\KonfirmasiDiterimaMail;
use App\Mail\LelangPemenangMail;
use App\Models\Barang;
use App\Models\HistoryLelang;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\Petugas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LelangKonfirmasiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class,
        ]);
        // Seed level rows required by PetugasFactory
        \DB::table('tb_level')->insertOrIgnore([
            ['id_level' => 1, 'level' => 'administrator'],
            ['id_level' => 2, 'level' => 'petugas'],
        ]);
    }

    private function sessionMasyarakat(Masyarakat $user): array
    {
        return ['id_user' => $user->id_user, 'username' => $user->username, 'status' => 'login'];
    }

    private function sessionAdmin(Petugas $p): array
    {
        return ['id_petugas' => $p->id_petugas, 'id_level' => 1, 'username' => $p->username];
    }

    public function test_lelang_ditutup_mengatur_status_konfirmasi_dan_nomor_faktur()
    {
        Mail::fake();

        $petugas    = Petugas::factory()->create();
        $barang     = Barang::factory()->create(['harga_awal' => 100000]);
        $lelang     = Lelang::factory()->create(['id_barang' => $barang->id_barang, 'id_petugas' => $petugas->id_petugas, 'status' => 'dibuka']);
        $masyarakat = Masyarakat::factory()->create(['email' => 'pemenang@test.com']);

        HistoryLelang::factory()->create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $barang->id_barang,
            'id_user'         => $masyarakat->id_user,
            'penawaran_harga' => 150000,
        ]);

        app(\App\Services\LelangService::class)->tutup($lelang, $masyarakat->id_user, 150000);

        $lelang->refresh();

        $this->assertEquals('ditutup', $lelang->status);
        $this->assertEquals('menunggu_konfirmasi', $lelang->status_konfirmasi);
        $this->assertNotNull($lelang->nomor_faktur);
        $this->assertStringStartsWith('LXB-', $lelang->nomor_faktur);
        $this->assertNotNull($lelang->batas_konfirmasi);
        $this->assertTrue($lelang->batas_konfirmasi->isFuture());

        Mail::assertQueued(LelangPemenangMail::class, fn($m) => $m->hasTo('pemenang@test.com'));
    }

    public function test_pemenang_dapat_mengkonfirmasi_kesediaan()
    {
        Mail::fake();

        $petugas    = Petugas::factory()->create();
        $barang     = Barang::factory()->create();
        $masyarakat = Masyarakat::factory()->create(['email' => 'pemenang@test.com']);
        $lelang     = Lelang::factory()->create([
            'id_barang'          => $barang->id_barang,
            'id_petugas'         => $petugas->id_petugas,
            'status'             => 'ditutup',
            'id_user'            => $masyarakat->id_user,
            'harga_akhir'        => 200000,
            'status_konfirmasi'  => 'menunggu_konfirmasi',
            'nomor_faktur'       => 'LXB-TEST1234',
            'batas_konfirmasi'   => now()->addDays(2),
        ]);

        $response = $this->withSession($this->sessionMasyarakat($masyarakat))
            ->post(route('masyarakat.konfirmasi_kemenangan.konfirmasi', $lelang->id_lelang));

        $response->assertRedirect(route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang));
        $response->assertSessionHas('success');

        $lelang->refresh();
        $this->assertEquals('dikonfirmasi', $lelang->status_konfirmasi);
        $this->assertNotNull($lelang->tanggal_konfirmasi);

        Mail::assertQueued(KonfirmasiDiterimaMail::class, fn($m) => $m->hasTo('pemenang@test.com'));
    }

    public function test_pemenang_dapat_membatalkan_kemenangan()
    {
        $petugas    = Petugas::factory()->create();
        $barang     = Barang::factory()->create();
        $masyarakat = Masyarakat::factory()->create();
        $lelang     = Lelang::factory()->create([
            'id_barang'         => $barang->id_barang,
            'id_petugas'        => $petugas->id_petugas,
            'status'            => 'ditutup',
            'id_user'           => $masyarakat->id_user,
            'harga_akhir'       => 200000,
            'status_konfirmasi' => 'menunggu_konfirmasi',
            'nomor_faktur'      => 'LXB-TEST1234',
        ]);

        $response = $this->withSession($this->sessionMasyarakat($masyarakat))
            ->post(route('masyarakat.konfirmasi_kemenangan.batalkan', $lelang->id_lelang), [
                'catatan' => 'Tidak jadi beli',
            ]);

        $response->assertRedirect(route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang));

        $lelang->refresh();
        // Batch B: saat pemenang batalkan dan tidak ada penawar kedua, status jadi 'selesai'
        $this->assertEquals('selesai', $lelang->status_konfirmasi);
        $this->assertStringContainsString('Tidak jadi beli', $lelang->catatan_admin);
    }

    public function test_non_pemenang_tidak_dapat_akses_halaman_konfirmasi()
    {
        $petugas    = Petugas::factory()->create();
        $barang     = Barang::factory()->create();
        $pemenang   = Masyarakat::factory()->create();
        $nonPemenang = Masyarakat::factory()->create();
        $lelang     = Lelang::factory()->create([
            'id_barang'         => $barang->id_barang,
            'id_petugas'        => $petugas->id_petugas,
            'status'            => 'ditutup',
            'id_user'           => $pemenang->id_user,
            'harga_akhir'       => 200000,
            'status_konfirmasi' => 'menunggu_konfirmasi',
        ]);

        $response = $this->withSession($this->sessionMasyarakat($nonPemenang))
            ->get(route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang));

        $response->assertForbidden();
    }

    public function test_admin_dapat_mengupdate_status_konfirmasi_manual()
    {
        $petugas    = Petugas::factory()->admin()->create();
        $barang     = Barang::factory()->create();
        $masyarakat = Masyarakat::factory()->create();
        $lelang     = Lelang::factory()->create([
            'id_barang'         => $barang->id_barang,
            'id_petugas'        => $petugas->id_petugas,
            'status'            => 'ditutup',
            'id_user'           => $masyarakat->id_user,
            'harga_akhir'       => 200000,
            'status_konfirmasi' => 'dikonfirmasi',
        ]);

        $response = $this->withSession($this->sessionAdmin($petugas))
            ->post(route('administrator.laporan.update_status'), [
                'id_lelang'         => $lelang->id_lelang,
                'status_konfirmasi' => 'selesai',
                'catatan_admin'     => 'Pembayaran sudah diterima',
            ]);

        $response->assertRedirect(route('administrator.laporan'));
        $response->assertSessionHas('success');

        $lelang->refresh();
        $this->assertEquals('selesai', $lelang->status_konfirmasi);
        $this->assertStringContainsString('Pembayaran sudah diterima', $lelang->catatan_admin);
    }

    public function test_filter_status_konfirmasi_di_laporan()
    {
        $petugas    = Petugas::factory()->admin()->create();
        $barang     = Barang::factory()->create();
        $masyarakat = Masyarakat::factory()->create();

        Lelang::factory()->create([
            'id_barang'         => $barang->id_barang,
            'id_petugas'        => $petugas->id_petugas,
            'status'            => 'ditutup',
            'id_user'           => $masyarakat->id_user,
            'status_konfirmasi' => 'menunggu_konfirmasi',
        ]);

        $lelang2 = Lelang::factory()->create([
            'id_barang'         => $barang->id_barang,
            'id_petugas'        => $petugas->id_petugas,
            'status'            => 'ditutup',
            'id_user'           => $masyarakat->id_user,
            'status_konfirmasi' => 'dikonfirmasi',
        ]);

        $response = $this->withSession($this->sessionAdmin($petugas))
            ->get(route('administrator.laporan', ['status_konfirmasi' => 'dikonfirmasi']));

        $response->assertOk();
        $response->assertSee((string) $lelang2->id_lelang);
    }

    public function test_admin_akses_faktur_lelang_manapun()
    {
        $petugas    = Petugas::factory()->admin()->create();
        $barang     = Barang::factory()->create();
        $masyarakat = Masyarakat::factory()->create();
        $lelang     = Lelang::factory()->create([
            'id_barang'    => $barang->id_barang,
            'id_petugas'   => $petugas->id_petugas,
            'status'       => 'ditutup',
            'id_user'      => $masyarakat->id_user,
            'harga_akhir'  => 200000,
            'nomor_faktur' => 'LXB-ABCD1234',
        ]);

        $response = $this->withSession($this->sessionAdmin($petugas))
            ->get(route('administrator.faktur_pdf', $lelang->id_lelang));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
