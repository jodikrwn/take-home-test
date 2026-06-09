<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShipFactory extends Factory
{
    public function definition(): array
    {
        static $counter = 1;

        return [
            'nama'             => 'KM ' . $this->faker->unique()->word() . ' ' . $this->faker->word(),
            'kode_kapal'       => 'KM-' . str_pad($counter++, 3, '0', STR_PAD_LEFT),
            'tahun_pembuatan'  => $this->faker->numberBetween(1990, 2023),
        ];
    }
}
