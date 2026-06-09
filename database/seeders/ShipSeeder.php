<?php

namespace Database\Seeders;

use App\Models\Ship;
use Illuminate\Database\Seeder;

class ShipSeeder extends Seeder
{
    public function run(): void
    {
        Ship::factory(60)->create();
    }
}
