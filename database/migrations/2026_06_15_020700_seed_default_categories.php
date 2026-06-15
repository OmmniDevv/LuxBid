<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $categories = ['Elektronik', 'Furnitur', 'Kendaraan', 'Perhiasan', 'Pakaian', 'Lainnya'];

        foreach ($categories as $nama) {
            DB::table('tb_kategori')->insertOrIgnore([
                'nama_kategori' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('tb_kategori')->whereIn('nama_kategori', [
            'Elektronik', 'Furnitur', 'Kendaraan', 'Perhiasan', 'Pakaian', 'Lainnya'
        ])->delete();
    }
};
