<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Distributary extends Model
{
    protected $fillable = [
        'branch_canal_id',
        'name',
    ];

    public function branchCanal(): BelongsTo
    {
        return $this->belongsTo(BranchCanal::class);
    }

    public function minors(): HasMany
    {
        return $this->hasMany(Minor::class);
    }
}
