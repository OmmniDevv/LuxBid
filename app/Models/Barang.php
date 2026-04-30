<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'tb_barang';
    protected $primaryKey = 'id_barang';
    public $timestamps = false;

    protected $fillable = ['nama_barang', 'tgl', 'harga_awal', 'deskripsi_barang'];

    public function gambar()
    {
        return $this->hasMany(GambarBarang::class, 'id_barang', 'id_barang')->orderBy('urutan');
    }

    public function gambarUtama()
    {
        return $this->hasOne(GambarBarang::class, 'id_barang', 'id_barang')->where('urutan', 1);
    }

    public function lelang()
    {
        return $this->hasMany(Lelang::class, 'id_barang', 'id_barang');
    }
}
