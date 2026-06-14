<?php

namespace Tests\Unit;

use App\Models\Barang;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\Petugas;
use App\Services\LelangService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LelangServiceTest extends TestCase
{
    use RefreshDatabase;

    private int $userId;

    protected function setUp(): void
    {
        parent::setUp();
        \DB::table('tb_level')->insertOrIgnore(['id_level' => 2, 'level' => 'petugas']);
        $user = Masyarakat::create([
            'nama_lengkap' => 'T', 'username' => 'tuser',
            'password'     => Hash::make('x'), 'telp' => '081234567890',
            'email_verified_at' => now(),
        ]);
        $this->userId = $user->id_user;
    }

    private function makeLelang(int $harga_awal = 1000000): Lelang
    {
        $petugas = Petugas::firstOrCreate(['username' => 'p_test'], [
            'nama_petugas' => 'P', 'password' => 'x', 'id_level' => 2,
        ]);
        $barang = Barang::create([
            'nama_barang' => 'Test', 'tgl' => now()->toDateString(),
            'harga_awal'  => $harga_awal, 'deskripsi_barang' => '',
        ]);
        return Lelang::create([
            'id_barang'   => $barang->id_barang,
            'tgl_lelang'  => now()->toDateString(),
            'harga_akhir' => 0, 'id_user' => 0,
            'id_petugas'  => $petugas->id_petugas,
            'status'      => 'dibuka',
            'timer_end'   => now()->addMinutes(6),
        ]);
    }

    public function test_bid_throws_when_below_minimum(): void
    {
        Mail::fake();
        $lelang  = $this->makeLelang();
        $service = new LelangService();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('min_bid');

        $service->bid($lelang, $this->userId, $lelang->id_barang, 500);
    }

    public function test_bid_throws_when_above_maximum(): void
    {
        Mail::fake();
        $lelang  = $this->makeLelang(1000000);
        $service = new LelangService();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('max_bid');

        $service->bid($lelang, $this->userId, $lelang->id_barang, 20_000_001);
    }

    public function test_bid_succeeds_and_resets_timer(): void
    {
        Mail::fake();
        $lelang  = $this->makeLelang();
        $service = new LelangService();

        $history = $service->bid($lelang, $this->userId, $lelang->id_barang, 1_001_000);

        $this->assertEquals(1_001_000, $history->penawaran_harga);
        $this->assertDatabaseHas('history_lelang', ['penawaran_harga' => 1_001_000]);
        $this->assertTrue($lelang->fresh()->timer_end->isAfter(now()));
    }

    public function test_auto_close_sets_status_ditutup(): void
    {
        $lelang  = $this->makeLelang();
        $service = new LelangService();
        $service->autoClose($lelang);

        $this->assertEquals('ditutup', $lelang->fresh()->status);
    }

    public function test_second_bid_must_exceed_previous_by_1000(): void
    {
        Mail::fake();
        $lelang  = $this->makeLelang();
        $service = new LelangService();

        $service->bid($lelang, $this->userId, $lelang->id_barang, 1_001_000);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('min_bid');

        // 1_001_000 + 999 < required minimum (+1000)
        $service->bid($lelang, $this->userId, $lelang->id_barang, 1_001_999);
    }
}
