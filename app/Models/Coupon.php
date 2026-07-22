<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'expires_at',
        'is_active',
        'is_reusable',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'is_active' => 'boolean',
        'is_reusable' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('used_at', 'email')
            ->withTimestamps();
    }

    public function isValidNow(): bool
    {
        return $this->is_active && $this->expires_at->gte(Carbon::today());
    }

    /**
     * Standard coupons: one redemption per email (registered or guest).
     * Reusable coupons: unlimited.
     */
    public function hasBeenUsedBy(?User $user, ?string $email = null): bool
    {
        if ($this->is_reusable) {
            return false;
        }

        $email = strtolower(trim((string) ($email ?: $user?->email)));
        if ($email === '') {
            return false;
        }

        if (DB::table('coupon_user')
            ->where('coupon_id', $this->id)
            ->where('email', $email)
            ->exists()) {
            return true;
        }

        $userIds = User::whereRaw('LOWER(email) = ?', [$email])->pluck('id');
        if ($user) {
            $userIds = $userIds->push($user->id)->unique();
        }

        if ($userIds->isEmpty()) {
            return false;
        }

        return DB::table('coupon_user')
            ->where('coupon_id', $this->id)
            ->whereIn('user_id', $userIds)
            ->exists();
    }

    public function recordUsage(?User $user, ?string $email = null): void
    {
        $email = strtolower(trim((string) ($email ?: $user?->email)));
        if ($email === '' && !$user) {
            return;
        }

        if (!$this->is_reusable && $this->hasBeenUsedBy($user, $email)) {
            return;
        }

        DB::table('coupon_user')->insert([
            'coupon_id' => $this->id,
            'user_id' => $user?->id,
            'email' => $email ?: null,
            'used_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function calculateDiscount(float $total): float
    {
        $discount = $this->discount_type === 'fixed'
            ? (float) $this->discount_value
            : $total * ((float) $this->discount_value / 100);

        return round(min($discount, $total), 2);
    }
}
