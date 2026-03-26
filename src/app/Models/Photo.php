<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'service_id',
        'url',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
