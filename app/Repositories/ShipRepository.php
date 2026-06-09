<?php

namespace App\Repositories;

use App\Models\Ship;
use App\Repositories\Contracts\ShipRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ShipRepository implements ShipRepositoryInterface
{
    public function getFilteredPaginated(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Ship::query()
            ->addSelect([
                'total_biaya_servis' => DB::table('maintenance_logs as ml')
                    ->selectRaw('COALESCE(SUM(ml.biaya), 0)')
                    ->whereColumn('ml.ship_id', 'ships.id'),
            ])
            ->with('latestMaintenanceLog');

        if (!empty($filters['status'])) {
            $query->whereIn('ships.id', function (QueryBuilder $sub) use ($filters) {
                $sub->select('ship_id')
                    ->from('maintenance_logs')
                    ->where('status', $filters['status']);
            });
        }

        if (isset($filters['min_biaya']) || isset($filters['max_biaya'])) {
            $query->havingRaw('total_biaya_servis >= ?', [$filters['min_biaya'] ?? 0]);

            if (isset($filters['max_biaya'])) {
                $query->havingRaw('total_biaya_servis <= ?', [$filters['max_biaya']]);
            }
        }

        return $query->paginate($perPage);
    }
}
