{{-- Slide-Over Cart Drawer Component --}}
<div
    x-data
    x-show="$store.rentalCart && $store.rentalCart.isOpen"
    x-cloak
    class="relative z-[100]"
    aria-labelledby="slide-over-title"
    role="dialog"
    aria-modal="true"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div
        x-show="$store.rentalCart && $store.rentalCart.isOpen"
        x-transition:enter="ease-in-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
        @click="$store.rentalCart.isOpen = false"
    ></div>

    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                
                {{-- Panel Drawer --}}
                <div
                    x-show="$store.rentalCart && $store.rentalCart.isOpen"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="pointer-events-auto w-screen max-w-md"
                >
                    <div class="flex h-full flex-col bg-white shadow-2xl">
                        
                        {{-- Header Drawer --}}
                        <div class="flex items-center justify-between px-6 py-5 bg-primary text-white">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-white/10 rounded-xl">
                                    <svg class="w-6 h-6 text-kuning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold font-['Hanken_Grotesk'] leading-tight" id="slide-over-title">
                                        Keranjang Sewa
                                    </h2>
                                    <p class="text-xs text-primary-100">Atur barang dan durasi sewa Anda</p>
                                </div>
                            </div>
                            <button
                                type="button"
                                @click="$store.rentalCart.isOpen = false"
                                class="rounded-xl p-2 text-white/80 hover:text-white hover:bg-white/10 transition-colors"
                            >
                                <span class="sr-only">Close panel</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Body: Item Cart List --}}
                        <div class="flex-1 overflow-y-auto px-6 py-6">
                            <template x-if="!$store.rentalCart || $store.rentalCart.items.length === 0">
                                <div class="h-full flex flex-col items-center justify-center text-center py-12">
                                    <div class="w-20 h-20 bg-stone-100 rounded-full flex items-center justify-center mb-4 text-stone-400">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-stone-700">Keranjang Masih Kosong</h3>
                                    <p class="text-xs text-stone-500 mt-1 max-w-[220px]">
                                        Silakan pilih peralatan camping atau pendakian yang ingin Anda sewa dari katalog.
                                    </p>
                                    <button
                                        type="button"
                                        @click="$store.rentalCart.isOpen = false"
                                        class="mt-6 px-6 py-2.5 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 transition-all shadow-sm"
                                    >
                                        Mulai Belanja Gear
                                    </button>
                                </div>
                            </template>

                            <template x-if="$store.rentalCart && $store.rentalCart.items.length > 0">
                                <div class="space-y-4">
                                    <template x-for="item in $store.rentalCart.items" :key="item.slug + '-' + (item.variant_id || 'base')">
                                        <div class="flex flex-col gap-3 p-4 rounded-2xl border border-stone-200/80 bg-stone-50/50 hover:bg-white hover:shadow-md transition-all">
                                            <div class="flex items-start gap-3.5">
                                                <img :src="item.image" :alt="item.title" class="w-16 h-16 rounded-xl object-cover bg-stone-200 shrink-0 border border-stone-200/60" />
                                                
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start justify-between gap-2">
                                                        <h4 class="text-sm font-bold text-primary truncate" x-text="item.title"></h4>
                                                        <button
                                                            type="button"
                                                            @click="$store.rentalCart.remove(item.slug, item.variant_id)"
                                                            class="text-stone-400 hover:text-rose-600 transition-colors p-1"
                                                            title="Hapus item"
                                                        >
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="flex gap-1.5 mt-0.5 mb-1 text-[10px] font-bold uppercase tracking-wider text-stone-500 flex-wrap">
                                                        <span class="bg-stone-200/60 px-2 py-0.5 rounded" x-text="item.category"></span>
                                                        <template x-if="item.variant_name">
                                                            <span class="bg-primary/10 text-primary px-2 py-0.5 rounded" x-text="'Varian: ' + item.variant_name"></span>
                                                        </template>
                                                    </div>
                                                    
                                                    <div class="mt-1 text-xs font-semibold text-stone-600">
                                                        <span x-text="item.price"></span> <span class="text-stone-400 font-normal">/ hari</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pt-3 border-t border-stone-200/60 flex items-center justify-between">
                                                <div class="flex items-center gap-1 bg-white border border-stone-200 rounded-xl p-1 shadow-2xs">
                                                    <button
                                                        type="button"
                                                        @click="$store.rentalCart.decrementQuantity(item.slug, item.variant_id)"
                                                        class="w-7 h-7 rounded-lg bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold flex items-center justify-center transition-colors"
                                                    >
                                                        -
                                                    </button>
                                                    <div class="px-3 text-center">
                                                        <span class="text-xs font-bold text-primary" x-text="item.quantity || item.days || 1"></span>
                                                        <span class="text-[10px] text-stone-500 block -mt-0.5">Barang</span>
                                                    </div>
                                                    <button
                                                        type="button"
                                                        @click="$store.rentalCart.incrementQuantity(item.slug, item.variant_id)"
                                                        class="w-7 h-7 rounded-lg bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold flex items-center justify-center transition-colors"
                                                        :disabled="item.stock && (item.quantity || item.days || 1) >= item.stock"
                                                    >
                                                        +
                                                    </button>
                                                </div>
                                                <div class="flex flex-col items-end gap-0.5 text-xs">
                                                    <span class="font-semibold text-stone-600">Sisa Stok:</span>
                                                    <span class="font-bold font-['JetBrains_Mono'] text-emerald-600" x-text="item.stock || 'Tersedia'"></span>
                                                </div>
                                            </div>

                                            {{-- Subtotal --}}
                                            <div class="flex justify-between items-center text-xs font-bold pt-1 text-stone-800">
                                                <span class="text-stone-500 font-medium">Subtotal Barang:</span>
                                                <span class="text-secondary-600 font-['Hanken_Grotesk'] text-sm" x-text="$store.rentalCart.formatPrice(item.priceNum * (item.quantity || item.days || 1))"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                        {{-- Footer: Total Tagihan & Checkout --}}
                        <div
                            x-show="$store.rentalCart && $store.rentalCart.items.length > 0"
                            class="border-t border-stone-200 px-6 py-6 bg-stone-50"
                        >
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <span class="text-xs font-medium text-stone-500 block">Total Tagihan</span>
                                    <span class="text-xs text-stone-400">Total <span x-text="$store.rentalCart.itemCount"></span> alat</span>
                                </div>
                                <span class="text-2xl font-black text-secondary-500 font-['Hanken_Grotesk']" x-text="$store.rentalCart.formatPrice($store.rentalCart.totalPrice)"></span>
                            </div>

                            <div class="space-y-2.5">
                                <a
                                    href="/rental/biodata"
                                    class="w-full py-3.5 bg-linear-to-b from-kuning to-secondary-600 hover:from-kuning/90 hover:to-secondary-600/90 rounded-xl text-center text-zinc-800 text-sm font-bold transition-all duration-300 shadow-md hover:shadow-lg block active:scale-[0.98]"
                                >
                                    Lanjutkan Checkout QRIS
                                </a>
                                <button
                                    type="button"
                                    @click="$store.rentalCart.clear()"
                                    class="w-full py-2.5 bg-white border border-stone-200 hover:bg-rose-50 hover:text-rose-600 text-stone-500 rounded-xl text-xs font-bold transition-colors"
                                >
                                    Kosongkan Keranjang
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
