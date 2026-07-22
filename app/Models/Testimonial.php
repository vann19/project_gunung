<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'date',
        'text',
        'stars',
        'is_visible',
    ];
}
