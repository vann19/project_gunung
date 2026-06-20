<div class="relative w-full overflow-hidden">

    {{-- Background Image --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('img/Camping gear setup.png') }}" alt="Layanan Cuci & Perawatan Alat" class="w-full h-full object-cover object-center" />
        {{-- Gradient lembut dari kiri agar teks tetap terbaca di atas foto terang --}}
        <div class="absolute inset-0 bg-gradient-to-r from-surface-soft via-surface-soft/70 to-transparent"></div>
    </div>

    {{-- Konten --}}
    <div class="relative z-10 w-full max-w-[1280px] mx-auto px-6 lg:px-12 py-16 lg:py-24">
        <div class="max-w-xl flex flex-col items-start gap-6">

            {{-- Badge --}}
            <div class="px-4 py-1.5 bg-secondary-400 rounded-full inline-flex items-center gap-1.5">
                <img src="{{ asset('icon/acc cuci.svg') }}" alt="" class="w-3.5 h-3.5" />
                <span class="text-surface-dark text-xs font-bold font-['JetBrains_Mono'] uppercase tracking-widest">
                    Technical Care Specialist
                </span>
            </div>

            {{-- Headline --}}
            <h1 class="text-4xl lg:text-5xl font-bold text-primary leading-[1.15] tracking-tight">
                Layanan Cuci & Perawatan Alat
            </h1>

            {{-- Deskripsi --}}
            <p class="text-gray-600 text-lg leading-relaxed">
                Perpanjang usia teknis gear Anda. Kami menggunakan deterjen khusus Gore-Tex, Down, dan kain teknis lainnya untuk menjaga performa waterproof dan breathability tetap optimal.
            </p>

            {{-- CTA --}}
            <a href="#detail-barang" class="px-6 py-3.5 bg-primary hover:bg-primary/90 rounded-lg inline-flex items-center gap-2 transition-all active:scale-95 shadow-sm">
                <span class="text-white text-base font-bold">Mulai Reservasi</span>
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </a>
        </div>
    </div>
</div>