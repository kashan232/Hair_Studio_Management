<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model

{
    protected $fillable = [
        'name',
        'job_title',
        'full_name',
        'cell_no',
        'full_address',
        'code',
    ];

    public function circles()
    {
        return $this->hasMany(Circle::class);
    }
}

