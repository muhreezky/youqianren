<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'plan',
        'start_date',
        'end_date',
        'payment_method',
        'transaction_id',
        'is_active',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the subscription is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if the subscription is for the Pro plan.
     */
    public function isProPlan(): bool
    {
        return $this->plan === 'pro';
    }

    /**
     * Check if the subscription is for the Free plan.
     */
    public function isFreePlan(): bool
    {
        return $this->plan === 'free';
    }
}