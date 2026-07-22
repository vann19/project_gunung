<?php

namespace Database\Seeders;

use App\Models\HikingGuide;
use Illuminate\Database\Seeder;

class HikingGuideSeeder extends Seeder
{
    public function run(): void
    {
        HikingGuide::create([
            'badge' => 'SERTIFIKASI APGI',
            'badge_class' => 'bg-secondary-400 text-surface-dark',
            'is_featured' => false,
            'title' => 'Certified Lead Mountain Guide',
            'price' => 'Rp 450.000',
            'unit' => '/ hari',
            'image' => '/img/Guide helping climber.png',
            'features' => [
                ['label' => 'Sertifikasi Resmi APGI & First Aid P3K', 'bold' => false],
                ['label' => 'Rasio pendampingan aman (Maksimal 1:4)', 'bold' => false],
                ['label' => 'Menguasai rute & navigasi darat GPS/Peta', 'bold' => false],
            ],
        ]);

        HikingGuide::create([
            'badge' => 'MOST POPULAR',
            'badge_class' => 'bg-primary text-white',
            'is_featured' => true,
            'title' => 'VIP Private Hiking Guide + Porter',
            'price' => 'Rp 850.000',
            'unit' => '/ hari',
            'image' => '/img/Guide helping climber.png',
            'features' => [
                ['label' => '1 Guide Sertifikasi + 1 Dedicated Porter Logistik', 'bold' => true],
                ['label' => 'Bongkar pasang tenda & masak makan utama', 'bold' => false],
                ['label' => 'Peralatan navigasi komunikasi darurat lengkap', 'bold' => false],
                ['label' => 'Dokumentasi perjalanan foto & video profesional', 'bold' => false],
            ],
        ]);

        HikingGuide::create([
            'badge' => 'TIM PORTER',
            'badge_class' => 'bg-surface-dark text-white',
            'is_featured' => false,
            'title' => 'Porter Logistik & Tim Perlengkapan',
            'price' => 'Rp 300.000',
            'unit' => '/ hari',
            'image' => '/img/Guide helping climber.png',
            'features' => [
                ['label' => 'Membawa maksimal beban 20 Kg per porter', 'bold' => true],
                ['label' => 'Membantu pendirian tenda camp kelompok', 'bold' => false],
                ['label' => 'Berpengalaman dan ramah terhadap pendaki', 'bold' => false],
                ['label' => 'Siaga membantu pengambilan air bersih di camp', 'bold' => false],
            ],
        ]);
    }
}
