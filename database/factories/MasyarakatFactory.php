<?php

namespace Database\Factories;

use App\Models\Masyarakat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class MasyarakatFactory extends Factory
{
    protected $model = Masyarakat::class;

    public function definition(): array
    {
        return [
            'nama_lengkap'      => $this->faker->name(),
            'username'          => $this->faker->unique()->userName(),
            'password'          => Hash::make('password'),
            'telp'              => '08' . $this->faker->numerify('#########'),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
        ];
    }
}
