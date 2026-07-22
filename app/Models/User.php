<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'role', // legacy support
        'designation',
        'code',
        'cnic',
        'mobile',
        'joining_date',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role associated with the user.
     */
    public function roleRelation()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Check if user has a specific permission.
     */
    public function hasPermission($permissionSlug)
    {
        if (!$this->roleRelation) {
            return false;
        }
        return $this->roleRelation->permissions()->where('slug', $permissionSlug)->exists();
    }

    /**
     * Staff who can manage chair inventory and chair bookings (cancel / manual add).
     */
    public function canManageChairBookings(): bool
    {
        return $this->hasPermission('manage-chairs') || $this->hasPermission('manage-bookings');
    }

    /**
     * Admin/receptionist staff booking for a customer — not regular registered stylists.
     */
    public function canBookOnBehalfOfCustomer(): bool
    {
        return $this->canManageChairBookings() && !$this->isHairstylist();
    }

    public function isHairstylist(): bool
    {
        if ($this->role === 'hairstylist') {
            return true;
        }

        return $this->roleRelation && $this->roleRelation->slug === 'hairstylist';
    }

    /**
     * Get the bookings associated with the user.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function userPackages()
    {
        return $this->hasMany(UserPackage::class);
    }

    public function getPackageBalanceAttribute()
    {
        return $this->userPackages()
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->sum('hours_remaining');
    }
}
