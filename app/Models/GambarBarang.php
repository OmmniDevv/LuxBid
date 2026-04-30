<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarBarang extends Model
{
    protected $table = 'tb_gambar_barang';
    protected $primaryKey = 'id_gambar';
    public $timestamps = false;

    protected $fillable = ['id_barang', 'nama_file', 'urutan'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
