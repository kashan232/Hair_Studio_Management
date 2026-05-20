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

    public function isHairstylist(): bool
    {
        if ($this->role === 'hairstylist') {
            return true;
        }

        return $this->roleRelation && $this->roleRelation->slug === 'hairstylist';
    }
}
