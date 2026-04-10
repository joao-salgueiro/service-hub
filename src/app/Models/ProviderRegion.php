<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderRegion extends Model
{
    protected $fillable = [
        'provider_id',
        'region',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
