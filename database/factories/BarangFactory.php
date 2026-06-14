<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    protected $model = Barang::class;

    public function definition(): array
    {
        return [
            'nama_barang'      => $this->faker->words(3, true),
            'tgl'              => now()->toDateString(),
            'harga_awal'       => $this->faker->numberBetween(100000, 5000000),
            'deskripsi_barang' => $this->faker->sentence(),
            'nama_penjual'     => $this->faker->name(),
            'id_kategori'      => null,
        ];
    }
}
