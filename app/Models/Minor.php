<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Minor extends Model
{
    protected $fillable = [
        'distributary_id',
        'name',
    ];

    public function distributary(): BelongsTo
    {
        return $this->belongsTo(Distributary::class);
    }

    public function watercourses(): HasMany
    {
        return $this->hasMany(Watercourse::class);
    }
}
