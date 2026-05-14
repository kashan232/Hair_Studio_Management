<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model

{
    protected $fillable = [
        'region_id',
        'name',
        'job_title',
        'full_name',
        'cell_no',
        'full_address',
        'code',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}

