<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'start_datetime',
        'end_datetime',
        'duration_hours',
        'package_hours_used',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chairs()
    {
        return $this->belongsToMany(Chair::class, 'booking_chairs')
            ->withPivot('start_time', 'end_time')
            ->withTimestamps();
    }
}
