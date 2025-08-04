<?php

namespace App\Http\ResponseFactories;

use App\Models\Operation;
use App\Models\Organization;
use App\Models\OrganizationPhone;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganizationResponseFactory extends ResponseFactory
{
    public function index(LengthAwarePaginator $paginator): JsonResponse
    {
        return $this->paginatedResponse($paginator, fn (Organization $organization) => $this->map($organization));
    }

    public function show(Organization $organization): JsonResponse
    {
        return response()->json($this->map($organization));
    }

    private function map(Organization $organization): array
    {
        return [
            'id' => $organization->id,
            'name' => $organization->name,
            'building' => [
                'id' => $organization->building->id,
                'address' => $organization->building->address,
                'lat' => $organization->building->lat,
                'lon' => $organization->building->lon,
            ],
            'operations' => $organization->operations->map(fn (Operation $operation) => [
                'id' => $operation->id,
                'name' => $operation->name,
            ]),
            'phones' => $organization->phones->map(fn (OrganizationPhone $organizationPhone) => $organizationPhone->phone),
        ];
    }
}
