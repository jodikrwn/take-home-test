<?php

namespace App\Repositories\Contracts;

use App\Models\MaintenanceLog;

interface MaintenanceLogRepositoryInterface
{
    public function updateStatus(MaintenanceLog $log, string $status): MaintenanceLog;

    public function create(array $data): MaintenanceLog;
}
