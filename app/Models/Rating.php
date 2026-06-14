<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
    protected $primaryKey = 'id_rating';
    public $timestamps = false;

    protected $fillable = ['id_lelang', 'id_user', 'rating', 'komentar'];
    protected $casts = ['created_at' => 'datetime', 'rating' => 'integer'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->created_at) {
                $model->created_at = now();
            }
        });
    }

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'id_lelang', 'id_lelang');
    }

    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'id_user', 'id_user');
    }
}
