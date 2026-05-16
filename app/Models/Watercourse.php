<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Watercourse extends Model
{
    protected $fillable = [
        'minor_id',
        'name',
    ];

    public function minor(): BelongsTo
    {
        return $this->belongsTo(Minor::class);
    }
}
