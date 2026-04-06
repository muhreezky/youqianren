<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'position',
        'width',
        'height',
        'config',
        'is_visible',
    ];

    /**
     * Get the user that owns the widget.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the configuration as an array.
     */
    public function getConfigAttribute($value): array
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Set the configuration as JSON.
     */
    public function setConfigAttribute($value): void
    {
        $this->attributes['config'] = $value ? json_encode($value) : null;
    }
}