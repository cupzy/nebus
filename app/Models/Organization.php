<?php

namespace App\Models;

use Database\Factories\OrganizationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    /** @use HasFactory<OrganizationFactory> */
    use HasFactory;

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function operations(): BelongsToMany
    {
        return $this->belongsToMany(Operation::class);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(OrganizationPhone::class);
    }
}
