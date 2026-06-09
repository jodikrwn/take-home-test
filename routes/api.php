<?php

use App\Http\Controllers\CompleteMaintenanceLogController;
use App\Http\Controllers\ShipController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('ships', [ShipController::class, 'index']);
    Route::patch('maintenance-logs/{maintenanceLog}/complete', CompleteMaintenanceLogController::class);
});
