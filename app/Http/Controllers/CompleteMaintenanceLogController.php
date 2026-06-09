<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteMaintenanceLogRequest;
use App\Http\Resources\MaintenanceLogResource;
use App\Models\MaintenanceLog;
use App\Services\MaintenanceService;
use Illuminate\Http\JsonResponse;

class CompleteMaintenanceLogController extends Controller
{
    public function __construct(
        private readonly MaintenanceService $maintenanceService,
    ) {}

    public function __invoke(CompleteMaintenanceLogRequest $request, MaintenanceLog $maintenanceLog): JsonResponse
    {
        $result = $this->maintenanceService->markAsCompleted($maintenanceLog);

        $message = "Servis ditandai selesai. Jadwal berikutnya: {$result['next']->tanggal_servis->format('Y-m-d')}";

        return $this->successResponse(
            [
                'completed'      => new MaintenanceLogResource($result['completed']),
                'next_scheduled' => new MaintenanceLogResource($result['next']),
            ],
            $message,
        );
    }
}
