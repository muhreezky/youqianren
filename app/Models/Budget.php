<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
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
        'category_id',
        'amount',
        'currency',
        'period',
        'start_date',
        'end_date',
        'description',
    ];

    /**
     * Get the user that owns the budget.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category for the budget.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the transactions for the budget.
     */
    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            Category::class,
            'id',
            'category_id',
            'category_id',
            'id'
        );
    }
}