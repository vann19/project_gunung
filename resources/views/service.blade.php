<x-layouts.app title="Service - {{ config('app.name') }}"
    description="Layanan lengkap untuk mendukung ekspedisi pendakian Anda.">

    <div class="bg-white min-h-screen">
        {{-- Hero Section --}}
        <section class="relative w-full h-[400px] overflow-hidden">
            <img src="{{ asset('img/background service.png') }}" class="w-full h-full object-cover" alt="Service Hero">
            <div class="absolute inset-0 bg-black/30 flex flex-col justify-center px-16">
                <span class="text-blue-200 font-semibold uppercase tracking-widest text-sm">Logistik Presisi</span>
                <h1 class="text-5xl font-bold text-black mt-2 leading-tight">Tingkatkan Ekspedisi Anda <br> dengan
                    Layanan Ahli.</h1>
                <p class="text-[#404751] mt-4 max-w-xl text-lg opacity-90">Mulai dari perawatan peralatan hingga
                    pemanduan profesional, kami menyediakan fondasi teknis untuk tujuan pendakian Anda.</p>
            </div>
        </section>

        {{-- 2. Main Grid Layout (Bento: 3 kolom, baris saling silang) --}}
        <div class="max-w-7xl mx-auto py-12 px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">

                {{-- ROW 1 --}}

                {{-- Cuci Alat (1/3 lebar) --}}
                <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex flex-col">
                    <div class="w-10 h-10 bg-blue-50 flex items-center justify-center rounded-lg mb-4">
                        <img src="{{ asset('icon/cuci alat.svg') }}" class="w-6 h-6" alt="Icon">
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3">Cuci Alat / Barang</h2>
                    <p class="text-gray-600 mb-4 text-sm">Peralatan teknis membutuhkan perawatan teknis. Layanan
                        pembersihan khusus kami menjaga integritas perlengkapan Gore-Tex dan down Anda.</p>
                    <ul class="space-y-2 mb-6 text-xs font-medium text-gray-700">
                        <li class="flex items-center gap-2">
                            <img src="{{ asset('icon/centang.svg') }}" class="w-4 h-4 flex-shrink-0" alt="check">
                            PEMBERSIHAN MENDALAM ULTRASONIK
                        </li>
                        <li class="flex items-center gap-2">
                            <img src="{{ asset('icon/centang.svg') }}" class="w-4 h-4 flex-shrink-0" alt="check">
                            RE-PROOFER DWR
                        </li>
                        <li class="flex items-center gap-2">
                            <img src="{{ asset('icon/centang.svg') }}" class="w-4 h-4 flex-shrink-0" alt="check">
                            PENGERJAAN CEPAT 48 JAM
                        </li>
                    </ul>
                    <button class="mt-auto bg-[#005a8d] text-white px-6 py-2.5 rounded-md font-semibold hover:bg-[#004a75] transition-colors text-sm">
                        Isi Form Cuci Alat →
                    </button>
                </div>

                {{-- Open Trip (2/3 lebar) --}}
                <div class="lg:col-span-2 relative rounded-lg overflow-hidden min-h-[320px]">
                    <img src="{{ asset('img/gambar service 2.png') }}"
                        class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent p-6 flex flex-col justify-end text-white">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-yellow-400 text-black text-[10px] font-bold px-2 py-1 rounded uppercase">Paling Populer</span>
                            <span class="text-[10px] bg-black/50 px-2 py-1 rounded uppercase">Slot Tersisa: 4</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Open Trip: Everest Base</h3>
                        <p class="text-xs opacity-90 mb-4 leading-relaxed max-w-md">Bergabunglah dengan grup penjelajah pilihan
                            untuk pendakian teknis selama 14 hari. Termasuk logistik, konsumsi, dan protokol keselamatan.</p>
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <span class="text-[10px] uppercase opacity-75 block mb-1">Keberangkatan Berikutnya</span>
                                <div class="font-bold text-xl">24 OKT 2024</div>
                            </div>
                            <button class="bg-white text-gray-900 px-6 py-2.5 rounded-md font-semibold hover:bg-gray-100 text-sm whitespace-nowrap">
                                Lihat Daftar Open Trip
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ROW 2 --}}

                {{-- Guide Pendakian (2/3 lebar) --}}
                <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex flex-col md:flex-row gap-6">
                    <div class="flex-1">
                        <h2 class="text-xl font-bold mb-3 text-gray-900">Guide Pendakian</h2>
                        <p class="text-gray-600 mb-4 text-sm">Pemandu bersertifikat kelas dunia dengan pengalaman lebih
                            dari 10.000+ meter vertikal. Pendampingan pribadi dan pencarian rute ahli untuk keselamatan
                            Anda.</p>
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="border border-gray-200 p-3 rounded-md">
                                <span class="text-[10px] font-bold text-blue-800 uppercase tracking-wider">Paket A</span>
                                <div class="font-bold text-gray-900 text-sm mt-1">Alpine Fast Track</div>
                            </div>
                            <div class="border border-gray-200 p-3 rounded-md">
                                <span class="text-[10px] font-bold text-blue-800 uppercase tracking-wider">Paket B</span>
                                <div class="font-bold text-gray-900 text-sm mt-1">Expert Summit Push</div>
                            </div>
                        </div>
                        <button class="bg-[#005a8d] text-white px-6 py-2.5 rounded-md font-semibold hover:bg-[#004a75] text-sm">
                            Pilih Guide
                        </button>
                    </div>
                    <div class="w-full md:w-48 flex-shrink-0">
                        <div class="relative h-56 rounded-lg overflow-hidden shadow-md border-4 border-white rotate-3">
                            <img src="{{ asset('img/orang.png') }}" class="w-full h-full object-cover" alt="Guide">
                            <div class="absolute bottom-0 left-0 right-0 bg-[#005a8d] text-white text-[10px] py-2 text-center font-bold tracking-widest uppercase">
                                CHIEF GUIDE: MARK V.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Marketplace (1/3 lebar) --}}
                <div class="lg:col-span-1 bg-white p-5 rounded-lg shadow-sm border border-gray-200 flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="bg-yellow-100 p-1.5 rounded">
                            <img src="{{ asset('icon/market.svg') }}" class="w-5 h-5" alt="Marketplace Icon">
                        </div>
                        <h3 class="font-bold text-base">Marketplace</h3>
                        <span class="ml-auto text-[8px] bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-bold uppercase">24 Iklan Baru</span>
                    </div>
                    <p class="text-gray-600 text-xs mb-3">Perlengkapan performa tinggi dengan harga terjangkau. Setiap barang telah diperiksa dan disertifikasi keselamatannya oleh tim kami.</p>
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-sm">Arc'teryx Alpha SV (M)</span>
                            <span class="font-bold text-sm">$146</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-sm">Black Diamond Ice Tool</span>
                            <span class="font-bold text-sm">$120</span>
                        </div>
                    </div>
                    <button class="mt-auto w-full border border-[#005a8d] text-[#005a8d] py-2.5 rounded-md font-semibold hover:bg-blue-50 transition-colors text-sm">
                        Lihat Barang Second
                    </button>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>