<div class="relative w-full bg-primary flex justify-center overflow-hidden">
    
    {{-- Background Image & Gradient Overlay --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('img/Section.png') }}" alt="Gunung Background" class="w-full h-full object-cover object-center" />
        {{-- Gradient agar teks sebelah kiri tetap terbaca jelas --}}
        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/60 to-transparent"></div>
        {{-- Sedikit gradient dari bawah agar tidak terlalu terpotong --}}
        <div class="absolute inset-0 bg-gradient-to-t from-primary via-transparent to-transparent opacity-80"></div>
    </div>

    {{-- Main Container --}}
    <div class="relative z-10 w-full max-w-[1280px] min-h-[90vh] px-6 lg:px-12 py-20 lg:py-32 flex flex-col md:flex-row items-center justify-between gap-12">
        
        {{-- KIRI: Teks & Tombol --}}
        <div class="w-full md:w-1/2 flex flex-col items-start gap-6">
            {{-- Badge Premium --}}
            <div class="px-4 py-1.5 bg-green-500/20 rounded-full border border-green-500/30 backdrop-blur-sm inline-flex items-center">
                <span class="text-green-400 text-xs font-medium font-['JetBrains_Mono'] uppercase tracking-widest">
                    PREMIUM OUTDOORS
                </span>
            </div>

            {{-- Headline --}}
            <h1 class="text-5xl lg:text-6xl font-bold text-zinc-200 leading-[1.1] tracking-tight">
                Taklukkan Puncak,<br/>
                <span class="text-stone-400 italic">Temukan Jati Dirimu</span>
            </h1>

            {{-- Deskripsi --}}
            <p class="text-stone-300 text-lg leading-relaxed max-w-[500px]">
                Persiapkan ekspedisi Anda dengan peralatan kelas dunia dan panduan profesional dari mereka yang telah menaklukkan puncak-puncak tertinggi Indonesia.
            </p>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-start gap-4 mt-2">
                <a href="/sewa" class="px-8 py-4 bg-hijau hover:bg-hijau/80 rounded-lg flex justify-center items-center gap-2 transition-all active:scale-95 shadow-[0_0_20px_rgba(101,163,13,0.2)]">
                    <span class="text-amber-950 text-base font-bold">Sewa Sekarang</span>
                    {{-- Icon Panah (Placeholder dari kotak HTML) --}}
                    <svg class="w-5 h-5 text-amber-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                
                <a href="/galeri" class="px-8 py-4 rounded-lg border border-stone-400 hover:bg-white/5 text-stone-300 hover:text-white transition-all flex justify-center items-center active:scale-95">
                    <span class="text-base font-bold">Lihat Galeri</span>
                </a>
            </div>
        </div>

        {{-- KANAN/BAWAH: Info Panel (Elevasi, Suhu, Cuaca) --}}
        <div class="absolute bottom-8 lg:bottom-12 right-6 lg:right-12 w-[calc(100%-3rem)] md:w-auto">
            <div class="bg-neutral-800/60 rounded-2xl border border-stone-300/10 backdrop-blur-md p-6 flex items-center gap-6 lg:gap-10 shadow-2xl">
                
                {{-- Elevasi --}}
                <div class="flex flex-col items-center">
                    <span class="text-green-500 text-xs font-medium font-['JetBrains_Mono'] tracking-widest mb-1">ELEVASI</span>
                    <span class="text-zinc-200 text-3xl font-semibold">3.676m</span>
                </div>

                {{-- Garis Pemisah --}}
                <div class="w-px h-12 bg-neutral-600/50"></div>

                {{-- Temp --}}
                <div class="flex flex-col items-center">
                    <span class="text-green-500 text-xs font-medium font-['JetBrains_Mono'] tracking-widest mb-1">TEMP</span>
                    <span class="text-zinc-200 text-3xl font-semibold">4&deg;C</span>
                </div>

                {{-- Garis Pemisah --}}
                <div class="w-px h-12 bg-neutral-600/50"></div>

                {{-- Cuaca --}}
                <div class="flex flex-col items-center">
                    <span class="text-green-500 text-xs font-medium font-['JetBrains_Mono'] tracking-widest mb-1">CUACA</span>
                    {{-- Icon Cuaca (Matahari / Awan) --}}
                    <svg class="w-8 h-8 text-stone-300 mt-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6.995 12c2.893 0 5.234-2.379 5.234-5.31A5.36 5.36 0 0 0 12 5.051a6 6 0 1 1-5.005 6.949z"></path>
                    </svg>
                </div>
                
            </div>
        </div>
        
    </div>
</div>
