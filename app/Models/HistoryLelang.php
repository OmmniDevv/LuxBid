<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryLelang extends Model
{
    use HasFactory;

    protected $table = 'history_lelang';
    protected $primaryKey = 'id_history';
    public $timestamps = false;

    protected $fillable = ['id_lelang', 'id_barang', 'id_user', 'penawaran_harga'];

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'id_lelang', 'id_lelang');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'id_user', 'id_user');
    }
}
