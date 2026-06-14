<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'tb_kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = ['nama_kategori', 'deskripsi'];

    protected static function booted(): void
    {
        $flush = fn() => Cache::forget('kategori.all');
        static::created($flush);
        static::updated($flush);
        static::deleted($flush);
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }
}
