<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->string('nama_barang', 100);
            $table->date('tgl');
            $table->integer('harga_awal');
            $table->text('deskripsi_barang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_barang');
    }
};
