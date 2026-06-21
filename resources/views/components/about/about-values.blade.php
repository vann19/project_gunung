@php
    $values = [
        [
            'icon'  => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.5 12l1.8 1.8L15 10"/></svg>',
            'title' => 'Keamanan Utama',
            'desc'  => 'Protokol keamanan ketat dan pengecekan alat ganda untuk setiap ekspedisi.',
        ],
        [
            'icon'  => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20L9 9l4 6 2-3 6 8H3z"/></svg>',
            'title' => 'Pemandu Ahli',
            'desc'  => 'Tim profesional bersertifikat dengan pengetahuan mendalam tentang medan lokal.',
        ],
        [
            'icon'  => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21c-4-2-7-6-7-11a7 7 0 0114 0c0 5-3 9-7 11z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12c1.5 1.5 4.5 1.5 6-3-4.5-1.5-6 1.5-6 3z"/></svg>',
            'title' => 'Keberlanjutan',
            'desc'  => 'Mendaki tanpa jejak. Kami berkomitmen penuh pada pelestarian ekosistem gunung.',
        ],
        [
            'icon'  => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.5 9.5l-2 5-3 1.5 2-5 3-1.5z"/></svg>',
            'title' => 'Logistik Presisi',
            'desc'  => 'Perencanaan rute dan manajemen logistik yang akurat hingga detail terkecil.',
        ],
    ];
@endphp

<div class="w-full bg-gray-50 py-16 lg:py-20 px-6">
    <div class="max-w-[1280px] mx-auto">

        <div class="flex flex-col items-center text-center gap-3 mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">Misi & Nilai Kami</h2>
            <span class="w-14 h-1 bg-primary rounded-full"></span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($values as $value)
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <div class="w-11 h-11 bg-primary/8 rounded-xl flex items-center justify-center mb-4">
                        {!! $value['icon'] !!}
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">{{ $value['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-6">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>