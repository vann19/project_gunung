<div class="w-full py-20 lg:py-24 text-white relative"
     style="background-image: linear-gradient(to bottom, rgba(8,34,101,0.88), rgba(46,150,237,0.82)), url('{{ asset('img/hutan.png') }}'); background-size: cover; background-position: center;">
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
                    <img class="h-44 w-full object-cover" src="https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Ultimate Expedition Set" />
                </div>
            </div>
            {{-- Content --}}
            <div class="self-stretch flex flex-col justify-start items-start gap-3">
                <div class="self-stretch flex justify-between items-start">
                    <div class=" flex flex-col justify-start items-start">
                        <div class="text-sky-700 text-2xl font-normal  leading-9">Ultimate Expedition<br/>Set</div>
                    </div>
                    <div class="px-2 py-1 bg-yellow-400/60 rounded-sm flex flex-col justify-start items-start">
                        <div class="text-sky-700 text-xs font-normal font-['JetBrains_Mono'] leading-4">POPULER</div>
                    </div>
                </div>
                <div class="self-stretch">
                    <div class="text-stone-900/75 text-base font-normal  leading-6">Paket lengkap tenda 4 musim, sleeping bag,dan peralatan masak ultralight.</div>
                </div>
                <div class="self-stretch pt-4 border-t border-gray-500/30 flex justify-between items-center">
                    <div class="relative">
                        <span class="text-yellow-400 text-base font-black font-['Hanken_Grotesk'] leading-6">Rp 250k </span>
                        <span class="text-stone-900/75 text-xs font-normal font-['Hanken_Grotesk'] leading-4">/hari</span>
                    </div>
                    <button class="p-2 bg-sky-700/20 hover:bg-sky-700/30 rounded-lg flex justify-center items-center transition-colors">
                        <svg class="w-5 h-5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </button>
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
                <h4 class="text-primary text-xl font-semibold">Grill & Chill Kit</h4>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Sempurna untuk piknik santai di kaki gunung atau area perkemahan keluarga.
                </p>
                <a href="#" class="inline-flex items-center gap-2 text-primary font-medium text-sm mt-2 font-['JetBrains_Mono'] hover:text-primary transition-colors">
                    Detail <span class="text-lg leading-none">&rarr;</span>
                </a>
            </div>

            {{-- Advanced Hydropack --}}
            <div class="w-full p-6 bg-white rounded-2xl border border-gray-100 flex flex-col gap-3 group hover:-translate-y-1 transition-transform duration-300 shadow-lg">
                <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-gray-500 mb-2">
                    <img src="icon/air.svg" alt="Advanced Hydropack" class="w-full h-full object-contain">
                </div>
                <h4 class="text-primary text-xl font-semibold">Advanced Hydropack</h4>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Sistem hidrasi teknis untuk trail running atau pendakian cepat tektok.
                </p>
                <a href="#" class="inline-flex items-center gap-2 text-primary font-medium text-sm mt-2 font-['JetBrains_Mono'] hover:text-primary transition-colors">
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
                
                {{-- Tags Kategori --}}
                <div class="flex flex-wrap justify-center gap-3 mt-4">
                    <span class="px-4 py-2 bg-primary/15 rounded-full border border-gray-200 text-primary text-xs  hover:bg-primary/40 transition-colors cursor-pointer">Camping</span>
                    <span class="px-4 py-2 bg-primary/15 rounded-full border border-gray-200 text-primary text-xs  hover:bg-primary/40 transition-colors cursor-pointer">Kelompok</span>
                    <span class="px-4 py-2 bg-primary/15 rounded-full border border-gray-200 text-primary text-xs  hover:bg-primary/40 transition-colors cursor-pointer">Masak</span>
                    <span class="px-4 py-2 bg-primary/15 rounded-full border border-gray-200 text-primary text-xs  hover:bg-primary/40 transition-colors cursor-pointer">Makan</span>
                    <span class="px-4 py-2 bg-primary/15 rounded-full border border-gray-200 text-primary text-xs  hover:bg-primary/40 transition-colors cursor-pointer">Piknik</span>
                    <span class="px-4 py-2 bg-primary/15 rounded-full border border-gray-200 text-primary text-xs  hover:bg-primary/40 transition-colors cursor-pointer">Grill</span>
                </div>
            </div>

            <div class="w-full  z-10 mt-6 inline-flex justify-center items-center">
                <a href="/rental" class="w-full  py-4 bg-yellow-500 hover:bg-yellow-400 rounded-xl text-center text-zinc-800 text-base font-bold transition-colors shadow-md">
                    Jelajahi Semua Kategori
                </a>
            </div>
        </div>

    </div>
    
</div>