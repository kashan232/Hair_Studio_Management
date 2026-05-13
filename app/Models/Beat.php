<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_division_id',
        'name',
        'code',
    ];

    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class);
    }
}
