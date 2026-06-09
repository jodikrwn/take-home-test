<?php

namespace App\Providers;

use App\Repositories\Contracts\MaintenanceLogRepositoryInterface;
use App\Repositories\Contracts\ShipRepositoryInterface;
use App\Repositories\MaintenanceLogRepository;
use App\Repositories\ShipRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ShipRepositoryInterface::class, ShipRepository::class);
        $this->app->bind(MaintenanceLogRepositoryInterface::class, MaintenanceLogRepository::class);
    }

    public function boot(): void
    {
        Model::preventLazyLoading(!app()->isProduction());
    }
}
