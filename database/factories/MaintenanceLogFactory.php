<?php

namespace Database\Factories;

use App\Models\MaintenanceLog;
use App\Models\Ship;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ship_id'        => Ship::factory(),
            'tanggal_servis' => $this->faker->dateTimeBetween('-2 years', '+6 months')->format('Y-m-d'),
            'jenis_servis'   => $this->faker->randomElement(MaintenanceLog::JENIS_SERVIS),
            'biaya'          => $this->faker->numberBetween(500000, 50000000),
            'status'         => $this->faker->randomElement(['planned', 'ongoing', 'completed']),
        ];
    }
}
