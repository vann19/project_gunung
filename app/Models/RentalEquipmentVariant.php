<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalEquipmentVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_equipment_id',
        'name',
        'sku',
        'stock',
        'price_override',
        'image',
        'is_active',
        'specifications',
    ];

    protected $casts = [
        'stock' => 'integer',
        'is_active' => 'boolean',
        'specifications' => 'array',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(RentalEquipment::class, 'rental_equipment_id');
    }
}
