<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShipIndexRequest;
use App\Http\Resources\ShipResource;
use App\Services\ShipService;
use Illuminate\Http\JsonResponse;

class ShipController extends Controller
{
    public function __construct(
        private readonly ShipService $shipService,
    ) {}

    public function index(ShipIndexRequest $request): JsonResponse
    {
        $ships = $this->shipService->getFilteredShips($request->validated());

        return $this->paginatedResponse(ShipResource::collection($ships));
    }
}
