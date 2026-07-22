<x-layouts.app title="Cuci & Perawatan Alat - {{ config('app.name') }}" description="Layanan cuci dan perawatan teknis untuk gear outdoor Anda.">

    {{-- Hero --}}
    <x-cuci-alat.cuci-hero />

    {{-- Paket Layanan --}}
    <section class="bg-white py-16 px-6">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-12">
                <span class="text-xs font-bold uppercase tracking-widest text-primary">Layanan Kami</span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">Paket Cuci & Perawatan</h2>
                <p class="text-gray-500 text-sm mt-2 max-w-lg mx-auto">Pilih paket yang sesuai dengan kebutuhan gear outdoor Anda. Setiap paket ditangani oleh teknisi berpengalaman.</p>
            </div>

            @if($packages && $packages->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($packages as $pkg)
                        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col">

                            {{-- Gambar --}}
                            <div class="relative h-44 overflow-hidden bg-gray-100">
                                <img src="{{ img_url($pkg->image, 'img/Camping gear setup.png') }}"
                                     alt="{{ $pkg->name }}"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                @if($pkg->is_recommended)
                                    <span class="absolute top-3 left-3 bg-yellow-400 text-gray-900 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">★ Rekomendasi</span>
                                @endif
                                <span class="absolute bottom-3 left-3 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-2.5 py-1 rounded-full border border-white/30">{{ $pkg->duration }}</span>
                            </div>

                            {{-- Info --}}
                            <div class="p-5 flex flex-col flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $pkg->name }}</h3>
                                <p class="text-gray-500 text-sm leading-relaxed flex-1">{{ $pkg->description }}</p>
                                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-primary font-bold text-lg">{{ $pkg->price }}</span>
                                        <span class="text-gray-400 text-xs ml-1">{{ $pkg->unit }}</span>
                                    </div>
                                    <a href="https://wa.me/6281227387668?text=Halo,%20saya%20ingin%20tanya%20paket%20{{ urlencode($pkg->name) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1.5 bg-primary hover:bg-primary/90 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                        Tanya Via WA
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    <p class="text-sm">Paket belum tersedia. Hubungi kami untuk informasi lebih lanjut.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Mengapa Cuci di Sini --}}
    {{-- <section class="bg-[#f4f6f9] py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold text-gray-900">Mengapa Cuci di Sini?</h2>
                <p class="text-gray-500 text-sm mt-2">Kami menggunakan metode & bahan khusus untuk menjaga performa gear Anda.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset('icon/ultrasonic.svg') }}" alt="Ultrasonic" class="w-7 h-7">
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Ultrasonic Cleaning</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Pembersihan hingga serat terdalam tanpa merusak membran teknis Gore-Tex.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset('icon/technical.svg') }}" alt="Technical" class="w-7 h-7">
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Technical Detergent</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Deterjen pH netral khusus outdoor gear yang ramah lingkungan dan aman untuk waterproof coating.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset('icon/cotrolled.svg') }}" alt="Drying" class="w-7 h-7">
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Controlled Drying</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Pengeringan suhu rendah terkontrol untuk menjaga lofting Down tetap optimal.</p>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- Gambar Galeri Cuci Alat --}}
    <section class="bg-white px-6 py-16">
    <div class="mx-auto max-w-6xl">

        {{-- Header --}}
        <div class="mb-10 text-center">
            <h2 class="text-2xl font-bold text-gray-900 md:text-3xl">
                Proses Perawatan
            </h2>

            <p class="mt-2 text-sm text-gray-500 md:text-base">
                Setiap gear ditangani dengan standar profesional.
            </p>
        </div>

        {{-- Gallery --}}
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4 md:gap-6">

            {{-- Gambar 1 --}}
            <div class="group flex aspect-square items-center justify-center overflow-hidden rounded-2xl bg-gray-100 p-3 shadow-sm">
                <img
                    src="{{ asset('img/tas.PNG') }}"
                    alt="Gear cuci 1"
                    class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-105"
                >
            </div>

            {{-- Gambar 2 --}}
            <div class="group flex aspect-square items-center justify-center overflow-hidden rounded-2xl bg-gray-100 p-3 shadow-sm md:translate-y-4">
                <img
                    src="{{ asset('img/baju.png') }}"
                    alt="Gear cuci 2"
                    class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-105"
                >
            </div>

            {{-- Gambar 3 --}}
            <div class="group flex aspect-square items-center justify-center overflow-hidden rounded-2xl bg-gray-100 p-3 shadow-sm">
                <img
                    src="{{ asset('img/tenda.png') }}"
                    alt="Gear cuci 3"
                    class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-105"
                >
            </div>

            {{-- Gambar 4 --}}
            <div class="group flex aspect-square items-center justify-center overflow-hidden rounded-2xl bg-gray-100 p-3 shadow-sm md:translate-y-4">
                <img
                    src="{{ asset('img/tas2.png') }}"
                    alt="Gear cuci 4"
                    class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-105"
                >
            </div>

        </div>
    </div>
</section>

    {{-- CTA --}}
    <section class="bg-primary py-14 px-6 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Siap Antar Gear Anda?</h2>
        <p class="text-white/70 text-sm mb-7 max-w-md mx-auto">Hubungi kami via WhatsApp untuk konsultasi paket dan jadwal pengantaran alat outdoor Anda.</p>
        <a href="https://wa.me/6281227387668?text=Halo,%20saya%20ingin%20info%20layanan%20cuci%20alat%20outdoor"
           target="_blank"
           class="inline-flex items-center gap-2 bg-white text-primary font-bold px-8 py-3.5 rounded-xl text-sm hover:bg-gray-50 transition-colors shadow-lg">
            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
            Hubungi via WhatsApp
        </a>
    </section>

</x-layouts.app>