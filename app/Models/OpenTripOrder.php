<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenTripOrder extends Model
{
    protected $guarded = [];

    protected $casts = [
        'anggota' => 'array',
    ];

    public function trip()
    {
        return $this->belongsTo(OpenTrip::class, 'trip_id');
    }
}
