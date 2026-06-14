<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPemenangLelang extends Model
{
    protected $table = 'riwayat_pemenang_lelang';
    protected $primaryKey = 'id_riwayat';
    public $timestamps = false;

    protected $fillable = ['id_lelang', 'id_user', 'urutan', 'status'];
    protected $casts = ['created_at' => 'datetime'];

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'id_lelang', 'id_lelang');
    }

    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'id_user', 'id_user');
    }
}
