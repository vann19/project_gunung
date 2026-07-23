@php
    $categories = [
        ['id' => 'camping', 'label' => 'Camping', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['id' => 'kelompok', 'label' => 'Kelompok', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['id' => 'masak', 'label' => 'Masak', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ['id' => 'makan', 'label' => 'Makan', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
        ['id' => 'piknik', 'label' => 'Piknik Santai', 'icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z'],
        ['id' => 'grill', 'label' => 'Grill', 'icon' => 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z'],
        ['id' => 'pribadi', 'label' => 'Pribadi', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        ['id' => 'hydropack', 'label' => 'Hydropack', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
        ['id' => 'carrier', 'label' => 'Carrier', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
    ];

@endphp

<x-layouts.app title="Rental Alat - {{ config('app.name') }}" description="Sewa berbagai peralatan camping dan pendakian kualitas terbaik.">

    {{-- Hero --}}
    <section
        class="relative w-full pt-28 pb-16 lg:pb-20 px-6 lg:px-12 overflow-hidden"
        style="background-image: linear-gradient(to bottom, rgba(8,34,101,0.75), rgba(46,150,237,0.65)), url('{{ asset('img/rinjani.png') }}'); background-size: cover; background-position: center;"
    >
        <div class="max-w-[1280px] mx-auto text-center text-white">
            <span class="inline-block px-4 py-1.5 mb-4 text-xs font-bold font-['JetBrains_Mono'] uppercase tracking-[0.2em] bg-white/10 backdrop-blur-sm rounded-full border border-white/20">
                Rental Gear
            </span>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight max-w-3xl mx-auto">
                Sewa Perlengkapan Terbaik untuk Petualangan Anda
            </h1>
            <p class="mt-4 text-base md:text-lg text-white/80 max-w-2xl mx-auto leading-relaxed">
                Dari tenda hingga carrier — semua peralatan outdoor berkualitas, terawat, dan siap menemani setiap langkah menuju puncak.
            </p>
        </div>
    </section>

    {{-- Konten Utama --}}
    <section
        class="bg-surface-soft py-12 lg:py-16 px-6 lg:px-12"
        x-data="{
            activeCategory: new URLSearchParams(window.location.search).get('category') || 'all',
            productCategories: {{ Js::from(collect($products)->pluck('category')->unique()->values()) }},
            matches(category) {
                return this.activeCategory === 'all' || this.activeCategory === category;
            },
            hasResults() {
                return this.activeCategory === 'all' || this.productCategories.includes(this.activeCategory);
            },
        }"
    >
        <div class="max-w-[1280px] mx-auto flex flex-col lg:flex-row gap-8 lg:gap-10">

            {{-- Sidebar Kategori --}}
            <aside class="lg:w-72 shrink-0" x-data="{ mobileOpen: false }">

                {{-- ===== MOBILE: Dropdown Trigger ===== --}}
                <div class="lg:hidden">
                    <button
                        type="button"
                        @click="mobileOpen = !mobileOpen"
                        class="w-full flex items-center justify-between gap-3 bg-white border border-stone-200 rounded-2xl px-5 py-4 shadow-sm text-sm font-semibold text-stone-700 transition hover:border-primary/40"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            <span>
                                Filter Kategori:
                                <span class="text-primary font-bold" x-text="
                                    activeCategory === 'all' ? 'Semua Kategori' :
                                    @foreach($categories as $cat)
                                    activeCategory === '{{ $cat['id'] }}' ? '{{ $cat['label'] }}' :
                                    @endforeach
                                    'Semua Kategori'
                                "></span>
                            </span>
                        </div>
                        <svg
                            class="w-4 h-4 text-stone-400 transition-transform duration-200 shrink-0"
                            :class="mobileOpen ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown Panel --}}
                    <div
                        x-show="mobileOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="mt-2 bg-white border border-stone-200 rounded-2xl shadow-lg p-3 z-20"
                        x-cloak
                    >
                        <ul class="flex flex-col gap-1">
                            <li>
                                <button
                                    type="button"
                                    @click="activeCategory = 'all'; mobileOpen = false"
                                    :class="activeCategory === 'all' ? 'bg-birumuda/60 text-primary font-bold' : 'text-stone-600 hover:bg-stone-50'"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors text-left"
                                >
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                    </svg>
                                    Semua Kategori
                                </button>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <button
                                        type="button"
                                        @click="activeCategory = '{{ $category['id'] }}'; mobileOpen = false"
                                        :class="activeCategory === '{{ $category['id'] }}' ? 'bg-birumuda/60 text-primary font-bold' : 'text-stone-600 hover:bg-stone-50'"
                                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors text-left"
                                    >
                                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $category['icon'] }}"/>
                                        </svg>
                                        {{ $category['label'] }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                        <a
                            href="#katalog"
                            @click="mobileOpen = false"
                            class="mt-3 w-full block py-3 bg-linear-to-b from-kuning to-secondary-600 hover:from-kuning/90 hover:to-secondary-600/90 rounded-xl text-center text-zinc-800 text-sm font-bold transition-all duration-300 shadow-sm active:scale-[0.98]"
                        >
                            Lihat Semua Perlengkapan
                        </a>
                    </div>
                </div>

                {{-- ===== DESKTOP: Sidebar Sticky ===== --}}
                <div class="hidden lg:block bg-white rounded-2xl border border-stone-200/60 shadow-sm p-6 lg:sticky lg:top-28">
                    <h2 class="text-primary text-xl font-bold">Rental Categories</h2>
                    <p class="text-stone-500 text-sm mt-1 mb-6">Gear for every peak.</p>

                    <ul class="flex flex-col gap-1">
                        <li>
                            <button
                                type="button"
                                @click="activeCategory = 'all'"
                                :class="activeCategory === 'all' ? 'bg-birumuda/60 text-primary font-bold' : 'text-stone-600 hover:bg-stone-50'"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors text-left"
                            >
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                Semua Kategori
                            </button>
                        </li>
                        @foreach ($categories as $category)
                            <li>
                                <button
                                    type="button"
                                    @click="activeCategory = '{{ $category['id'] }}'"
                                    :class="activeCategory === '{{ $category['id'] }}' ? 'bg-birumuda/60 text-primary font-bold' : 'text-stone-600 hover:bg-stone-50'"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors text-left"
                                >
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $category['icon'] }}"/>
                                    </svg>
                                    {{ $category['label'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    
                </div>
            </aside>

            {{-- Area Produk --}}
            <div class="flex-1 min-w-0" id="katalog">

                {{-- Featured Product --}}
                
                {{-- Grid Produk --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <div x-show="matches('{{ $product->category }}')" x-transition>
                            <x-rental.alat
                                :title="$product->title"
                                :slug="$product->slug"
                                :category="$product->category"
                                :price="$product->price"
                                :description="$product->description"
                                :image="img_url($product->main_image)"
                                :popular="$product->is_popular"
                                :condition="$product->condition_badge ?? 'Baru'"
                                :variants="$product->variants"
                                :href="route('rental.show', ['category' => $product->category, 'slug' => $product->slug])"
                            />
                        </div>
                    @endforeach
                </div>

                {{-- Empty State --}}
                <p
                    x-show="!hasResults()"
                    x-cloak
                    class="text-center text-stone-400 py-16 text-sm"
                >
                    Tidak ada perlengkapan di kategori ini.
                </p>

            </div>
        </div>
    </section>

    {{-- Floating Cart Button (Melayang di Pojok Kanan Bawah) --}}
    <div
        x-data
        x-show="$store.rentalCart && $store.rentalCart.itemCount > 0"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 translate-y-10 scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-10 scale-90"
        class="fixed bottom-24 lg:bottom-8 right-6 z-40"
        style="display: none;"
    >
        <button
            type="button"
            @click="$store.rentalCart.isOpen = true"
            class="group flex items-center gap-3 bg-primary hover:bg-primary/90 text-white px-5 py-3.5 rounded-full shadow-2xl border-2 border-kuning/30 transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer"
        >
            <div class="relative">
                <svg class="w-6 h-6 text-kuning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span
                    class="absolute -top-2 -right-2 bg-rose-600 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm animate-bounce"
                    x-text="$store.rentalCart.itemCount"
                ></span>
            </div>
            <div class="flex flex-col text-left">
                <span class="text-[10px] text-kuning font-bold uppercase tracking-wider leading-none">Keranjang Sewa</span>
                <span class="text-sm font-black font-['Hanken_Grotesk'] leading-tight mt-0.5" x-text="$store.rentalCart.formatPrice($store.rentalCart.totalPrice)"></span>
            </div>
        </button>
    </div>

</x-layouts.app>
