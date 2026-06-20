@php
    $icons = [
        'transport' => '<svg class="w-4 h-4 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M6 16a2 2 0 100 4 2 2 0 000-4zm12 0a2 2 0 100 4 2 2 0 000-4zM5 16V7a2 2 0 012-2h10a2 2 0 012 2v9M5 16h14M5 11h14"/></svg>',
        'food'      => '<svg class="w-4 h-4 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3v6a2 2 0 002 2v10M8 3a2 2 0 00-2 2v4a2 2 0 002 2M8 3v8M16 3v18M16 3a3 3 0 013 3v4a3 3 0 01-3 3"/></svg>',
        'porter'    => '<svg class="w-4 h-4 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="5" r="2" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9l-2 4 3 1v8m4-13l2 4-3 1v8M9 14h6"/></svg>',
        'tent'      => '<svg class="w-4 h-4 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20L12 4l9 16M12 4l5 16M12 4L7 20M9 20h6"/></svg>',
    ];

    $checkIcon = '<svg class="w-4 h-4 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 12.5l2.5 2.5 4.5-5"/></svg>';

    $trips = [
        [
            'badge'     => 'Populer',
            'badgeClass'=> 'bg-secondary-400 text-surface-dark',
            'featured'  => false,
            'slot'      => 10,
            'title'     => 'Mount Semeru',
            'price'     => 'Rp 1.500.000',
            'features'  => [
                ['icon' => 'transport', 'label' => 'Transportasi PP'],
                ['icon' => 'food', 'label' => 'Makan (9x)'],
                ['icon' => 'porter', 'label' => 'Porter Tim'],
                ['icon' => 'tent', 'label' => 'Camping Gear'],
            ],
        ],
        [
            'badge'     => 'Terbatas',
            'badgeClass'=> 'bg-red-50 text-red-600',
            'featured'  => true,
            'slot'      => 5,
            'title'     => 'Rinjani Expedition',
            'price'     => 'Rp 2.800.000',
            'features'  => [
                ['icon' => 'transport', 'label' => 'Transportasi Premium'],
                ['icon' => 'food', 'label' => 'Makan (Full-board)'],
                ['icon' => 'porter', 'label' => 'Porter Pribadi (Opsional)'],
                ['icon' => 'tent', 'label' => 'Deluxe Camping Gear'],
            ],
        ],
        [
            'badge'     => 'Ekonomis',
            'badgeClass'=> 'bg-gray-100 text-gray-600',
            'featured'  => false,
            'slot'      => 15,
            'title'     => 'Mount Gede',
            'price'     => 'Rp 750.000',
            'features'  => [
                ['icon' => 'transport', 'label' => 'Transportasi Lokal'],
                ['icon' => 'food', 'label' => 'Makan (3x)'],
                ['icon' => 'porter', 'label' => 'Porter Tim'],
                ['icon' => 'tent', 'label' => 'Camping Gear Standar'],
            ],
        ],
    ];

    $guides = [
        [
            'badge'      => 'Entry Level',
            'badgeClass' => 'bg-secondary-400 text-surface-dark',
            'featured'   => false,
            'title'      => 'Basic Guide',
            'price'      => 'Rp 500.000',
            'features'   => [
                ['label' => 'Navigasi Dasar', 'bold' => false],
                ['label' => 'Sertifikasi APGI Muda', 'bold' => false],
                ['label' => 'Manajemen Logistik', 'bold' => false],
            ],
        ],
        [
            'badge'      => 'Most Popular',
            'badgeClass' => 'bg-primary text-white',
            'featured'   => true,
            'title'      => 'Expert Guide',
            'price'      => 'Rp 1.200.000',
            'features'   => [
                ['label' => 'Semua fitur Basic', 'bold' => true],
                ['label' => 'Sertifikasi APGI Madya', 'bold' => false],
                ['label' => 'Keahlian First Aid (WFA)', 'bold' => false],
                ['label' => 'Dokumentasi Perjalanan', 'bold' => false],
            ],
        ],
        [
            'badge'      => 'High Altitude',
            'badgeClass' => 'bg-surface-dark text-white',
            'featured'   => false,
            'title'      => 'Technical Specialist',
            'price'      => 'Rp 2.000.000',
            'features'   => [
                ['label' => 'Semua fitur Expert', 'bold' => true],
                ['label' => 'Sertifikasi APGI Utama', 'bold' => false],
                ['label' => 'Technical Rope Rescue', 'bold' => false],
                ['label' => 'Vertical Rescue Exp', 'bold' => false],
            ],
        ],
    ];
@endphp

<div class="w-full bg-surface-soft py-16 lg:py-20 px-6" x-data="{ tab: 'opentrip' }">
    <div class="max-w-[1280px] mx-auto flex flex-col items-center text-center gap-4">

        {{-- Judul: Open Trip --}}
        <div x-show="tab === 'opentrip'" x-cloak class="flex flex-col items-center gap-4">
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">Eksplorasi Puncak Tertinggi</h1>
            <p class="text-gray-500 text-lg max-w-2xl">
                Pilih petualanganmu bersama tim profesional kami. Kami menyediakan layanan open trip berkualitas dengan standar keselamatan tinggi.
            </p>
        </div>

        {{-- Judul: Guide Pendakian --}}
        <div x-show="tab === 'guide'" x-cloak class="flex flex-col items-center gap-4">
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">Pilih Pendamping Petualangan Anda</h1>
            <p class="text-gray-500 text-lg max-w-2xl">
                Kami menyediakan jasa pendampingan profesional untuk memastikan keamanan dan kenyamanan pendakian Anda di puncak tertinggi Nusantara.
            </p>
        </div>

        {{-- Tab Switcher --}}
        <div class="inline-flex bg-gray-200/70 rounded-full p-1 mt-2">
            <button type="button" @click="tab = 'opentrip'"
                    :class="tab === 'opentrip' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                    class="px-6 py-2.5 rounded-full text-sm font-bold transition-all">
                Open Trip
            </button>
            <button type="button" @click="tab = 'guide'"
                    :class="tab === 'guide' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                    class="px-6 py-2.5 rounded-full text-sm font-bold transition-all">
                Guide Pendakian
            </button>
        </div>
    </div>

    {{-- ============ PANEL: OPEN TRIP ============ --}}
    <div x-show="tab === 'opentrip'" x-cloak class="max-w-[1280px] mx-auto mt-12 lg:mt-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
            @foreach ($trips as $trip)
                <div class="relative bg-white rounded-2xl p-6 flex flex-col
                            {{ $trip['featured']
                                ? 'border-2 border-primary shadow-xl z-10 lg:-my-4'
                                : 'border border-gray-200 shadow-sm' }}">

                    @if ($trip['featured'])
                        <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 bg-primary rounded-md text-white text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest">
                            Best Value
                        </span>
                    @endif

                    {{-- Top row: badge & slot --}}
                    <div class="flex justify-between items-start mb-5">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $trip['badgeClass'] }}">
                            {{ $trip['badge'] }}
                        </span>
                        <div class="text-right">
                            <span class="block text-gray-400 text-[10px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest">Sisa Slot</span>
                            <span class="block text-gray-900 text-xl font-bold leading-tight">{{ $trip['slot'] }}</span>
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $trip['title'] }}</h3>
                    <span class="text-gray-400 text-xs">Mulai dari</span>
                    <span class="block text-primary text-2xl font-bold mb-5">{{ $trip['price'] }}</span>

                    <ul class="flex flex-col gap-3 mb-6">
                        @foreach ($trip['features'] as $feature)
                            <li class="flex items-center gap-3 text-gray-700 text-sm">
                                {!! $icons[$feature['icon']] !!}
                                {{ $feature['label'] }}
                            </li>
                        @endforeach
                    </ul>

                    <a href="/konfirmasi-pendaftaran" class="mt-auto w-full bg-secondary-400 hover:bg-secondary-500 rounded-lg py-3 flex items-center justify-center gap-2 font-bold text-surface-dark text-sm transition-colors">
                        Pilih Trip
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============ PANEL: GUIDE PENDAKIAN ============ --}}
    <div x-show="tab === 'guide'" x-cloak class="max-w-[1280px] mx-auto mt-12 lg:mt-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
            @foreach ($guides as $guide)
                <div class="relative bg-white rounded-2xl overflow-hidden flex flex-col
                            {{ $guide['featured']
                                ? 'border-2 border-primary shadow-xl z-10'
                                : 'border border-gray-200 shadow-sm' }}">

                    @if ($guide['featured'])
                        <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 bg-primary rounded-md text-white text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest z-20">
                            Most Popular
                        </span>
                    @endif

                    {{-- Foto Guide --}}
                    <div class="relative w-full h-56">
                        <img src="{{ asset('img/Guide helping climber.png') }}" alt="{{ $guide['title'] }}" class="w-full h-full object-cover" />
                        @unless ($guide['featured'])
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $guide['badgeClass'] }}">
                                {{ $guide['badge'] }}
                            </span>
                        @endunless
                    </div>

                    {{-- Konten --}}
                    <div class="p-6 flex flex-col flex-1">
                        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $guide['title'] }}</h3>
                        <span class="block mb-5">
                            <span class="text-primary text-2xl font-bold">{{ $guide['price'] }}</span>
                            <span class="text-gray-400 text-sm">/hari</span>
                        </span>

                        <ul class="flex flex-col gap-3 mb-6">
                            @foreach ($guide['features'] as $feature)
                                <li class="flex items-start gap-3 text-sm {{ $feature['bold'] ? 'text-gray-900 font-bold' : 'text-gray-700' }}">
                                    {!! $checkIcon !!}
                                    {{ $feature['label'] }}
                                </li>
                            @endforeach
                        </ul>

                        <a href="/konfirmasi-booking-guide" class="mt-auto w-full bg-secondary-400 hover:bg-secondary-500 rounded-lg py-3 flex items-center justify-center gap-2 font-bold text-surface-dark text-sm transition-colors">
                            Booking Guide
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>