<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalEquipment extends Model
{
    use HasFactory;

    protected $table = 'rental_equipments';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'price',
        'stock',
        'condition_badge',
        'description',
        'specifications',
        'image',
        'gallery_images',
        'is_popular',
        'is_visible',
        'colors',
        'sizes',
    ];

    protected $casts = [
        'is_popular'     => 'boolean',
        'is_visible'     => 'boolean',
        'specifications' => 'array',
        'gallery_images' => 'array',
        'colors'         => 'array',
        'sizes'          => 'array',
        'stock'          => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->title);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') && empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->title);
            }
        });
    }

    public function variants()
    {
        return $this->hasMany(RentalEquipmentVariant::class, 'rental_equipment_id');
    }

    /**
     * Get the total stock across all active variants.
     * If no variants exist, fallback to the main stock.
     */
    public function getTotalStockAttribute()
    {
        if ($this->variants()->exists()) {
            return $this->variants()->where('is_active', true)->sum('stock');
        }
        return $this->stock;
    }

    /**
     * Get the main image to display.
     * Prefers the first variant with an image, then falls back to main image.
     */
    public function getMainImageAttribute()
    {
        $variantWithImage = $this->variants()->whereNotNull('image')->where('image', '!=', '')->first();
        if ($variantWithImage) {
            $img = $variantWithImage->image;
            return str_starts_with($img, '/') ? $img : '/' . $img;
        }
        
        $img = $this->image;
        if (!$img) return '/img/camping.png';
        return str_starts_with($img, '/') ? $img : '/' . $img;
    }
}
