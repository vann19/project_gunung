@props(['categories' => collect()])

<div class="w-full py-20 lg:py-24 text-white relative"
     style="background-image: linear-gradient(to bottom, rgba(8,34,101,0.88), rgba(187, 190, 193, 0.82)), url('{{ asset('img/cucialat.jpeg') }}'); background-size: cover; background-position: center;">
    <div class="max-w-[1280px] mx-auto px-6 lg:px-12 flex flex-col gap-12">

        {{-- Section Rental Highlight Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            
            {{-- Bagian Kiri: Judul --}}
            <div class="flex flex-col items-start gap-4 max-w-2xl">
                <h3 class="text-hijau text-2xl lg:text-3xl font-semibold tracking-wide">Rental Highlights</h3>
                <h2 class="text-zinc-200 text-3xl lg:text-4xl xl:text-5xl font-bold leading-tight">
                    Peralatan Pilihan Untuk<br class="hidden md:block"/>
                    Kenyamanan Maksimal
                </h2>
            </div>

            {{-- Bagian Kanan: Link Lihat Semua --}}
            <a href="/rental" class="group flex items-center gap-3 pb-1 border-b-2 border-stone-300/50 hover:border-hijau transition-colors">
                <span class="text-stone-300 group-hover:text-white text-base font-bold transition-colors">Lihat Semua Katalog</span>
                {{-- Icon Panah Kanan (Menggantikan placeholder kotak dari Figma) --}}
                <svg class="w-5 h-5 text-stone-300 group-hover:text-hijau transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>

        </div>

    </div>

    {{-- Grid Cards --}}
    <div class="max-w-[1280px] mx-auto px-6 lg:px-12 mt-12 mb-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Card 1: Ultimate Expedition Set (Featured) --}}
        <div class="self-stretch px-6 pt-6 pb-14 bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-stone-300/10 backdrop-blur-[6px] flex flex-col justify-start items-start gap-6 hover:-translate-y-1 transition-transform duration-300 shadow-xl">
            {{-- Image --}}
            <div class="self-stretch rounded-xl overflow-hidden">
                <div class="self-stretch h-44 relative overflow-hidden bg-gradient-to-b from-stone-300 to-stone-300">
                    <img class="h-44 w-full object-cover" src="img/ruangan.jpeg" alt="ruangan basecamp outdors" />
                </div>
            </div>
            {{-- Content --}}
           <div class="self-stretch flex flex-col justify-start items-start gap-2 sm:gap-3">
    <div class="self-stretch flex justify-between items-start">
        <div class="flex flex-col justify-start items-start">
            <!-- Judul Responsif -->
            <h2 class="text-sky-700 text-lg sm:text-xl md:text-2xl font-bold sm:font-normal leading-snug sm:leading-9">
                Peralatan camping terlengkap di Jogja Set
            </h2>
        </div>
    </div>
    <div class="self-stretch">
        <!-- Subjudul/Deskripsi Responsif -->
        <p class="text-stone-900/75 text-sm sm:text-base font-normal leading-relaxed sm:leading-6">
            Paket lengkap tenda 4 musim, sleeping bag, dan peralatan masak ultralight.
        </p>
    </div>
</div>
        </div>

        {{-- Card 2: Stacked Smaller Cards --}}
        <div class="w-full flex flex-col gap-6">
            
            {{-- Grill & Chill Kit --}}
            <div class="w-full p-6 bg-white rounded-2xl border border-gray-100 flex flex-col gap-3 group hover:-translate-y-1 transition-transform duration-300 shadow-lg">
                <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-gray-500 mb-2">
                    <img src="icon/pangang.svg" alt="Grill & Chill Kit" class="w-full h-full object-contain">
                </div>
                <h4 class="text-primary text-xl font-semibold">Paket Grill dan piknik</h4>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Sempurna untuk piknik santai di kaki gunung atau area perkemahan keluarga.
                </p>
                <a href="/rental?category=grill" class="inline-flex items-center gap-2 text-primary font-medium text-sm mt-2 font-['JetBrains_Mono'] hover:text-primary transition-colors">
                    Detail <span class="text-lg leading-none">&rarr;</span>
                </a>
            </div>

            {{-- Advanced Hydropack --}}
            <div class="w-full p-6 bg-white rounded-2xl border border-gray-100 flex flex-col gap-3 group hover:-translate-y-1 transition-transform duration-300 shadow-lg">
                <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-gray-500 mb-2">
                    <img src="icon/air.svg" alt="Advanced Hydropack" class="w-full h-full object-contain">
                </div>
                <h4 class="text-primary text-xl font-semibold">Laundry Tenda dan alat camping   </h4>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Sistem hidrasi teknis untuk trail running atau pendakian cepat tektok.
                </p>
                <a href="/service/cuci-alat" class="inline-flex items-center gap-2 text-primary font-medium text-sm mt-2 font-['JetBrains_Mono'] hover:text-primary transition-colors">
                    Detail <span class="text-lg leading-none">&rarr;</span>
                </a>
            </div>

        </div>

        {{-- Card 3: Kategori Rental --}}
        <div class="w-full p-8 flex flex-col items-center gap-10 relative bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-xl h-fit">
            
            {{-- Dekorasi Belakang --}}
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-gray-100 rounded-full blur-[40px] pointer-events-none"></div>
            
            <div class="w-full flex flex-col items-center gap-6 z-10">
                <h3 class="text-gray-800 text-3xl font-semibold text-center mt-2">Kategori Rental</h3>
                
                {{-- Tags Kategori Dinamis dari DB --}}
                <div class="flex flex-wrap justify-center gap-3 mt-4">
                    @php
                        $catLabels = [
                            'camping' => 'Camping',
                            'kelompok' => 'Kelompok',
                            'masak' => 'Masak',
                            'makan' => 'Makan',
                            'piknik' => 'Piknik Santai',
                            'grill' => 'Grill',
                            'pribadi' => 'Pribadi',
                            'hydropack' => 'Hydropack',
                        ];
                    @endphp
                    @forelse ($categories as $cat)
                        <a href="/rental?category={{ urlencode($cat) }}"
                           class="px-4 py-2 bg-primary/15 rounded-full border border-gray-200 text-primary text-xs hover:bg-primary/40 transition-colors cursor-pointer">
                            {{ $catLabels[$cat] ?? ucfirst($cat) }}
                        </a>
                    @empty
                        <span class="text-stone-400 text-sm">Belum ada kategori tersedia.</span>
                    @endforelse
                </div>
            </div>

            <div class="w-full  z-10 mt-6 inline-flex justify-center items-center">
                <a href="/rental" class="w-full py-4 bg-linear-to-b from-blue-300 to-sky-600 hover:from-blue-400 hover:to-sky-700 hover:scale-[1.02] hover:shadow-lg rounded-xl text-center text-white text-base font-bold transition-all duration-300 shadow-md">
                    Jelajahi Semua Kategori
                </a>
            </div>
        </div>

    </div>
    
</div>