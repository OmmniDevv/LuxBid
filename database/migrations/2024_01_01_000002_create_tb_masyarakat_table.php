<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tb_masyarakat', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_lengkap', 25);
            $table->string('username', 25)->unique();
            $table->string('password', 255);
            $table->string('telp', 25);
            $table->string('email', 100)->nullable();
            $table->string('reset_token', 100)->nullable();
            $table->dateTime('reset_expires')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_masyarakat');
    }
};
