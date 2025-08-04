<?php

namespace App\Http\ResponseFactories;

use App\Models\Building;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class BuildingResponseFactory extends ResponseFactory
{
    public function index(LengthAwarePaginator $paginator): JsonResponse
    {
        return $this->paginatedResponse($paginator, fn (Building $building) => $this->map($building));
    }

    private function map(Building $building): array
    {
        return [
            'id' => $building->id,
            'address' => $building->address,
            'lat' => $building->lat,
            'lon' => $building->lon,
        ];
    }
}
