<?php

namespace Database\Seeders;

use App\Models\MarketplaceItem;
use Illuminate\Database\Seeder;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        MarketplaceItem::create([
            'condition_badge' => 'Seperti Baru',
            'badge_class' => 'bg-secondary-400 text-surface-dark',
            'image' => '/img/jaket.png',
            'title' => "Arc'teryx Alpha SV (Bekas)",
            'category' => 'clothing',
            'spec' => 'ALT: 5000m Performance',
            'old_price' => 'Rp 12.500.000',
            'price' => 'Rp 7.850.000',
        ]);

        MarketplaceItem::create([
            'condition_badge' => 'Bagus',
            'badge_class' => 'bg-white text-gray-700 border border-gray-200',
            'image' => '/img/camping.png',
            'title' => 'The North Face VE 25 Tent',
            'category' => 'tents',
            'spec' => 'WIND: 100km/h Tested',
            'old_price' => null,
            'price' => 'Rp 4.200.000',
        ]);

        MarketplaceItem::create([
            'condition_badge' => 'Seperti Baru',
            'badge_class' => 'bg-secondary-400 text-surface-dark',
            'image' => '/img/sepatu.png',
            'title' => 'La Sportiva Nepal Cube GTX',
            'category' => 'footwear',
            'spec' => 'SIZE: 42 EU / ICE Ready',
            'old_price' => null,
            'price' => 'Rp 5.500.000',
        ]);

        MarketplaceItem::create([
            'condition_badge' => 'Layak Pakai',
            'badge_class' => 'bg-red-50 text-red-600',
            'image' => '/img/tas.png',
            'title' => 'Osprey Aether Plus 70L',
            'category' => 'backpacks',
            'spec' => 'LOAD: 25kg Capacity',
            'old_price' => null,
            'price' => 'Rp 2.100.000',
        ]);
    }
}
