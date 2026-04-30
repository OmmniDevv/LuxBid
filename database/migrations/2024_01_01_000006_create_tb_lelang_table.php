<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tb_lelang', function (Blueprint $table) {
            $table->id('id_lelang');
            $table->unsignedBigInteger('id_barang');
            $table->date('tgl_lelang');
            $table->integer('harga_akhir')->default(0);
            $table->unsignedBigInteger('id_user')->default(0);
            $table->unsignedBigInteger('id_petugas');
            $table->enum('status', ['dibuka', 'ditutup']);
            $table->dateTime('timer_end')->nullable();
            $table->foreign('id_barang')->references('id_barang')->on('tb_barang');
            $table->foreign('id_petugas')->references('id_petugas')->on('tb_petugas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_lelang');
    }
};
