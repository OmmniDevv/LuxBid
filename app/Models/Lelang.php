<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lelang extends Model
{
    protected $table = 'tb_lelang';
    protected $primaryKey = 'id_lelang';
    public $timestamps = false;

    protected $fillable = ['id_barang', 'tgl_lelang', 'harga_akhir', 'id_user', 'id_petugas', 'status', 'timer_end'];
    protected $casts = ['timer_end' => 'datetime'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function pemenang()
    {
        return $this->belongsTo(Masyarakat::class, 'id_user', 'id_user');
    }

    public function history()
    {
        return $this->hasMany(HistoryLelang::class, 'id_lelang', 'id_lelang');
    }

    public function penawaran_tertinggi()
    {
        return $this->history()->max('penawaran_harga');
    }
}
