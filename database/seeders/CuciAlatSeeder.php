<?php

namespace Database\Seeders;

use App\Models\CuciAlat;
use Illuminate\Database\Seeder;

class CuciAlatSeeder extends Seeder
{
    public function run(): void
    {
        CuciAlat::create([
            'name' => 'Deep Clean',
            'duration' => '3-4 Hari',
            'description' => 'Pembersihan menyeluruh, sanitasi anti-bakteri, dan penghilangan bau pada perlengkapan outdoor.',
            'price' => 'Rp 75.000',
            'unit' => '/ item',
            'is_recommended' => false,
        ]);

        CuciAlat::create([
            'name' => 'Reproofing DWR',
            'duration' => '3-4 Hari',
            'description' => 'Deep Clean + Pelapisan ulang water repellent (DWR) berkualitas tinggi untuk mengembalikan keunggulan anti air.',
            'price' => 'Rp 125.000',
            'unit' => '/ item',
            'is_recommended' => true,
        ]);

        CuciAlat::create([
            'name' => 'Express',
            'duration' => '24 Jam',
            'description' => 'Layanan prioritas cepat untuk kebutuhan mendadak. Pembersihan intensif selesai dalam 1 hari.',
            'price' => 'Rp 150.000',
            'unit' => '/ item',
            'is_recommended' => false,
        ]);
    }
}
