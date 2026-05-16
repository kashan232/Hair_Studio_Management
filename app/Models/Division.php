<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['name', 'circle_id'];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function subDivisions()
    {
        return $this->hasMany(SubDivision::class);
    }
}
