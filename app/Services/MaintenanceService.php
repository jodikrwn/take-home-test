<?php

namespace App\Services;

use App\Jobs\SendCompletionNotification;
use App\Models\MaintenanceLog;
use App\Repositories\Contracts\MaintenanceLogRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MaintenanceService
{
    public function __construct(
        private readonly MaintenanceLogRepositoryInterface $logs,
    ) {}

    public function markAsCompleted(MaintenanceLog $log): array
    {
        return DB::transaction(function () use ($log) {
            $this->logs->updateStatus($log, 'completed');

            $next = $this->logs->create([
                'ship_id'        => $log->ship_id,
                'tanggal_servis' => Carbon::parse($log->tanggal_servis)->addMonths(6),
                'jenis_servis'   => $log->jenis_servis,
                'biaya'          => $log->biaya,
                'status'         => 'planned',
            ]);

            $completedLog = $log->fresh(['ship']);
            $next->setRelation('ship', $completedLog->ship);

            SendCompletionNotification::dispatch($completedLog, $next);

            return ['completed' => $completedLog, 'next' => $next];
        });
    }
}
