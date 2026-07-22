<?php

namespace Database\Seeders;

use App\Models\OpenTrip;
use Illuminate\Database\Seeder;

class OpenTripSeeder extends Seeder
{
    public function run(): void
    {
        OpenTrip::create([
            'badge' => 'TERBUKA',
            'badge_class' => 'bg-secondary-400 text-surface-dark',
            'is_featured' => false,
            'slot' => 10,
            'title' => 'Open Trip Gn. Rinjani 4D3N via Sembalun',
            'price' => 'Rp 1.450.000',
            'features' => [
                ['icon' => 'transport', 'label' => 'Transport PP dari Meeting Point Lombok'],
                ['icon' => 'food', 'label' => 'Makan & Logistik Selama Pendakian'],
                ['icon' => 'porter', 'label' => 'Porter Tim & Guide Sertifikasi APGI'],
                ['icon' => 'tent', 'label' => 'Tenda & Perlengkapan Kelompok'],
            ],
        ]);

        OpenTrip::create([
            'badge' => 'LAST MINUTE',
            'badge_class' => 'bg-red-50 text-red-600',
            'is_featured' => true,
            'slot' => 5,
            'title' => 'Open Trip Gn. Semeru 3D2N Ranu Kumbolo',
            'price' => 'Rp 950.000',
            'features' => [
                ['icon' => 'transport', 'label' => 'Jemput Stasiun Malang / Surabaya'],
                ['icon' => 'food', 'label' => 'Makan 6x + Snack & Coffee Break'],
                ['icon' => 'porter', 'label' => 'Porter Tenda & Guide Profesional'],
                ['icon' => 'tent', 'label' => 'Tenda Dome Kapasitas 4 Orang'],
            ],
        ]);

        OpenTrip::create([
            'badge' => 'SEGERA',
            'badge_class' => 'bg-gray-100 text-gray-600',
            'is_featured' => false,
            'slot' => 15,
            'title' => 'Open Trip Gn. Gede Pangrango via Cibodas',
            'price' => 'Rp 450.000',
            'features' => [
                ['icon' => 'transport', 'label' => 'Bus Pariwisata PP dari Jakarta'],
                ['icon' => 'food', 'label' => 'Makan Sebelum & Sesudah Pendakian'],
                ['icon' => 'porter', 'label' => 'Tour Leader & Guide Berpengalaman'],
                ['icon' => 'tent', 'label' => 'Simaksi & Asuransi Resmi Taman Nasional'],
            ],
        ]);
    }
}
