<?php

namespace App\Models;

use Database\Factories\OrganizationPhoneFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationPhone extends Model
{
    /** @use HasFactory<OrganizationPhoneFactory> */
    use HasFactory;

    public function organization(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
