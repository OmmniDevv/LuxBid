<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Masyarakat extends Authenticatable
{
    use HasFactory;

    protected $table = 'tb_masyarakat';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = ['nama_lengkap', 'username', 'password', 'telp', 'email', 'foto', 'email_verification_code', 'email_verified_at'];
    protected $hidden = ['password'];

    public function historyLelang()
    {
        return $this->hasMany(HistoryLelang::class, 'id_user', 'id_user');
    }
}
