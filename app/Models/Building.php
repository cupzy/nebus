<?php

namespace App\Models;

use Database\Factories\BuildingFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    /** @use HasFactory<BuildingFactory> */
    use HasFactory;

    protected $fillable = [
        'address',
        'lat',
        'lon',
    ];

    protected $casts = [
        'lat' => 'float',
        'lon' => 'float',
    ];

    #[Scope]
    public function withinRadius(Builder $query, float $lat, float $lon, float $radiusKm): void
    {
        $latDelta = $radiusKm / 111.32;
        $lonDelta = $radiusKm / (111.32 * cos(deg2rad($lat)));

        $query
            ->whereBetween('lat', [$lat - $latDelta, $lat + $latDelta])
            ->whereBetween('lon', [$lon - $lonDelta, $lon + $lonDelta])
            ->whereRaw(
                '(6371*acos(cos(radians(?))*cos(radians(lat))*cos(radians(lon)-radians(?))+sin(radians(?))*sin(radians(lat))))<?',
                [$lat, $lon, $lat, $radiusKm],
            );
    }
}
