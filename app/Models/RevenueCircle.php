<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevenueCircle extends Model
{
    protected $fillable = ['taluka_id', 'name', 'code'];

    public function taluka()
    {
        return $this->belongsTo(Taluka::class);
    }

    public function tappas()
    {
        return $this->hasMany(Tappa::class);
    }
}
