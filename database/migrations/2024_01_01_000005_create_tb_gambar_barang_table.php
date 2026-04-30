<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tb_gambar_barang', function (Blueprint $table) {
            $table->id('id_gambar');
            $table->unsignedBigInteger('id_barang');
            $table->string('nama_file', 255);
            $table->tinyInteger('urutan')->default(1)->comment('1=utama, 2=kedua, 3=ketiga');
            $table->foreign('id_barang')->references('id_barang')->on('tb_barang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_gambar_barang');
    }
};
