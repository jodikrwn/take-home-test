<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ShipRepositoryInterface
{
    public function getFilteredPaginated(array $filters, int $perPage = 15): LengthAwarePaginator;
}
