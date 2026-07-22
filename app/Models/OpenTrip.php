<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenTrip extends Model
{
    protected $guarded = [];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
    ];
}
