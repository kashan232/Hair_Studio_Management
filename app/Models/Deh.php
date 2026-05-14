<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deh extends Model
{
    protected $fillable = ['tappa_id', 'name', 'code'];

    public function tappa()
    {
        return $this->belongsTo(Tappa::class);
    }

    public function surveyNumbers()
    {
        return $this->hasMany(SurveyNumber::class);
    }
}
