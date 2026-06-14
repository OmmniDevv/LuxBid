<?php

namespace Database\Factories;

use App\Models\Lelang;
use Illuminate\Database\Eloquent\Factories\Factory;

class LelangFactory extends Factory
{
    protected $model = Lelang::class;

    public function definition(): array
    {
        return [
            'tgl_lelang'  => now()->toDateString(),
            'harga_akhir' => 0,
            'id_user'     => 0,
            'status'      => 'dibuka',
            'timer_end'   => now()->addMinutes(6),
            // id_barang dan id_petugas wajib diisi oleh caller
        ];
    }

    public function ditutup(): static
    {
        return $this->state([
            'status'      => 'ditutup',
            'timer_end'   => null,
        ]);
    }
}
