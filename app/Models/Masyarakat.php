<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Masyarakat extends Authenticatable
{
    protected $table = 'tb_masyarakat';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = ['nama_lengkap', 'username', 'password', 'telp', 'email', 'foto', 'reset_token', 'reset_expires'];
    protected $hidden = ['password'];

    public function historyLelang()
    {
        return $this->hasMany(HistoryLelang::class, 'id_user', 'id_user');
    }
}
