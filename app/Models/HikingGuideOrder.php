<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HikingGuideOrder extends Model
{
    protected $guarded = [];

    protected $casts = [
        'anggota' => 'array',
        'tanggal_pendakian' => 'date',
    ];

    public function guide()
    {
        return $this->belongsTo(HikingGuide::class, 'guide_id');
    }
}
