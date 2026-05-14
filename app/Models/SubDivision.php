<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDivision extends Model
{
    use HasFactory;

    protected $fillable = [
        'irrigation_division_id',
        'name',
        'job_title',
        'full_name',
        'cell_no',
        'full_address',
        'code',
    ];

    public function irrigationDivision()
    {
        return $this->belongsTo(IrrigationDivision::class);
    }
}
