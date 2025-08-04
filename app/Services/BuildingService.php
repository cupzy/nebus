<?php

namespace App\Services;

use App\Models\Building;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BuildingService
{
    public function paginate(int $perPage): LengthAwarePaginator
    {

        return QueryBuilder::for(Building::class)
            ->allowedFilters([
                'geo' => AllowedFilter::callback('geo', function (Builder $query, $value) {
                    ['lat' => $lat, 'lon' => $lon, 'radius' => $radius] = $value;
                    $query->withinRadius($lat, $lon, $radius);
                }),
            ])
            ->paginate($perPage);
    }
}
