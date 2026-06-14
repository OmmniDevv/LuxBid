<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_pemenang_lelang', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->unsignedBigInteger('id_lelang');
            $table->unsignedBigInteger('id_user');
            $table->unsignedTinyInteger('urutan')->default(1);
            $table->enum('status', ['aktif', 'dibatalkan', 'dikonfirmasi'])->default('aktif');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_lelang')->references('id_lelang')->on('tb_lelang')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('tb_masyarakat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pemenang_lelang');
    }
};
