<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taluka extends Model
{
    protected $fillable = ['district_id', 'name', 'code'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function revenueCircles()
    {
        return $this->hasMany(RevenueCircle::class);
    }
}
