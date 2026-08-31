<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissedBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'requested_date',
        'requested_time',
        'duration_hours',
        'user_id'
    ];
}
