<?php

namespace Database\Seeders;

use App\Models\MaintenanceLog;
use App\Models\Ship;
use Illuminate\Database\Seeder;

class MaintenanceLogSeeder extends Seeder
{
    public function run(): void
    {
        $shipIds = Ship::pluck('id')->toArray();
        $statuses = ['planned', 'ongoing', 'completed'];
        $records = [];

        for ($i = 0; $i < 550; $i++) {
            $records[] = [
                'ship_id'        => $shipIds[array_rand($shipIds)],
                'tanggal_servis' => now()->subDays(rand(0, 730))->addDays(rand(0, 180))->format('Y-m-d'),
                'jenis_servis'   => MaintenanceLog::JENIS_SERVIS[array_rand(MaintenanceLog::JENIS_SERVIS)],
                'biaya'          => rand(500000, 50000000),
                'status'         => $statuses[array_rand($statuses)],
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        foreach (array_chunk($records, 100) as $chunk) {
            MaintenanceLog::insert($chunk);
        }
    }
}
