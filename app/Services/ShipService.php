<?php

namespace App\Services;

use App\Repositories\Contracts\ShipRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ShipService
{
    public function __construct(
        private readonly ShipRepositoryInterface $ships,
    ) {}

    public function getFilteredShips(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->ships->getFilteredPaginated($filters, $perPage);
    }
}
