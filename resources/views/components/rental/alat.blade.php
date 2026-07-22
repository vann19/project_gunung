@props([
    'title' => '',
    'slug' => '',
    'category' => '',
    'price' => '',
    'unit' => '/qty',
    'description' => '',
    'image' => '',
    'popular' => false,
    'popular' => false,
    'condition' => 'Baru',
    'variants' => [],
    'href' => '#',
])

<div {{ $attributes->merge(['class' => 'group bg-white rounded-2xl border border-stone-200/60 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col']) }}>
    {{-- Gambar Produk --}}
    <div class="relative aspect-[4/3] overflow-hidden bg-stone-100">
        <img
            src="{{ $image }}"
            alt="{{ $title }}"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
        />

        @if ($condition === 'Baru')
            <span class="absolute top-3 left-3 px-2.5 py-1 bg-emerald-600/95 backdrop-blur-xs text-white text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-wider rounded-sm shadow-sm flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span> Baru
            </span>
        @else
            <span class="absolute top-3 left-3 px-2.5 py-1 bg-amber-600/95 backdrop-blur-xs text-white text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-wider rounded-sm shadow-sm flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-200"></span> Second
            </span>
        @endif

        @if ($popular)
            <span class="absolute top-3 right-3 px-2.5 py-1 bg-kuning/90 text-primary text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-wider rounded-sm shadow-sm">
                Populer
            </span>
        @endif
    </div>

    {{-- Konten --}}
    <div class="p-5 flex flex-col flex-1 gap-3">
        <div class="flex items-start justify-between gap-3">
            <h3 class="text-primary text-lg font-bold leading-snug">{{ $title }}</h3>
            <div class="shrink-0 text-right">
                <span class="text-secondary-500 text-base font-black font-['Hanken_Grotesk']">{{ $price }}</span>
                <span class="text-stone-500 text-[10px] font-normal block">{{ $unit }}</span>
            </div>
        </div>

        <p class="text-stone-600/80 text-sm leading-relaxed line-clamp-2 flex-1">
            {{ $description }}
        </p>

        {{-- Aksi --}}
        <div class="flex items-center gap-2 pt-2" x-data="{ 
            showVariantModal: false, 
            showDaysModal: false,
            selectedVariantId: null,
            pendingVariantId: null,
            pendingVariantName: null,
            pendingVariantImage: null,
            pendingStock: 0,
            days: 1,
            init() {
                if ({{ count($variants) > 0 ? 'true' : 'false' }}) {
                    this.selectedVariantId = {{ count($variants) > 0 ? $variants[0]->id : 'null' }};
                }
            },
            openDaysModal(variantId = null, variantName = null, stock = 0, image = null) {
                this.pendingVariantId = variantId;
                this.pendingVariantName = variantName;
                this.pendingVariantImage = image;
                this.pendingStock = stock;
                this.days = 1;
                this.showVariantModal = false;
                this.showDaysModal = true;
            },
            confirmAddToCart() {
                if (this.days < 1) this.days = 1;
                this.$store.rentalCart.add({
                    slug: '{{ $slug }}',
                    title: '{{ addslashes($title) }}',
                    price: '{{ $price }}',
                    image: this.pendingVariantImage || '{{ $image }}',
                    category: '{{ $category }}',
                    variant_id: this.pendingVariantId,
                    variant_name: this.pendingVariantName,
                    stock: this.pendingStock
                }, this.days);
                this.showDaysModal = false;
            }
        }">
            <a
                href="{{ $href }}"
                class="flex-1 py-2.5 bg-linear-to-b from-blue-300 to-sky-600 hover:from-blue-400 hover:to-sky-700 rounded-xl text-center text-white text-sm font-bold transition-all duration-300 active:scale-[0.98]"
            >
                Detail
            </a>
            <button
                type="button"
                @click.prevent="{{ count($variants) > 0 ? 'showVariantModal = true' : 'openDaysModal(null, null, 0)' }}"
                class="p-2.5 bg-sky-700/10 hover:bg-sky-700/20 active:scale-95 rounded-xl flex items-center justify-center transition-all cursor-pointer group/btn relative"
                aria-label="Tambah ke keranjang"
                title="Tambah ke Keranjang"
            >
                <svg class="w-5 h-5 text-primary group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </button>

            {{-- MODAL: Pilih Varian (hanya muncul jika ada varian) --}}
            @if(count($variants) > 0)
            <template x-teleport="body">
                <div x-show="showVariantModal" class="fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="showVariantModal"
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-stone-900/75 backdrop-blur-sm" @click="showVariantModal = false"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="showVariantModal"
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 sm:scale-90" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-8 sm:scale-90"
                             class="relative z-10 inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-stone-200/60">
                            {{-- Header --}}
                            <div class="relative bg-linear-to-br from-primary to-sky-700 px-6 py-7 overflow-hidden">
                                <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                                <div class="relative z-10 flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-2xl bg-white/20 p-1.5 backdrop-blur-md shrink-0 shadow-inner border border-white/20">
                                        <img src="{{ $image }}" class="w-full h-full object-cover rounded-xl" alt="{{ $title }}">
                                    </div>
                                    <div class="pr-6">
                                        <h3 class="text-xl font-black text-white font-['Hanken_Grotesk'] leading-tight mb-1">Pilih Varian</h3>
                                        <p class="text-xs text-sky-100 font-medium line-clamp-2">{{ $title }}</p>
                                    </div>
                                </div>
                                <button type="button" @click="showVariantModal = false" class="absolute top-4 right-4 text-white/70 hover:text-white bg-black/10 hover:bg-black/20 rounded-full p-2 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            {{-- Daftar Varian --}}
                            <div class="bg-white px-6 py-6">
                                <div class="space-y-3 max-h-[45vh] overflow-y-auto pr-2">
                                    @foreach($variants as $v)
                                        <label class="relative flex items-center justify-between p-4 cursor-pointer rounded-2xl border-2 transition-all duration-200 group"
                                               :class="selectedVariantId === {{ $v->id }} ? 'border-primary bg-primary/5 shadow-md scale-[1.01]' : 'border-stone-100 hover:border-primary/30 hover:bg-stone-50'">
                                            <div class="flex items-center gap-3.5">
                                                <div class="relative flex items-center justify-center w-5 h-5 shrink-0">
                                                    <input type="radio" name="variant_{{ $slug }}" value="{{ $v->id }}" x-model="selectedVariantId" class="peer sr-only">
                                                    <div class="w-5 h-5 rounded-full border-2 border-stone-300 peer-checked:border-primary transition-colors"></div>
                                                    <div class="absolute w-2.5 h-2.5 rounded-full bg-primary scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                                </div>
                                                @if($v->full_image)
                                                    <img src="{{ $v->full_image }}" class="w-10 h-10 rounded-xl object-cover border border-stone-200">
                                                @endif
                                                <span class="block text-sm font-bold text-stone-800">{{ $v->name }}</span>
                                            </div>
                                            <span class="block text-xs font-black font-['JetBrains_Mono'] px-2.5 py-1 rounded-lg {{ $v->stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                                Sisa: {{ $v->stock }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Footer: lanjut ke pilih hari --}}
                            <div class="bg-stone-50 px-6 py-5 border-t border-stone-100">
                                <button type="button"
                                        @click="
                                            let vName = ''; let vStock = 0; let vImage = null;
                                            @foreach($variants as $v)
                                                if(selectedVariantId == {{ $v->id }}) { vName = '{{ addslashes($v->name) }}'; vStock = {{ $v->stock }}; vImage = '{{ addslashes($v->image ?? '') }}'; }
                                            @endforeach
                                            if(vStock > 0) {
                                                $store.rentalCart.add({
                                                    slug: '{{ $slug }}',
                                                    title: '{{ addslashes($title) }}',
                                                    price: '{{ $price }}',
                                                    image: vImage || '{{ $image }}',
                                                    category: '{{ $category }}',
                                                    variant_id: selectedVariantId,
                                                    variant_name: vName,
                                                    stock: vStock
                                                }, 1);
                                                showVariantModal = false;
                                            }
                                        "
                                        class="w-full inline-flex justify-center items-center gap-2 rounded-2xl shadow-lg shadow-primary/30 px-4 py-3.5 bg-linear-to-b from-primary to-sky-700 text-sm font-black text-white hover:from-primary/90 hover:to-sky-700/90 transition-all active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            @endif

            {{-- MODAL: Pilih Jumlah Hari Sewa --}}
            <template x-teleport="body">
                <div x-show="showDaysModal" class="fixed inset-0 z-[101] overflow-y-auto" role="dialog" aria-modal="true" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4">
                        <div x-show="showDaysModal"
                             x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-stone-900/75 backdrop-blur-sm" @click="showDaysModal = false"></div>
                        <div x-show="showDaysModal"
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                             class="relative z-10 w-full max-w-sm bg-white rounded-3xl shadow-2xl border border-stone-200/60 overflow-hidden">
                            {{-- Header --}}
                            <div class="bg-linear-to-br from-primary to-sky-700 px-6 py-6 text-white">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-white/20 p-1 shrink-0">
                                        <img src="{{ $image }}" class="w-full h-full object-cover rounded-lg" alt="{{ $title }}">
                                    </div>
                                    <div>
                                        <h3 class="font-black text-base leading-tight font-['Hanken_Grotesk']">Berapa Hari Sewa?</h3>
                                        <p class="text-xs text-sky-100 mt-0.5 line-clamp-1">{{ $title }}</p>
                                        <template x-if="pendingVariantName">
                                            <span class="inline-block mt-1 text-[10px] bg-white/20 px-2 py-0.5 rounded-full font-bold" x-text="'Varian: ' + pendingVariantName"></span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            {{-- Pilih Hari --}}
                            <div class="px-6 py-6">
                                <p class="text-xs text-stone-500 mb-4 text-center">Harga: <strong class="text-primary">{{ $price }}</strong> per hari</p>
                                {{-- Kontrol Hari --}}
                                <div class="flex items-center justify-center gap-4 mb-5">
                                    <button type="button" @click="if(days > 1) days--"
                                            class="w-12 h-12 rounded-2xl bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-xl flex items-center justify-center transition-colors">
                                        -
                                    </button>
                                    <div class="text-center min-w-[80px]">
                                        <span class="text-4xl font-black text-primary font-['Hanken_Grotesk']" x-text="days"></span>
                                        <span class="block text-xs text-stone-500 font-semibold mt-1">Hari Sewa</span>
                                    </div>
                                    <button type="button" @click="days++"
                                            class="w-12 h-12 rounded-2xl bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-xl flex items-center justify-center transition-colors">
                                        +
                                    </button>
                                </div>
                                {{-- Preset cepat --}}
                                <div class="flex gap-2 justify-center mb-6">
                                    <button type="button" @click="days = 1" :class="days === 1 ? 'bg-primary text-white' : 'bg-stone-100 text-stone-600'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors">1 Hari</button>
                                    <button type="button" @click="days = 2" :class="days === 2 ? 'bg-primary text-white' : 'bg-stone-100 text-stone-600'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors">2 Hari</button>
                                    <button type="button" @click="days = 3" :class="days === 3 ? 'bg-primary text-white' : 'bg-stone-100 text-stone-600'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors">3 Hari</button>
                                    <button type="button" @click="days = 7" :class="days === 7 ? 'bg-primary text-white' : 'bg-stone-100 text-stone-600'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors">7 Hari</button>
                                </div>
                                {{-- Konfirmasi --}}
                                <button type="button" @click="confirmAddToCart()"
                                        class="w-full py-3.5 bg-linear-to-b from-kuning to-secondary-600 hover:from-kuning/90 hover:to-secondary-600/90 text-zinc-800 rounded-2xl font-black text-sm shadow-md transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Tambah ke Keranjang
                                </button>
                                <button type="button" @click="showDaysModal = false" class="w-full mt-2 py-2.5 text-stone-500 text-xs font-semibold hover:text-stone-700 transition-colors">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
