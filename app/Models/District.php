<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['revenue_division_id', 'name', 'code'];

    public function revenueDivision()
    {
        return $this->belongsTo(RevenueDivision::class);
    }

    public function talukas()
    {
        return $this->hasMany(Taluka::class);
    }
}
