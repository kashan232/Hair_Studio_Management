<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCanal extends Model
{
    protected $fillable = [
        'main_canal_id',
        'name',
    ];

    public function mainCanal(): BelongsTo
    {
        return $this->belongsTo(MainCanal::class);
    }

    public function branchCanals(): HasMany
    {
        return $this->hasMany(BranchCanal::class);
    }
}
