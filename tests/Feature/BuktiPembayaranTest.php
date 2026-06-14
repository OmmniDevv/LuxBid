<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\Petugas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BuktiPembayaranTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsMasyarakat($masyarakat)
    {
        return $this->withSession([
            'id_user' => $masyarakat->id_user,
            'username' => $masyarakat->username,
            'nama_lengkap' => $masyarakat->nama_lengkap,
            'status' => 'login',
            'level' => 'Masyarakat'
        ]);
    }

    private function actingAsPetugas($petugas)
    {
        return $this->withSession([
            'id_petugas' => $petugas->id_petugas,
            'username' => $petugas->username,
            'nama_petugas' => $petugas->nama_petugas,
            'status' => 'login',
            'id_level' => $petugas->id_level,
            'level' => $petugas->id_level == 1 ? 'administrator' : 'petugas'
        ]);
    }

    public function test_pemenang_dapat_upload_bukti_pembayaran()
    {
        Storage::fake('public');
        $petugas = Petugas::factory()->create();
        $pemenang = Masyarakat::factory()->create();
        $barang = Barang::factory()->create();
        $lelang = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_user' => $pemenang->id_user,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'ditutup',
            'status_konfirmasi' => 'dikonfirmasi',
            'harga_akhir' => 1000000,
        ]);

        $file = UploadedFile::fake()->image('bukti.jpg');

        $response = $this->actingAsMasyarakat($pemenang)
            ->post(route('masyarakat.bukti_bayar.upload', $lelang->id_lelang), [
                'bukti_pembayaran' => $file,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $lelang->refresh();
        $this->assertNotNull($lelang->bukti_pembayaran);
        $this->assertNotNull($lelang->tanggal_bayar);
        Storage::disk('public')->assertExists('bukti_bayar/' . $lelang->bukti_pembayaran);
    }

    public function test_non_pemenang_tidak_dapat_upload_bukti()
    {
        Storage::fake('public');
        $petugas = Petugas::factory()->create();
        $pemenang = Masyarakat::factory()->create();
        $nonPemenang = Masyarakat::factory()->create();
        $barang = Barang::factory()->create();
        $lelang = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_user' => $pemenang->id_user,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'ditutup',
            'status_konfirmasi' => 'dikonfirmasi',
            'harga_akhir' => 1000000,
        ]);

        $file = UploadedFile::fake()->image('bukti.jpg');

        $response = $this->actingAsMasyarakat($nonPemenang)
            ->post(route('masyarakat.bukti_bayar.upload', $lelang->id_lelang), [
                'bukti_pembayaran' => $file,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_upload_hanya_bisa_setelah_konfirmasi()
    {
        Storage::fake('public');
        $petugas = Petugas::factory()->create();
        $pemenang = Masyarakat::factory()->create();
        $barang = Barang::factory()->create();
        $lelang = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_user' => $pemenang->id_user,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'ditutup',
            'status_konfirmasi' => 'menunggu_konfirmasi',
            'harga_akhir' => 1000000,
        ]);

        $file = UploadedFile::fake()->image('bukti.jpg');

        $response = $this->actingAsMasyarakat($pemenang)
            ->post(route('masyarakat.bukti_bayar.upload', $lelang->id_lelang), [
                'bukti_pembayaran' => $file,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_admin_dapat_verifikasi_bukti_pembayaran()
    {
        Storage::fake('public');
        $admin = Petugas::factory()->create(['id_level' => 1]); // 1 = administrator
        $pemenang = Masyarakat::factory()->create();
        $barang = Barang::factory()->create();
        $lelang = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_user' => $pemenang->id_user,
            'id_petugas' => $admin->id_petugas,
            'status' => 'ditutup',
            'status_konfirmasi' => 'dikonfirmasi',
            'harga_akhir' => 1000000,
            'bukti_pembayaran' => 'test_bukti.jpg',
        ]);

        Storage::disk('public')->put('bukti_bayar/test_bukti.jpg', 'test');

        $response = $this->actingAsPetugas($admin)
            ->post(route('administrator.bukti_bayar.verifikasi', $lelang->id_lelang), [
                'status' => 'dibayar',
                'catatan' => 'Bukti pembayaran valid',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $lelang->refresh();
        $this->assertEquals('dibayar', $lelang->status_konfirmasi);
    }

    public function test_admin_dapat_tolak_bukti_pembayaran()
    {
        Storage::fake('public');
        $admin = Petugas::factory()->create(['id_level' => 1]); // 1 = administrator
        $pemenang = Masyarakat::factory()->create();
        $barang = Barang::factory()->create();
        $lelang = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_user' => $pemenang->id_user,
            'id_petugas' => $admin->id_petugas,
            'status' => 'ditutup',
            'status_konfirmasi' => 'dikonfirmasi',
            'harga_akhir' => 1000000,
            'bukti_pembayaran' => 'test_bukti.jpg',
        ]);

        Storage::disk('public')->put('bukti_bayar/test_bukti.jpg', 'test');

        $response = $this->actingAsPetugas($admin)
            ->post(route('administrator.bukti_bayar.verifikasi', $lelang->id_lelang), [
                'status' => 'ditolak',
                'catatan' => 'Bukti tidak jelas',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $lelang->refresh();
        $this->assertNull($lelang->bukti_pembayaran);
        $this->assertNull($lelang->tanggal_bayar);
        Storage::disk('public')->assertMissing('bukti_bayar/test_bukti.jpg');
    }
}
