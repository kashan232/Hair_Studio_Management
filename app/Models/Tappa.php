<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tappa extends Model
{
    protected $fillable = ['revenue_circle_id', 'name', 'code'];

    public function revenueCircle()
    {
        return $this->belongsTo(RevenueCircle::class);
    }

    public function dehs()
    {
        return $this->hasMany(Deh::class);
    }
}
