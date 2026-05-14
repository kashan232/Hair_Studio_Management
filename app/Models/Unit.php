<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name', 'code'];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }
}
