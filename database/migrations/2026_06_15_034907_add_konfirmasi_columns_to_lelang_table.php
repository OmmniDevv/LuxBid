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
        Schema::table('tb_lelang', function (Blueprint $table) {
            $table->string('status_konfirmasi', 50)->default('menunggu_konfirmasi')->after('status');
            $table->timestamp('tanggal_konfirmasi')->nullable()->after('status_konfirmasi');
            $table->text('catatan_admin')->nullable()->after('tanggal_konfirmasi');
            $table->string('nomor_faktur', 50)->nullable()->after('catatan_admin');
            $table->timestamp('batas_konfirmasi')->nullable()->after('nomor_faktur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_lelang', function (Blueprint $table) {
            $table->dropColumn(['status_konfirmasi', 'tanggal_konfirmasi', 'catatan_admin', 'nomor_faktur', 'batas_konfirmasi']);
        });
    }
};
