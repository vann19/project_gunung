@php
    $calendarIcon = '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M3 10h18M8 3v4M16 3v4"/></svg>';
    $mountainIcon = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20L9 9l4 6 2-3 6 8H3z"/></svg>';
    $chartIcon    = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V9m4 8V5m4 12v-6M5 17v-3"/></svg>';
@endphp

<div class="lg:col-span-3 flex flex-col gap-6">

    {{-- Profil Guide --}}
    <div class="card p-6">
        <div class="flex flex-col sm:flex-row gap-6">
            {{-- Foto + Badge --}}
            <div class="relative w-28 h-28 flex-shrink-0 rounded-xl overflow-hidden mx-auto sm:mx-0">
                <img src="{{ asset('img/guide-aris-wijaya.png') }}" alt="Aris Wijaya" class="w-full h-full object-cover" />
                <span class="absolute bottom-1.5 left-1.5 px-2 py-0.5 bg-secondary-400 rounded-full text-surface-dark text-[10px] font-bold uppercase tracking-wide">Expert</span>
            </div>

            {{-- Info --}}
            <div class="flex-1">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 mb-2">
                    <h2 class="text-xl font-bold text-gray-900">Aris Wijaya</h2>
                    <span class="flex items-center gap-1 text-sm">
                        <svg class="w-4 h-4 text-secondary-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.364 1.118l1.287 3.957c.3.922-.755 1.688-1.538 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.063 9.384c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.285-3.957z"/></svg>
                        <span class="font-bold text-gray-900">4.9</span>
                        <span class="text-gray-400 font-['JetBrains_Mono'] text-xs">(124 Review)</span>
                    </span>
                </div>

                <p class="text-gray-500 text-sm leading-6 mb-5">
                    Spesialis pendakian teknis dengan pengalaman 15 tahun di Seven Summits. Ahli dalam navigasi cuaca ekstrim dan protokol keselamatan internasional.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Sertifikasi</span>
                        <span class="text-gray-900 font-semibold text-sm">IFMGA / UIAGM</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Bahasa</span>
                        <span class="text-gray-900 font-semibold text-sm">ID, EN, JP</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Basecamp</span>
                        <span class="text-gray-900 font-semibold text-sm">Malang, ID</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Diri & Anggota --}}
    <div class="card p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Data Diri & Anggota</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
            <div>
                <label for="nama_lengkap" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Contoh: Aris Wijaya" class="input" />
            </div>
            <div>
                <label for="kontak_whatsapp" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Kontak WhatsApp</label>
                <input type="tel" id="kontak_whatsapp" name="kontak_whatsapp" placeholder="08xxxxxxx" class="input" />
            </div>
        </div>

        <div class="max-w-xs">
            <label for="jumlah_anggota" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Jumlah Anggota Penyewa</label>
            <div class="relative">
                <input type="number" id="jumlah_anggota" name="jumlah_anggota" min="1" value="1" class="input pr-16" />
                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Orang</span>
            </div>
        </div>
    </div>

    {{-- Detail Jadwal Pendakian --}}
    <div class="card p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-5">Detail Jadwal Pendakian</h2>

        {{-- Durasi --}}
        <div class="flex items-center gap-4 bg-gray-100 rounded-xl p-4 mb-5">
            <div class="w-10 h-10 flex-shrink-0 bg-primary rounded-lg flex items-center justify-center">
                {!! $calendarIcon !!}
            </div>
            <div>
                <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-0.5">Durasi Ekspedisi</span>
                <span class="text-gray-900 font-bold">14 Mei - 18 Mei 2026 (5 Hari 4 Malam)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Gunung Semeru --}}
            <div class="border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-3">
                    {!! $mountainIcon !!}
                    <h3 class="font-bold text-gray-900 text-sm">Gunung Semeru</h3>
                </div>
                <div class="flex flex-col gap-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Titik Kumpul:</span>
                        <span class="text-gray-900 font-semibold">Ranu Pani</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tingkat Kesulitan:</span>
                        <span class="text-secondary-600 font-semibold">Advanced</span>
                    </div>
                </div>
            </div>

            {{-- Statistik Jalur --}}
            <div class="border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-3">
                    {!! $chartIcon !!}
                    <h3 class="font-bold text-gray-900 text-sm">Statistik Jalur</h3>
                </div>
                <div class="flex flex-col gap-3">
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-400 font-['JetBrains_Mono'] uppercase tracking-wide">Elevasi</span>
                            <span class="text-primary font-bold font-['JetBrains_Mono']">3,676m</span>
                        </div>
                        <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-400 font-['JetBrains_Mono'] uppercase tracking-wide">Jarak</span>
                        <span class="text-primary font-bold font-['JetBrains_Mono']">18.5km</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>