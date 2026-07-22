@php
    use App\Models\PendakiBergabung;
    $pendaki = PendakiBergabung::orderBy('urutan')->orderBy('id')->get();
    $total   = $pendaki->count();

    $fallback = [
        ['initial' => 'A', 'name' => 'Andi Wijaya',    'trip' => 'Semeru',     'bg' => 'bg-primary',                        'text' => 'text-white',       'foto' => null],
        ['initial' => 'R', 'name' => 'Rina Safitri',   'trip' => 'Rinjani',    'bg' => 'bg-secondary-400',                  'text' => 'text-surface-dark', 'foto' => null],
        ['initial' => 'B', 'name' => 'Bagus Pratama',  'trip' => 'Mount Gede', 'bg' => 'bg-gray-500',                       'text' => 'text-white',       'foto' => null],
        ['initial' => 'S', 'name' => 'Siska Putri',    'trip' => 'Rinjani',    'bg' => 'bg-gray-100 border border-gray-200','text' => 'text-gray-500',    'foto' => null],
        ['initial' => 'F', 'name' => 'Fajri Ramadhan', 'trip' => 'Semeru',     'bg' => 'bg-surface-dark',                   'text' => 'text-white',       'foto' => null],
        ['initial' => 'D', 'name' => 'Dian Lestari',   'trip' => 'Mount Gede', 'bg' => 'bg-secondary-600',                  'text' => 'text-white',       'foto' => null],
    ];

    $items = $pendaki->isNotEmpty() ? $pendaki : collect($fallback);
@endphp

<div class="w-full bg-gray-50 py-16 lg:py-20 px-6">
    <div class="max-w-[1280px] mx-auto">

        {{-- Section Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-12">
            <div>
                <span class="text-xs font-semibold font-['JetBrains_Mono'] uppercase tracking-widest text-primary mb-2 block">Komunitas Pendaki</span>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Pendaki yang Bergabung</h2>
                <p class="text-gray-500">Lihat siapa saja teman seperjalananmu di ekspedisi mendatang.</p>
            </div>
            <div class="text-left md:text-right shrink-0">
                <span class="text-gray-400 text-xs font-medium font-['JetBrains_Mono'] uppercase tracking-widest block">Total Terdaftar</span>
                <span class="text-primary text-3xl font-bold">{{ $total > 0 ? $total : '128' }}+</span>
                <span class="text-gray-500 text-sm ml-1">Pendaki</span>
            </div>
        </div>

        {{-- Card Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            @foreach ($items as $p)
                @php
                    $isModel  = ($p instanceof \App\Models\PendakiBergabung);
                    $nama     = $isModel ? $p->nama     : $p['name'];
                    $trip     = $isModel ? $p->trip     : $p['trip'];
                    $bgClass  = $isModel ? $p->bg_class : $p['bg'];
                    $txtClass = $isModel ? $p->text_class : $p['text'];
                    $initial  = $isModel ? $p->initial_display : $p['initial'];
                    $fotoUrl  = $isModel ? $p->foto_url : null;
                @endphp

                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">

                    {{-- Bagian Atas: Foto --}}
                    <div class="relative w-full aspect-square overflow-hidden {{ $bgClass }}">
                        @if($fotoUrl)
                            <img src="{{ $fotoUrl }}"
                                 alt="{{ $nama }}"
                                 class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                        @else
                            {{-- Placeholder inisial jika tidak ada foto --}}
                            <div class="w-full h-full flex items-center justify-center {{ $bgClass }} {{ $txtClass }}">
                                <span class="text-5xl font-bold select-none">{{ $initial }}</span>
                            </div>
                        @endif

                        {{-- Badge trip di sudut kiri atas --}}
                        <div class="absolute top-3 left-3">
                            <span class="bg-black/50 backdrop-blur-sm text-white text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full">
                                {{ $trip }}
                            </span>
                        </div>
                    </div>

                    {{-- Bagian Bawah: Informasi --}}
                    <div class="p-4">
                        <p class="text-gray-900 font-bold text-sm leading-snug truncate">{{ $nama }}</p>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <svg class="w-3.5 h-3.5 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            <span class="text-primary text-[11px] font-semibold uppercase tracking-wide truncate">{{ $trip }}</span>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</div>
