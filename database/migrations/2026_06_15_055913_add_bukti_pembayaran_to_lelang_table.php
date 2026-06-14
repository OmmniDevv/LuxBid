<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_lelang', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable()->after('catatan_admin');
            $table->timestamp('tanggal_bayar')->nullable()->after('bukti_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('tb_lelang', function (Blueprint $table) {
            $table->dropColumn(['bukti_pembayaran', 'tanggal_bayar']);
        });
    }
};
