<?php

namespace Database\Seeders;

use App\Models\RentalEquipment;
use Illuminate\Database\Seeder;

class RentalEquipmentSeeder extends Seeder
{
    public function run(): void
    {
        if (RentalEquipment::count() > 0) {
            return;
        }

        $products = [
            [
                'title' => 'Tenda Dome 4P',
                'price' => 'Rp 45k',
                'description' => 'Tenda dome kapasitas 4 orang, tahan angin dan hujan ringan, cocok untuk camping keluarga.',
                'image' => '/img/camping.png',
                'condition_badge' => 'Baru',
                'is_popular' => true,
                'category' => 'camping',
            ],
            [
                'title' => 'Sleeping Bag -10°C',
                'price' => 'Rp 35k',
                'description' => 'Kantong tidur mummy rating suhu -10°C dengan isolasi sintetis premium untuk malam dingin.',
                'image' => '/img/jaket.png',
                'condition_badge' => 'Baru',
                'is_popular' => false,
                'category' => 'camping',
            ],
            [
                'title' => 'Carrier 60L',
                'price' => 'Rp 25k',
                'description' => 'Carrier frame internal 60L dengan rain cover, ideal untuk multi-day hiking dan summit attack.',
                'image' => '/img/tas.png',
                'condition_badge' => 'Second',
                'is_popular' => false,
                'category' => 'pribadi',
            ],
            [
                'title' => 'Kompor Portable',
                'price' => 'Rp 20k',
                'description' => 'Kompor gas ringan dengan piezo ignition, stabil untuk memasak di ketinggian.',
                'image' => '/img/Camping gear setup.png',
                'condition_badge' => 'Second',
                'is_popular' => false,
                'category' => 'masak',
            ],
            [
                'title' => 'Grill & Chill Kit',
                'price' => 'Rp 55k',
                'description' => 'Set BBQ portable lengkap dengan alat panggang, sempurna untuk piknik di kaki gunung.',
                'image' => '/img/camping.png',
                'condition_badge' => 'Baru',
                'is_popular' => true,
                'category' => 'grill',
            ],
            [
                'title' => 'Advanced Hydropack',
                'price' => 'Rp 18k',
                'description' => 'Sistem hidrasi 2L dengan bladder anti-bocor untuk trail running dan pendakian cepat.',
                'image' => '/img/tas.png',
                'condition_badge' => 'Baru',
                'is_popular' => false,
                'category' => 'hydropack',
            ],
            [
                'title' => 'Sepatu Hiking Pro',
                'price' => 'Rp 40k',
                'description' => 'Sepatu hiking mid-cut dengan grip Vibram, waterproof dan nyaman untuk medan berbatu.',
                'image' => '/img/sepatu.png',
                'condition_badge' => 'Second',
                'is_popular' => false,
                'category' => 'pribadi',
            ],
            [
                'title' => 'Set Perlengkapan Kelompok',
                'price' => 'Rp 120k',
                'description' => 'Paket lengkap untuk 8–10 orang: tenda besar, matras, lampu, dan meja lipat.',
                'image' => '/img/Camping gear setup.png',
                'condition_badge' => 'Baru',
                'is_popular' => false,
                'category' => 'kelompok',
            ],
            [
                'title' => 'Piknik Set Premium',
                'price' => 'Rp 30k',
                'description' => 'Tikar, cooler bag, dan peralatan makan reusable untuk piknik santai di alam terbuka.',
                'image' => '/img/camping.png',
                'condition_badge' => 'Second',
                'is_popular' => false,
                'category' => 'piknik',
            ],
        ];

        foreach ($products as $item) {
            RentalEquipment::create($item);
        }
    }
}
