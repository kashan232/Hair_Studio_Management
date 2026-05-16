<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tehsil extends Model
{
    protected $fillable = [
        'taluka_id',
        'name',
    ];

    public function taluka(): BelongsTo
    {
        return $this->belongsTo(Taluka::class);
    }

    public function dehs(): HasMany
    {
        return $this->hasMany(Deh::class);
    }
}
