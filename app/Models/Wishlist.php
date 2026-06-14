<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlist';
    protected $primaryKey = 'id_wishlist';
    public $timestamps = false;

    protected $fillable = ['id_user', 'id_barang', 'notif_h1_terkirim'];
    protected $casts = ['notif_h1_terkirim' => 'boolean', 'created_at' => 'datetime'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'id_user', 'id_user');
    }
}
