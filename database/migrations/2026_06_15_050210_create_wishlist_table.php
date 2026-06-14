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
        Schema::create('wishlist', function (Blueprint $table) {
            $table->id('id_wishlist');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_barang');
            $table->boolean('notif_h1_terkirim')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['id_user', 'id_barang']);
            $table->foreign('id_user')->references('id_user')->on('tb_masyarakat')->onDelete('cascade');
            $table->foreign('id_barang')->references('id_barang')->on('tb_barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlist');
    }
};
