<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_barang', function (Blueprint $table) {
            $table->unsignedInteger('id_kategori')->nullable()->after('nama_penjual');
            $table->foreign('id_kategori')->references('id_kategori')->on('tb_kategori')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tb_barang', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->dropColumn('id_kategori');
        });
    }
};
