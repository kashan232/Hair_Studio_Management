<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MainCanal extends Model
{
    protected $fillable = [
        'barrage_id',
        'name',
    ];

    public function barrage(): BelongsTo
    {
        return $this->belongsTo(Barrage::class);
    }

    public function subCanals(): HasMany
    {
        return $this->hasMany(SubCanal::class);
    }
}
