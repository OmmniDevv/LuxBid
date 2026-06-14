<?php

namespace Database\Factories;

use App\Models\Petugas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PetugasFactory extends Factory
{
    protected $model = Petugas::class;

    public function definition(): array
    {
        // Pastikan level rows ada sebelum create Petugas (FK constraint)
        DB::table('tb_level')->insertOrIgnore([
            ['id_level' => 1, 'level' => 'administrator'],
            ['id_level' => 2, 'level' => 'petugas'],
        ]);

        return [
            'nama_petugas' => $this->faker->name(),
            'username'     => $this->faker->unique()->userName(),
            'password'     => Hash::make('password'),
            'id_level'     => 2,
        ];
    }

    public function admin(): static
    {
        return $this->state(['id_level' => 1]);
    }
}
