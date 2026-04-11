<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'location',
        'bio',
        'photo',
        'average_rating',
        'total_reviews',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'average_rating' => 'decimal:2',
    ];

    protected function user(): BelongTo
    {
        return $this->belongsTo(User::class);
    }

    protected function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    protected function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function regions()
    {
        return $this->hasMany(ProviderRegion::class);
    }
}
