<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model

{
    protected $fillable = [
        'unit_id',
        'name',
        'job_title',
        'full_name',
        'cell_no',
        'full_address',
        'code',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function circles()
    {
        return $this->hasMany(Circle::class);
    }
}

