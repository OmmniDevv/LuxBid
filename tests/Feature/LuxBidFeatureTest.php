<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\HistoryLelang;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\Petugas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LuxBidFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class,
        ]);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function makeMasyarakat(array $attrs = []): Masyarakat
    {
        return Masyarakat::create(array_merge([
            'nama_lengkap'      => 'Test User',
            'username'          => 'testuser',
            'password'          => Hash::make('password123'),
            'telp'              => '081234567890',
            'email'             => 'test@example.com',
            'email_verified_at' => now(),
        ], $attrs));
    }

    private function loginMasyarakat(Masyarakat $user): void
    {
        session(['id_user' => $user->id_user, 'username' => $user->username, 'status' => 'login']);
    }

    private function makePetugas(array $attrs = []): Petugas
    {
        // Pastikan level ada dulu
        \DB::table('tb_level')->insertOrIgnore(['id_level' => 2, 'level' => 'petugas']);
        return Petugas::create(array_merge([
            'nama_petugas' => 'Petugas Test',
            'username'     => 'petugas_test',
            'password'     => Hash::make('petugas123'),
            'id_level'     => 2,
        ], $attrs));
    }

    private function makeLelangAktif(): array
    {
        $petugas = $this->makePetugas();
        $barang  = Barang::create([
            'nama_barang'      => 'Barang Test',
            'tgl'              => now()->toDateString(),
            'harga_awal'       => 1000000,
            'deskripsi_barang' => '',
        ]);
        $lelang = Lelang::create([
            'id_barang'   => $barang->id_barang,
            'tgl_lelang'  => now()->toDateString(),
            'harga_akhir' => 0,
            'id_user'     => 0,
            'id_petugas'  => $petugas->id_petugas,
            'status'      => 'dibuka',
            'timer_end'   => now()->addMinutes(6),
        ]);
        return [$barang, $lelang];
    }

    // ── Auth Masyarakat ───────────────────────────────────────────────────────

    public function test_masyarakat_can_login_with_correct_credentials(): void
    {
        $user = $this->makeMasyarakat();

        $response = $this->post(route('login.masyarakat.post'), [
            'username' => 'testuser',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('masyarakat.index'));
        $this->assertEquals('login', session('status'));
    }

    public function test_masyarakat_login_fails_with_wrong_password(): void
    {
        $this->makeMasyarakat();

        $response = $this->post(route('login.masyarakat.post'), [
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect();
        $this->assertNotEquals('login', session('status'));
    }

    public function test_masyarakat_register_creates_user_and_sends_verification(): void
    {
        Mail::fake();

        $response = $this->post(route('daftar.masyarakat.post'), [
            'nama_lengkap' => 'New User',
            'username'     => 'newuser',
            'password'     => 'password123',
            'telp'         => '081234567891',
            'email'        => 'newuser@example.com',
        ]);

        $response->assertRedirect(route('daftar.verifikasi'));
        $this->assertDatabaseHas('tb_masyarakat', ['username' => 'newuser']);
        $this->assertNotNull(session('verif_id_user'));
    }

    // ── Email Verification ────────────────────────────────────────────────────

    public function test_email_verification_succeeds_with_correct_code(): void
    {
        Mail::fake();
        $user = $this->makeMasyarakat([
            'email_verified_at'       => null,
            'email_verification_code' => '123456',
        ]);
        session(['verif_id_user' => $user->id_user]);

        $response = $this->post(route('daftar.verifikasi.post'), ['kode' => '123456']);

        $response->assertRedirect();
        $this->assertStringContainsString('/login', $response->headers->get('Location'));
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_email_verification_fails_with_wrong_code(): void
    {
        $user = $this->makeMasyarakat([
            'email_verified_at'       => null,
            'email_verification_code' => '123456',
        ]);
        session(['verif_id_user' => $user->id_user]);

        $response = $this->post(route('daftar.verifikasi.post'), ['kode' => '999999']);

        $response->assertSessionHas('error');
        $this->assertNull($user->fresh()->email_verified_at);
    }

    // ── Password Reset ────────────────────────────────────────────────────────

    public function test_password_reset_step1_sends_code(): void
    {
        Mail::fake();
        $this->makeMasyarakat();

        $response = $this->post(route('lupa.password.step1'), [
            'username' => 'testuser',
            'email'    => 'test@example.com',
        ]);

        $response->assertRedirect(route('lupa.password.verifikasi'));
        $this->assertNotNull(session('reset_code'));
    }

    public function test_password_reset_verifikasi_with_correct_code(): void
    {
        $user = $this->makeMasyarakat();
        session([
            'reset_code'        => '654321',
            'reset_code_expiry' => now()->addMinutes(10)->timestamp,
            'reset_id_user'     => $user->id_user,
        ]);

        $response = $this->post(route('lupa.password.verifikasi.post'), ['kode' => '654321']);

        $response->assertRedirect(route('lupa.password.selesai'));
        $this->assertTrue(session('reset_verified'));
    }

    // ── Petugas Auth ──────────────────────────────────────────────────────────

    public function test_petugas_can_login_with_hashed_password(): void
    {
        $petugas = $this->makePetugas();

        $response = $this->post(route('login.petugas.post'), [
            'username' => 'petugas_test',
            'password' => 'petugas123',
        ]);

        $response->assertRedirect(route('petugas.index'));
        $this->assertEquals($petugas->id_petugas, session('id_petugas'));
    }

    public function test_petugas_login_fails_with_wrong_password(): void
    {
        $this->makePetugas();

        $this->post(route('login.petugas.post'), [
            'username' => 'petugas_test',
            'password' => 'wrongpassword',
        ]);

        $this->assertNull(session('id_petugas'));
    }

    // ── Bid / Penawaran ───────────────────────────────────────────────────────

    public function test_masyarakat_can_submit_bid_above_minimum(): void
    {
        $user = $this->makeMasyarakat();
        $this->loginMasyarakat($user);
        [, $lelang] = $this->makeLelangAktif();

        $this->post(route('masyarakat.penawaran.simpan'), [
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $lelang->id_barang,
            'id_user'         => $user->id_user,
            'penawaran_harga' => 1001000,
        ]);

        $this->assertDatabaseHas('history_lelang', ['penawaran_harga' => 1001000]);
    }

    public function test_bid_rejected_when_below_minimum(): void
    {
        $user = $this->makeMasyarakat();
        $this->loginMasyarakat($user);
        [, $lelang] = $this->makeLelangAktif();

        $response = $this->post(route('masyarakat.penawaran.simpan'), [
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $lelang->id_barang,
            'id_user'         => $user->id_user,
            'penawaran_harga' => 500,
        ]);

        $response->assertRedirect(route('masyarakat.penawaran', ['info' => 'min_bid']));
        $this->assertDatabaseMissing('history_lelang', ['penawaran_harga' => 500]);
    }

    public function test_bid_rejected_when_lelang_closed(): void
    {
        $user = $this->makeMasyarakat();
        $this->loginMasyarakat($user);
        [, $lelang] = $this->makeLelangAktif();
        $lelang->update(['status' => 'ditutup']);

        $response = $this->post(route('masyarakat.penawaran.simpan'), [
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $lelang->id_barang,
            'id_user'         => $user->id_user,
            'penawaran_harga' => 1001000,
        ]);

        $response->assertRedirect(route('masyarakat.penawaran', ['info' => 'ditutup']));
    }
}
