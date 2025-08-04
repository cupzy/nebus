<?php

namespace App\Services;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

readonly class OrganizationService
{
    public function __construct(
        private OperationService $operationService,
    ) {
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for(Organization::class)
            ->with(['operations', 'building', 'phones'])
            ->allowedFilters([
                'building_id' => AllowedFilter::exact('building_id'),
                'operation_id' => AllowedFilter::callback('operation_id', function (Builder $query, $value) {
                    $operationIds = is_array($value) ? $value : [$value];
                    $query->whereHas('operations', function (Builder $query) use ($operationIds) {
                        $query->whereIn('id', $operationIds);
                    });
                }),
                'geo' => AllowedFilter::callback('geo', function (Builder $query, $value) {
                    ['lat' => $lat, 'lon' => $lon, 'radius' => $radius] = $value;
                    $query->whereHas('building', function (Builder $query) use ($lat, $lon, $radius) {
                        $query->withinRadius($lat, $lon, $radius);
                    });
                }),
                'name' => AllowedFilter::partial('name'),
                'parent_operation_id' => AllowedFilter::callback('parent_operation_id', function (Builder $query, $value) {
                    $parentOperationIds = is_array($value) ? $value : [$value];
                    $operationIds = $this->operationService->getNestedOperationIds($parentOperationIds);
                    $query->whereHas('operations', function (Builder $query) use ($operationIds) {
                        $query->whereIn('id', $operationIds);
                    });
                }),
            ])
            ->paginate($perPage);
    }

    public function get(int $id)
    {
        return Organization::query()->find($id);
    }
}
