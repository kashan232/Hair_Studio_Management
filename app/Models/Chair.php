<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chair extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'status', 
        'price_hourly', 'price_daily', 'price_monthly', 'price_yearly'
    ];

    /**
     * Get the bookings that include this chair.
     */
    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_chairs')
            ->withPivot('start_time', 'end_time')
            ->withTimestamps();
    }
}
