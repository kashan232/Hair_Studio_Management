<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrrigationDivision extends Model
{
    use HasFactory;

    protected $fillable = [
        'circle_id',
        'name',
        'job_title',
        'full_name',
        'cell_no',
        'full_address',
        'code',
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function subDivisions()
    {
        return $this->hasMany(SubDivision::class);
    }
}
