@php
    // Nomor WhatsApp penjual — ambil dari item, fallback ke nomor default
    $waNumber = $item->whatsapp_number ?: '6281227387668';

    // Resolusi URL gambar
    $imgSrc = $item->image
        ? ((str_starts_with($item->image, '/') || str_starts_with($item->image, 'http'))
            ? asset(ltrim($item->image, '/'))
            : asset('img/' . $item->image))
        : asset('img/camping.png');

    // Badge warna
    $badgeClass = $item->badge_class ?: 'bg-white text-gray-700 border border-gray-200';
@endphp

<x-layouts.app
    title="{{ $item->title }} — Marketplace {{ config('app.name') }}"
    description="{{ $item->spec ?? 'Perlengkapan outdoor bekas berkualitas.' }}"
>

    {{-- Breadcrumb --}}
    <div class="bg-white border-b border-gray-100 px-6 lg:px-12 py-4 mt-16 lg:mt-20">
        <div class="max-w-[1280px] mx-auto flex items-center gap-2 text-sm text-gray-400">
            <a href="/" class="hover:text-primary transition-colors">Home</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="/service/marketplace" class="hover:text-primary transition-colors">Marketplace</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 font-medium truncate max-w-[200px]">{{ $item->title }}</span>
        </div>
    </div>

    {{-- Main Content --}}
    <section class="bg-gray-50 min-h-screen px-6 lg:px-12 py-10 lg:py-14">
        <div class="max-w-[1280px] mx-auto">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start">

                {{-- ===== KIRI: Foto Produk ===== --}}
                <div class="space-y-4">
                    {{-- Foto Utama --}}
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm aspect-square flex items-center justify-center p-6 lg:p-10">
                        <img
                            src="{{ $imgSrc }}"
                            alt="{{ $item->title }}"
                            class="w-full h-full object-contain"
                        >
                    </div>

                    {{-- Info tambahan mobile — tampil di bawah foto di HP --}}
                    <div class="lg:hidden bg-white rounded-2xl border border-gray-200 p-5 space-y-1">
                        <p class="text-xs text-gray-400 font-['JetBrains_Mono'] uppercase tracking-widest">Kategori</p>
                        <p class="font-semibold text-gray-700 capitalize">{{ str_replace(['tents','backpacks','clothing','footwear'], ['Tents','Backpacks','Clothing','Footwear'], $item->category) }}</p>
                    </div>
                </div>

                {{-- ===== KANAN: Info Produk ===== --}}
                <div class="space-y-6">

                    {{-- Badge kondisi + kategori --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide {{ $badgeClass }}">
                            {{ $item->condition_badge }}
                        </span>
                        <span class="px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 capitalize">
                            {{ str_replace(['tents','backpacks','clothing','footwear'], ['Tents','Backpacks','Clothing','Footwear'], $item->category) }}
                        </span>
                        @if ($item->stock <= 0)
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide bg-rose-100 text-rose-600">
                                Habis
                            </span>
                        @else
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide bg-slate-800 text-white">
                                Sisa Stok: {{ $item->stock }}
                            </span>
                        @endif
                    </div>

                    {{-- Nama produk --}}
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 leading-snug">{{ $item->title }}</h1>
                        @if($item->spec)
                            <p class="text-gray-400 text-sm font-['JetBrains_Mono'] uppercase tracking-wide mt-2">{{ $item->spec }}</p>
                        @endif
                    </div>

                    {{-- Harga --}}
                    <div class="flex items-baseline gap-3">
                        <span class="text-3xl font-bold text-primary">{{ $item->price }}</span>
                        @if($item->old_price)
                            <span class="text-gray-400 text-base line-through">{{ $item->old_price }}</span>
                            @php
                                // Hitung diskon jika harga berupa angka
                                $priceNum    = (int) preg_replace('/[^0-9]/', '', $item->price);
                                $oldPriceNum = (int) preg_replace('/[^0-9]/', '', $item->old_price);
                                $discount    = ($oldPriceNum > 0 && $priceNum > 0)
                                    ? round((1 - $priceNum / $oldPriceNum) * 100)
                                    : 0;
                            @endphp
                            @if($discount > 0)
                                <span class="px-2 py-0.5 bg-rose-100 text-rose-600 text-xs font-bold rounded-lg">-{{ $discount }}%</span>
                            @endif
                        @endif
                    </div>

                    {{-- Deskripsi --}}
                    @if($item->description)
                        <div class="bg-white rounded-2xl border border-gray-200 p-5">
                            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Deskripsi Produk</h2>
                            <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $item->description }}</div>
                        </div>
                    @else
                        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex gap-3">
                            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-amber-700 text-sm">Hubungi penjual via WhatsApp untuk informasi kondisi detail, kelengkapan barang, dan negosiasi harga.</p>
                        </div>
                    @endif

                    {{-- Garansi / Info Transaksi --}}
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-white rounded-xl border border-gray-200 p-3 text-center">
                            <svg class="w-5 h-5 mx-auto text-primary mb-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <p class="text-[10px] font-semibold text-gray-600 leading-tight">Barang Terverifikasi</p>
                        </div>
                        <div class="bg-white rounded-xl border border-gray-200 p-3 text-center">
                            <svg class="w-5 h-5 mx-auto text-primary mb-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <p class="text-[10px] font-semibold text-gray-600 leading-tight">Chat Langsung</p>
                        </div>
                        <div class="bg-white rounded-xl border border-gray-200 p-3 text-center">
                            <svg class="w-5 h-5 mx-auto text-primary mb-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <p class="text-[10px] font-semibold text-gray-600 leading-tight">Transfer Manual</p>
                        </div>
                    </div>

                    {{-- ===== TOMBOL PESAN VIA WHATSAPP ===== --}}
                    <div class="space-y-3 pt-2">
                        @if ($item->stock > 0)
                            <a
                                id="wa-btn"
                                href="#"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="w-full flex items-center justify-center gap-3 py-4 px-6 rounded-2xl font-bold text-white text-base transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-green-500/25"
                                style="background-color: #25D366;"
                            >
                                {{-- WhatsApp Icon --}}
                                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                Pesan via WhatsApp
                            </a>
                        @else
                            <button
                                disabled
                                class="w-full flex items-center justify-center gap-3 py-4 px-6 rounded-2xl font-bold text-white text-base bg-gray-300 cursor-not-allowed"
                            >
                                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm4.207 12.793l-1.414 1.414L12 13.414l-2.793 2.793-1.414-1.414L10.586 12 7.793 9.207l1.414-1.414L12 10.586l2.793-2.793 1.414 1.414L13.414 12l2.793 2.793z"></path>
                                </svg>
                                Stok Habis
                            </button>
                        @endif

                        <a
                            href="/service/marketplace"
                            class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-2xl font-semibold text-gray-600 text-sm border border-gray-200 bg-white hover:bg-gray-50 transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali ke Marketplace
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </section>

    {{-- Script: bangun URL WhatsApp secara dynamic --}}
    <script>
        (function () {
            // Nomor WA penjual — fallback ke default jika item tidak punya nomor
            var SELLER_WHATSAPP = "{{ $waNumber }}";

            var productName = @json($item->title);
            var productPrice = @json($item->price);

            var message = "Halo, saya tertarik dengan *" + productName + "* seharga *" + productPrice + "*, apakah masih tersedia?";

            var waUrl = "https://wa.me/" + SELLER_WHATSAPP + "?text=" + encodeURIComponent(message);

            document.getElementById('wa-btn').href = waUrl;
        })();
    </script>

</x-layouts.app>
