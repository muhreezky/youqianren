<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'currency',
        'balance',
        'icon',
        'description',
    ];

    /**
     * Get the user that owns the account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the account.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the transfer transactions where this account is the source.
     */
    public function outgoingTransfers()
    {
        return $this->hasMany(Transaction::class, 'account_id')->where('type', 'transfer');
    }

    /**
     * Get the transfer transactions where this account is the destination.
     */
    public function incomingTransfers()
    {
        return $this->hasMany(Transaction::class, 'to_account_id')->where('type', 'transfer');
    }
}