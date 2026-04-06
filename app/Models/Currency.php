<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'symbol',
        'is_custom',
        'user_id',
        'exchange_rate',
    ];

    /**
     * Get the user that owns the currency (for custom currencies).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this is a system currency.
     */
    public function isSystemCurrency(): bool
    {
        return !$this->is_custom;
    }

    /**
     * Check if this is a custom currency.
     */
    public function isCustomCurrency(): bool
    {
        return $this->is_custom;
    }
}