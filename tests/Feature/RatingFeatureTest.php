<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingFeatureTest extends TestCase
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

    public function test_pemenang_dapat_memberikan_rating_setelah_dikonfirmasi()
    {
        $petugas = \App\Models\Petugas::factory()->create();
        $pemenang = Masyarakat::factory()->create(['username' => 'testuser']);
        $barang = Barang::factory()->create();
        $lelang = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_user' => $pemenang->id_user,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'ditutup',
            'status_konfirmasi' => 'dikonfirmasi',
            'harga_akhir' => 1000000,
        ]);

        $response = $this->actingAsMasyarakat($pemenang)
            ->post(route('masyarakat.rating.store', $lelang->id_lelang), [
                'rating' => 5,
                'komentar' => 'Sangat puas dengan lelang ini!',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('ratings', [
            'id_lelang' => $lelang->id_lelang,
            'id_user' => $pemenang->id_user,
            'rating' => 5,
            'komentar' => 'Sangat puas dengan lelang ini!',
        ]);
    }

    public function test_pemenang_dapat_memberikan_rating_tanpa_komentar()
    {
        $petugas = \App\Models\Petugas::factory()->create();
        $pemenang = Masyarakat::factory()->create();
        $barang = Barang::factory()->create();
        $lelang = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_user' => $pemenang->id_user,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'ditutup',
            'status_konfirmasi' => 'selesai',
            'harga_akhir' => 1000000,
        ]);

        $response = $this->actingAsMasyarakat($pemenang)
            ->post(route('masyarakat.rating.store', $lelang->id_lelang), [
                'rating' => 4,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('ratings', [
            'id_lelang' => $lelang->id_lelang,
            'id_user' => $pemenang->id_user,
            'rating' => 4,
            'komentar' => null,
        ]);
    }

    public function test_non_pemenang_tidak_dapat_memberikan_rating()
    {
        $petugas = \App\Models\Petugas::factory()->create();
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

        $response = $this->actingAsMasyarakat($nonPemenang)
            ->post(route('masyarakat.rating.store', $lelang->id_lelang), [
                'rating' => 5,
                'komentar' => 'Test',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('ratings', [
            'id_lelang' => $lelang->id_lelang,
            'id_user' => $nonPemenang->id_user,
        ]);
    }

    public function test_rating_hanya_bisa_diberikan_setelah_konfirmasi()
    {
        $petugas = \App\Models\Petugas::factory()->create();
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

        $response = $this->actingAsMasyarakat($pemenang)
            ->post(route('masyarakat.rating.store', $lelang->id_lelang), [
                'rating' => 5,
                'komentar' => 'Test',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('ratings', [
            'id_lelang' => $lelang->id_lelang,
        ]);
    }

    public function test_pemenang_tidak_dapat_memberikan_rating_dua_kali()
    {
        $petugas = \App\Models\Petugas::factory()->create();
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

        Rating::create([
            'id_lelang' => $lelang->id_lelang,
            'id_user' => $pemenang->id_user,
            'rating' => 5,
            'komentar' => 'Rating pertama',
        ]);

        $response = $this->actingAsMasyarakat($pemenang)
            ->post(route('masyarakat.rating.store', $lelang->id_lelang), [
                'rating' => 4,
                'komentar' => 'Rating kedua',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertEquals(1, Rating::where('id_lelang', $lelang->id_lelang)->count());
    }

    public function test_validasi_rating_harus_antara_1_sampai_5()
    {
        $petugas = \App\Models\Petugas::factory()->create();
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

        $response = $this->actingAsMasyarakat($pemenang)
            ->post(route('masyarakat.rating.store', $lelang->id_lelang), [
                'rating' => 6,
            ]);

        $response->assertSessionHasErrors('rating');

        $response = $this->actingAsMasyarakat($pemenang)
            ->post(route('masyarakat.rating.store', $lelang->id_lelang), [
                'rating' => 0,
            ]);

        $response->assertSessionHasErrors('rating');
    }

    public function test_rating_ditampilkan_di_detail_barang()
    {
        $petugas = \App\Models\Petugas::factory()->create();
        $pemenang1 = Masyarakat::factory()->create(['nama_lengkap' => 'User Satu']);
        $pemenang2 = Masyarakat::factory()->create(['nama_lengkap' => 'User Dua']);
        $barang = Barang::factory()->create(['nama_barang' => 'Barang Test Rating']);

        $lelang1 = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_user' => $pemenang1->id_user,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'ditutup',
            'status_konfirmasi' => 'selesai',
        ]);

        $lelang2 = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_user' => $pemenang2->id_user,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'dibuka',
        ]);

        Rating::create([
            'id_lelang' => $lelang1->id_lelang,
            'id_user' => $pemenang1->id_user,
            'rating' => 5,
            'komentar' => 'Sangat bagus',
        ]);

        Rating::create([
            'id_lelang' => $lelang1->id_lelang,
            'id_user' => $pemenang2->id_user,
            'rating' => 4,
            'komentar' => 'Memuaskan',
        ]);

        $response = $this->actingAsMasyarakat($pemenang1)
            ->get(route('masyarakat.penawaran'));

        $response->assertStatus(200);
        $response->assertSee('Barang Test Rating');
    }
}
