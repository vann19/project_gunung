<div class="w-full py-20 lg:py-24 bg-surface-dark text-white font-['Hanken_Grotesk']">
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
        <div class="w-full flex flex-col bg-neutral-800/70 rounded-2xl border border-stone-300/10 backdrop-blur-[6px] overflow-hidden group hover:-translate-y-1 transition-transform duration-300 shadow-xl">
            <div class="p-6 pb-0">
                <div class="w-full rounded-xl overflow-hidden aspect-[16/9]">
                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Ultimate Expedition Set" />
                </div>
            </div>
            <div class="p-6 flex flex-col flex-1 gap-4">
                <div class="flex justify-between items-start gap-4">
                    <h4 class="text-zinc-200 text-2xl font-semibold leading-tight">Ultimate Expedition Set</h4>
                    <span class="px-2 py-1 bg-zinc-800 rounded text-neutral-400 text-[10px] font-bold tracking-wider font-['JetBrains_Mono'] mt-1">POPULER</span>
                </div>
                <p class="text-stone-300 text-sm leading-relaxed flex-1">
                    Paket lengkap tenda 4 musim, sleeping bag, dan peralatan masak ultralight.
                </p>
                <div class="pt-4 border-t border-neutral-700/50 flex justify-between items-center mt-2">
                    <div>
                        <span class="text-hijau text-xl font-bold">Rp 250k</span>
                        <span class="text-stone-400 text-xs">/hari</span>
                    </div>
                    <button class="w-10 h-10 bg-neutral-900 hover:bg-black rounded-lg flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Card 2: Stacked Smaller Cards --}}
        <div class="w-full flex flex-col gap-6">
            
            {{-- Grill & Chill Kit --}}
            <div class="w-full p-6 bg-zinc-800/80 rounded-2xl border border-neutral-700/30 flex flex-col gap-3 group hover:-translate-y-1 transition-transform duration-300 shadow-lg">
                <div class="w-10 h-10 rounded-lg bg-stone-300/10 flex items-center justify-center text-stone-300 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path></svg>
                </div>
                <h4 class="text-zinc-200 text-xl font-semibold">Grill & Chill Kit</h4>
                <p class="text-stone-300 text-sm leading-relaxed">
                    Sempurna untuk piknik santai di kaki gunung atau area perkemahan keluarga.
                </p>
                <a href="#" class="inline-flex items-center gap-2 text-hijau font-medium text-sm mt-2 font-['JetBrains_Mono'] hover:text-green-400 transition-colors">
                    Detail <span class="text-lg leading-none">&rarr;</span>
                </a>
            </div>

            {{-- Advanced Hydropack --}}
            <div class="w-full p-6 bg-zinc-800/80 rounded-2xl border border-neutral-700/30 flex flex-col gap-3 group hover:-translate-y-1 transition-transform duration-300 shadow-lg">
                <div class="w-10 h-10 rounded-lg bg-stone-300/10 flex items-center justify-center text-stone-300 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <h4 class="text-zinc-200 text-xl font-semibold">Advanced Hydropack</h4>
                <p class="text-stone-300 text-sm leading-relaxed">
                    Sistem hidrasi teknis untuk trail running atau pendakian cepat tektok.
                </p>
                <a href="#" class="inline-flex items-center gap-2 text-hijau font-medium text-sm mt-2 font-['JetBrains_Mono'] hover:text-green-400 transition-colors">
                    Detail <span class="text-lg leading-none">&rarr;</span>
                </a>
            </div>

        </div>

        {{-- Card 3: Kategori Rental --}}
        <div class="w-full p-8 flex flex-col items-center gap-10 relative bg-neutral-800/70 rounded-2xl border border-stone-300/10 backdrop-blur-[6px] overflow-hidden shadow-xl h-fit">
            
            {{-- Dekorasi Belakang --}}
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-stone-300/5 rounded-full blur-[40px] pointer-events-none"></div>
            
            <div class="w-full flex flex-col items-center gap-6 z-10">
                <h3 class="text-zinc-200 text-3xl font-semibold text-center mt-2">Kategori Rental</h3>
                
                {{-- Tags Kategori --}}
                <div class="flex flex-wrap justify-center gap-3 mt-4">
                    <span class="px-4 py-2 rounded-full border border-stone-300/20 text-zinc-200 text-xs font-['JetBrains_Mono'] bg-white/5 hover:bg-white/10 transition-colors cursor-pointer">Camping</span>
                    <span class="px-4 py-2 rounded-full border border-stone-300/20 text-zinc-200 text-xs font-['JetBrains_Mono'] bg-white/5 hover:bg-white/10 transition-colors cursor-pointer">Kelompok</span>
                    <span class="px-4 py-2 rounded-full border border-stone-300/20 text-zinc-200 text-xs font-['JetBrains_Mono'] bg-white/5 hover:bg-white/10 transition-colors cursor-pointer">Masak</span>
                    <span class="px-4 py-2 rounded-full border border-stone-300/20 text-zinc-200 text-xs font-['JetBrains_Mono'] bg-white/5 hover:bg-white/10 transition-colors cursor-pointer">Makan</span>
                    <span class="px-4 py-2 rounded-full border border-stone-300/20 text-zinc-200 text-xs font-['JetBrains_Mono'] bg-white/5 hover:bg-white/10 transition-colors cursor-pointer">Piknik</span>
                    <span class="px-4 py-2 rounded-full border border-stone-300/20 text-zinc-200 text-xs font-['JetBrains_Mono'] bg-white/5 hover:bg-white/10 transition-colors cursor-pointer">Grill</span>
                </div>
            </div>

            <div class="w-full z-10">
                <a href="/rental" class="w-full block py-4 bg-stone-300 hover:bg-white rounded-xl text-center text-zinc-800 text-base font-bold transition-colors shadow-md">
                    Jelajahi Semua Kategori
                </a>
            </div>
        </div>

    </div>
    
</div>