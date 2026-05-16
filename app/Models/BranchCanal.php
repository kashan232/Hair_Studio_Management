<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BranchCanal extends Model
{
    protected $fillable = [
        'sub_canal_id',
        'name',
    ];

    public function subCanal(): BelongsTo
    {
        return $this->belongsTo(SubCanal::class);
    }

    public function distributaries(): HasMany
    {
        return $this->hasMany(Distributary::class);
    }
}
