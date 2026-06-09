<?php

namespace App\Repositories;

use App\Models\MaintenanceLog;
use App\Repositories\Contracts\MaintenanceLogRepositoryInterface;

class MaintenanceLogRepository implements MaintenanceLogRepositoryInterface
{
    public function updateStatus(MaintenanceLog $log, string $status): MaintenanceLog
    {
        $log->update(['status' => $status]);

        return $log;
    }

    public function create(array $data): MaintenanceLog
    {
        return MaintenanceLog::create($data);
    }
}
