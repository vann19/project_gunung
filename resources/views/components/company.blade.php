<div class="w-full py-20 lg:py-32 bg-primary text-white overflow-hidden relative">
    
    {{-- Container --}}
    <div class="max-w-[1280px] mx-auto px-6 lg:px-12 flex flex-col lg:flex-row-reverse items-center gap-16 lg:gap-24 relative z-10">
        
        {{-- KANAN (Visual): Teks & Info --}}
        <div class="w-full lg:w-1/2 flex flex-col items-start gap-8">
            
            {{-- Header Title --}}
            <div class="flex flex-col gap-4">
                <h3 class="text-stone-300 text-2xl lg:text-3xl font-semibold tracking-wide">Company Profile</h3>
                <div class="w-20 h-1.5 bg-hijau rounded-full shadow-[0_0_10px_rgba(40,216,0,0.5)]"></div>
            </div>
            
            {{-- Headline --}}
            <h2 class="text-zinc-200 text-4xl lg:text-5xl font-bold leading-tight">
                Visi Kami Adalah<br class="hidden lg:block"/>
                Memberdayakan Sang<br class="hidden lg:block"/>
                Penjelajah
            </h2>
            
            {{-- Deskripsi --}}
            <p class="text-stone-300 text-lg leading-relaxed">
                Di Basecamp Outdoors, kami percaya bahwa setiap pendakian adalah perjalanan spiritual. Misi kami bukan sekadar menyewakan alat, tapi memastikan keamanan dan kenyamanan Anda di medan tersulit sekalipun.
            </p>
            
            {{-- List Poin-poin --}}
            <div class="flex flex-col gap-5 mt-2">
                
                {{-- Item 1 --}}
                <div class="flex items-center gap-4 group">
                    <img src="{{ asset('icon/acc.svg') }}" alt="Check" class="w-6 h-6 flex-shrink-0 transition-transform group-hover:scale-110" />
                    <span class="text-zinc-200 text-lg">Peralatan Standar Internasional (UIAA)</span>
                </div>
                
                {{-- Item 2 --}}
                <div class="flex items-center gap-4 group">
                    <img src="{{ asset('icon/acc.svg') }}" alt="Check" class="w-6 h-6 flex-shrink-0 transition-transform group-hover:scale-110" />
                    <span class="text-zinc-200 text-lg">Pemandu Bersertifikat & Berpengalaman</span>
                </div>
                
                {{-- Item 3 --}}
                <div class="flex items-center gap-4 group">
                    <img src="{{ asset('icon/acc.svg') }}" alt="Check" class="w-6 h-6 flex-shrink-0 transition-transform group-hover:scale-110" />
                    <span class="text-zinc-200 text-lg">Komitmen Kelestarian Lingkungan</span>
                </div>
                
            </div>
        </div>

        {{-- KIRI (Visual): Gambar & Dekorasi --}}
        <div class="w-full lg:w-1/2 relative mt-10 lg:mt-0">
            
            {{-- Dekorasi Glow Blur di Kanan Bawah --}}
            <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-stone-300/10 rounded-full blur-[40px] z-0 pointer-events-none"></div>
            
            {{-- Dekorasi Garis Siku di Kiri Atas --}}
            <div class="absolute -top-6 -left-6 w-24 h-24 opacity-60 rounded-tl-3xl border-l-2 border-t-2 border-stone-400 z-0 pointer-events-none transition-all duration-500 hover:-translate-x-2 hover:-translate-y-2"></div>
            
            {{-- Gambar Utama --}}
            <div class="relative z-10 w-full rounded-2xl shadow-2xl overflow-hidden aspect-[4/3] group">
                {{-- Overlay gelap transparan saat di-hover --}}
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300 z-20"></div>
                
                {{-- Menggunakan gambar placeholder yang lebih natural (unsplash) --}}
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                     src="https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                     alt="Company Profile Image" />
            </div>
            
        </div>
        
    </div>
</div>
