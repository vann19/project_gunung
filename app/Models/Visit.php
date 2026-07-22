<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip',
        'method',
        'path',
        'user_agent',
        'referer',
        'city',
        'region',
        'country',
        'kecamatan',
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];
}
