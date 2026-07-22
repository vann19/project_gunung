<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HikingGuide extends Model
{
    protected $guarded = [];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
    ];
}
