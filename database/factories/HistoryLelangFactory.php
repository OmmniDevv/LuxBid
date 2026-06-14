<?php

namespace Database\Factories;

use App\Models\HistoryLelang;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryLelangFactory extends Factory
{
    protected $model = HistoryLelang::class;

    public function definition(): array
    {
        return [
            'penawaran_harga' => $this->faker->numberBetween(101000, 1000000),
            // id_lelang, id_barang, id_user wajib diisi oleh caller
        ];
    }
}
