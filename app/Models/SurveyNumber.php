<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyNumber extends Model
{
    protected $fillable = ['deh_id', 'number', 'code'];

    public function deh()
    {
        return $this->belongsTo(Deh::class);
    }
}
