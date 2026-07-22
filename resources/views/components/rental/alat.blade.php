@props([
    'title' => '',
    'slug' => '',
    'category' => '',
    'price' => '',
    'unit' => '/hari',
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
            selectedVariantId: null,
            init() {
                if ({{ count($variants) > 0 ? 'true' : 'false' }}) {
                    this.selectedVariantId = {{ count($variants) > 0 ? $variants[0]->id : 'null' }};
                }
            },
            addToCart(variantId = null, variantName = null, stock = 0) {
                this.$store.rentalCart.add({
                    slug: '{{ $slug }}',
                    title: '{{ addslashes($title) }}',
                    price: '{{ $price }}',
                    image: '{{ $image }}',
                    category: '{{ $category }}',
                    variant_id: variantId,
                    variant_name: variantName,
                    stock: stock
                }, 1);
                this.showVariantModal = false;
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
                @click.prevent="{{ count($variants) > 0 ? 'showVariantModal = true' : 'addToCart()' }}"
                class="p-2.5 bg-sky-700/10 hover:bg-sky-700/20 active:scale-95 rounded-xl flex items-center justify-center transition-all cursor-pointer group/btn relative"
                aria-label="Tambah ke keranjang"
                title="Tambah ke Keranjang"
            >
                <svg class="w-5 h-5 text-primary group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </button>

            @if(count($variants) > 0)
            {{-- Variant Modal --}}
            <template x-teleport="body">
                <div x-show="showVariantModal" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        
                        <div x-show="showVariantModal" 
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                             class="fixed inset-0 bg-stone-900/75 backdrop-blur-sm transition-opacity" @click="showVariantModal = false"></div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <div x-show="showVariantModal" 
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-90" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-90" 
                             class="relative z-10 inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-stone-200/60">
                            
                            {{-- Header --}}
                            <div class="relative bg-linear-to-br from-primary to-sky-700 px-6 py-7 overflow-hidden">
                                <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                                <div class="absolute -left-4 -bottom-4 w-24 h-24 bg-sky-300/20 rounded-full blur-xl"></div>
                                
                                <div class="relative z-10 flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-2xl bg-white/20 p-1.5 backdrop-blur-md shrink-0 shadow-inner border border-white/20">
                                        <img src="{{ $image }}" class="w-full h-full object-cover rounded-xl" alt="{{ $title }}">
                                    </div>
                                    <div class="pr-6">
                                        <h3 class="text-xl font-black text-white font-['Hanken_Grotesk'] leading-tight mb-1" id="modal-title">Pilih Varian</h3>
                                        <p class="text-xs text-sky-100 font-medium line-clamp-2 leading-relaxed">{{ $title }}</p>
                                    </div>
                                </div>
                                
                                <button type="button" @click="showVariantModal = false" class="absolute top-4 right-4 text-white/70 hover:text-white bg-black/10 hover:bg-black/20 rounded-full p-2 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            
                            {{-- Content --}}
                            <div class="bg-white px-6 py-6">
                                <div class="space-y-3 max-h-[45vh] overflow-y-auto pr-2 custom-scrollbar">
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
                                                    <img src="{{ $v->full_image }}" class="w-10 h-10 rounded-xl object-cover border border-stone-200 shadow-xs group-hover:shadow-sm transition-shadow">
                                                @endif
                                                <span class="block text-sm font-bold text-stone-800">{{ $v->name }}</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="block text-xs font-black font-['JetBrains_Mono'] px-2.5 py-1 rounded-lg {{ $v->stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                                    Sisa: {{ $v->stock }}
                                                </span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            
                            {{-- Footer --}}
                            <div class="bg-stone-50 px-6 py-5 border-t border-stone-100 flex gap-3">
                                <button type="button" 
                                        @click="
                                            let vName = ''; let vStock = 0;
                                            @foreach($variants as $v)
                                                if(selectedVariantId == {{ $v->id }}) { vName = '{{ addslashes($v->name) }}'; vStock = {{ $v->stock }}; }
                                            @endforeach
                                            if(vStock > 0) { addToCart(selectedVariantId, vName, vStock); }
                                        "
                                        class="flex-1 inline-flex justify-center items-center gap-2 rounded-2xl shadow-lg shadow-primary/30 px-4 py-3.5 bg-linear-to-b from-primary to-sky-700 text-sm font-black text-white hover:from-primary/90 hover:to-sky-700/90 transition-all active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Tambah Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            @endif
        </div>
    </div>
</div>
