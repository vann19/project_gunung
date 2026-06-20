@php
    $pendaki = [
        ['initial' => 'A', 'name' => 'Andi Wijaya',    'trip' => 'Semeru',     'bg' => 'bg-primary',        'text' => 'text-white'],
        ['initial' => 'R', 'name' => 'Rina Safitri',   'trip' => 'Rinjani',    'bg' => 'bg-secondary-400',  'text' => 'text-surface-dark'],
        ['initial' => 'B', 'name' => 'Bagus Pratama',  'trip' => 'Mount Gede', 'bg' => 'bg-gray-500',       'text' => 'text-white'],
        ['initial' => 'S', 'name' => 'Siska Putri',    'trip' => 'Rinjani',    'bg' => 'bg-gray-100 border border-gray-200', 'text' => 'text-gray-500'],
        ['initial' => 'F', 'name' => 'Fajri Ramadhan', 'trip' => 'Semeru',     'bg' => 'bg-surface-dark',   'text' => 'text-white'],
        ['initial' => 'D', 'name' => 'Dian Lestari',   'trip' => 'Mount Gede', 'bg' => 'bg-secondary-600',  'text' => 'text-white'],
    ];
@endphp

<div class="w-full bg-white py-16 lg:py-20 px-6">
    <div class="max-w-[1280px] mx-auto">

        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Pendaki yang Bergabung</h2>
                <p class="text-gray-500">Lihat siapa saja teman seperjalananmu di ekspedisi mendatang.</p>
            </div>
            <div class="text-left md:text-right">
                <span class="text-gray-400 text-xs font-medium font-['JetBrains_Mono'] uppercase tracking-widest">Total Terdaftar:</span>
                <span class="text-primary text-xl font-bold ml-1">128+ Pendaki</span>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($pendaki as $p)
                <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-center gap-3">
                    <div class="w-11 h-11 flex-shrink-0 rounded-full flex items-center justify-center font-bold text-lg {{ $p['bg'] }} {{ $p['text'] }}">
                        {{ $p['initial'] }}
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-gray-900 text-sm font-semibold leading-tight">{{ $p['name'] }}</span>
                        <span class="text-primary text-[10px] font-bold uppercase tracking-wide">{{ $p['trip'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>