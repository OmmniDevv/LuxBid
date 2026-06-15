<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed categories first
        $this->call(KategoriSeeder::class);

        DB::table('tb_level')->insertOrIgnore([
            ['id_level' => 1, 'level' => 'administrator'],
            ['id_level' => 2, 'level' => 'petugas'],
        ]);

        DB::table('tb_petugas')->insertOrIgnore([
            ['id_petugas' => 1, 'nama_petugas' => 'Administrator', 'username' => 'admin', 'password' => Hash::make('admin'), 'id_level' => 1],
            ['id_petugas' => 2, 'nama_petugas' => 'Petugas', 'username' => 'petugas', 'password' => Hash::make('petugas'), 'id_level' => 2],
        ]);

        DB::table('tb_masyarakat')->insertOrIgnore([
            [
                'id_user' => 1,
                'nama_lengkap' => 'abdul',
                'username' => 'omnidev',
                'password' => '$2y$12$f0bRHXUr5PfQzMTyXDup2eVKcOBAlavLOWn.XldWq.OU2pSHPJVEq',
                'telp' => '085187605007',
                'email' => null,
                'reset_token' => null,
                'reset_expires' => null,
            ],
        ]);

        DB::table('tb_barang')->insertOrIgnore([
            [
                'id_barang' => 1,
                'nama_barang' => 'FUJIFILM FINEPIX S4500',
                'tgl' => '2026-04-05',
                'harga_awal' => 1000000,
                'deskripsi_barang' => 'Fujifilm FinePix S4500 adalah kamera prosumer/superzoom 14MP.',
            ],
            [
                'id_barang' => 2,
                'nama_barang' => 'Canon PowerShot G7 X Mark III',
                'tgl' => '2026-04-05',
                'harga_awal' => 10000000,
                'deskripsi_barang' => 'The Canon PowerShot G7 X Mark III is a popular, compact 20.1MP camera.',
            ],
        ]);

        DB::table('tb_gambar_barang')->insertOrIgnore([
            ['id_gambar' => 1, 'id_barang' => 1, 'nama_file' => 'barang_1_1_1775355202.jpg', 'urutan' => 1],
            ['id_gambar' => 2, 'id_barang' => 1, 'nama_file' => 'barang_1_2_1775355202.jpg', 'urutan' => 2],
            ['id_gambar' => 3, 'id_barang' => 1, 'nama_file' => 'barang_1_3_1775355202.jpg', 'urutan' => 3],
            ['id_gambar' => 4, 'id_barang' => 2, 'nama_file' => 'barang_2_1_1775355819.jpg', 'urutan' => 1],
            ['id_gambar' => 5, 'id_barang' => 2, 'nama_file' => 'barang_2_2_1775355819.jpg', 'urutan' => 2],
            ['id_gambar' => 6, 'id_barang' => 2, 'nama_file' => 'barang_2_3_1775355819.jpg', 'urutan' => 3],
        ]);

        DB::table('tb_lelang')->insertOrIgnore([
            [
                'id_lelang' => 1,
                'id_barang' => 1,
                'tgl_lelang' => '2026-04-05',
                'harga_akhir' => 2000000,
                'id_user' => 1,
                'id_petugas' => 2,
                'status' => 'ditutup',
            ],
        ]);

        DB::table('history_lelang')->insertOrIgnore([
            ['id_history' => 1, 'id_lelang' => 1, 'id_barang' => 1, 'id_user' => 1, 'penawaran_harga' => 2000000],
        ]);
    }
}
