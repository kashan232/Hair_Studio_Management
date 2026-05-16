<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barrage extends Model
{
    protected $fillable = [
        'name',
    ];

    public function mainCanals(): HasMany
    {
        return $this->hasMany(MainCanal::class);
    }
}
