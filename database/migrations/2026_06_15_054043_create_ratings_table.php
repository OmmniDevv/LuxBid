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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id('id_rating');
            $table->unsignedBigInteger('id_lelang');
            $table->unsignedBigInteger('id_user');
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('komentar')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['id_lelang', 'id_user']);
            $table->foreign('id_lelang')->references('id_lelang')->on('tb_lelang')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('tb_masyarakat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
