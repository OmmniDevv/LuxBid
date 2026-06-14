<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        $petugasList = DB::table('tb_petugas')->select('id_petugas', 'password')->get();

        foreach ($petugasList as $petugas) {
            // Deteksi: bcrypt hash selalu diawali $2y$ dan panjang 60 karakter
            $isAlreadyHashed = str_starts_with($petugas->password, '$2y$')
                || str_starts_with($petugas->password, '$argon2');

            if (!$isAlreadyHashed) {
                DB::table('tb_petugas')
                    ->where('id_petugas', $petugas->id_petugas)
                    ->update(['password' => Hash::make($petugas->password)]);
            }
        }
    }

    public function down(): void
    {
        // Tidak bisa di-reverse: hash tidak bisa di-unhash.
        // Jika rollback diperlukan, restore dari backup database.
    }
};
