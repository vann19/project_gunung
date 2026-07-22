<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MountainRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'mountain_id',
        'name',
        'basecamp_info',
        'description',
        'posts',
    ];

    protected $casts = [
        'posts' => 'array',
    ];

    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }
}
