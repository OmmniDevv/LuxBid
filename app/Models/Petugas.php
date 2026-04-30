<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    protected $table = 'tb_petugas';
    protected $primaryKey = 'id_petugas';
    public $timestamps = false;

    protected $fillable = ['nama_petugas', 'username', 'password', 'id_level'];
    protected $hidden = ['password'];

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }

    public function lelang()
    {
        return $this->hasMany(Lelang::class, 'id_petugas', 'id_petugas');
    }
}
