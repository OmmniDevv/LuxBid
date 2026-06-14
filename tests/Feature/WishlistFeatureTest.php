<?php

namespace Tests\Feature;

use App\Mail\LelangAkanDitutupMail;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\Petugas;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class WishlistFeatureTest extends TestCase
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

    public function test_user_dapat_toggle_add_wishlist()
    {
        $masyarakat = Masyarakat::factory()->create();
        $barang = Barang::factory()->create();

        $response = $this->withSession($this->sessionMasyarakat($masyarakat))
            ->post(route('masyarakat.wishlist.toggle', $barang->id_barang));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('wishlist', [
            'id_user' => $masyarakat->id_user,
            'id_barang' => $barang->id_barang,
        ]);
    }

    public function test_user_dapat_toggle_remove_wishlist()
    {
        $masyarakat = Masyarakat::factory()->create();
        $barang = Barang::factory()->create();

        Wishlist::create([
            'id_user' => $masyarakat->id_user,
            'id_barang' => $barang->id_barang,
        ]);

        $response = $this->withSession($this->sessionMasyarakat($masyarakat))
            ->post(route('masyarakat.wishlist.toggle', $barang->id_barang));

        $response->assertRedirect();

        $this->assertDatabaseMissing('wishlist', [
            'id_user' => $masyarakat->id_user,
            'id_barang' => $barang->id_barang,
        ]);
    }

    public function test_halaman_wishlist_menampilkan_barang_favorit()
    {
        $masyarakat = Masyarakat::factory()->create();
        $barang1 = Barang::factory()->create(['nama_barang' => 'Laptop Dell']);
        $barang2 = Barang::factory()->create(['nama_barang' => 'iPhone 15']);

        Wishlist::create(['id_user' => $masyarakat->id_user, 'id_barang' => $barang1->id_barang]);
        Wishlist::create(['id_user' => $masyarakat->id_user, 'id_barang' => $barang2->id_barang]);

        $response = $this->withSession($this->sessionMasyarakat($masyarakat))
            ->get(route('masyarakat.wishlist'));

        $response->assertOk();
        $response->assertSee('Laptop Dell');
        $response->assertSee('iPhone 15');
    }

    public function test_command_notifikasi_kirim_email_untuk_lelang_akan_ditutup()
    {
        Mail::fake();

        $petugas = Petugas::factory()->create();
        $barang = Barang::factory()->create(['nama_barang' => 'Macbook Pro']);
        $masyarakat = Masyarakat::factory()->create(['email' => 'user@test.com']);

        $lelang = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'dibuka',
            'timer_end' => now()->addMinutes(30),
        ]);

        Wishlist::create([
            'id_user' => $masyarakat->id_user,
            'id_barang' => $barang->id_barang,
            'notif_h1_terkirim' => false,
        ]);

        Artisan::call('lelang:notifikasi-akan-ditutup');

        Mail::assertQueued(LelangAkanDitutupMail::class, fn($m) => $m->hasTo('user@test.com'));

        $wishlist = Wishlist::where('id_user', $masyarakat->id_user)->first();
        $this->assertTrue($wishlist->notif_h1_terkirim);
    }

    public function test_command_tidak_kirim_notifikasi_dua_kali()
    {
        Mail::fake();

        $petugas = Petugas::factory()->create();
        $barang = Barang::factory()->create();
        $masyarakat = Masyarakat::factory()->create(['email' => 'user@test.com']);

        $lelang = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'dibuka',
            'timer_end' => now()->addMinutes(30),
        ]);

        Wishlist::create([
            'id_user' => $masyarakat->id_user,
            'id_barang' => $barang->id_barang,
            'notif_h1_terkirim' => true,
        ]);

        Artisan::call('lelang:notifikasi-akan-ditutup');

        Mail::assertNothingQueued();
    }

    public function test_command_tidak_kirim_untuk_lelang_lebih_dari_1_jam()
    {
        Mail::fake();

        $petugas = Petugas::factory()->create();
        $barang = Barang::factory()->create();
        $masyarakat = Masyarakat::factory()->create(['email' => 'user@test.com']);

        $lelang = Lelang::factory()->create([
            'id_barang' => $barang->id_barang,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'dibuka',
            'timer_end' => now()->addHours(2),
        ]);

        Wishlist::create([
            'id_user' => $masyarakat->id_user,
            'id_barang' => $barang->id_barang,
        ]);

        Artisan::call('lelang:notifikasi-akan-ditutup');

        Mail::assertNothingQueued();
    }

    public function test_wishlist_unique_per_user_dan_barang()
    {
        $masyarakat = Masyarakat::factory()->create();
        $barang = Barang::factory()->create();

        Wishlist::create([
            'id_user' => $masyarakat->id_user,
            'id_barang' => $barang->id_barang,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Wishlist::create([
            'id_user' => $masyarakat->id_user,
            'id_barang' => $barang->id_barang,
        ]);
    }
}
