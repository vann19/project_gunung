<x-layouts.app title="{{ $product->title }} - {{ config('app.name') }}" description="{{ Str::limit($product->description, 150) }}">

    <main class="pt-24 pb-16 min-h-screen bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Breadcrumb --}}
            <nav class="flex text-sm text-slate-500 mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('rental') }}" class="inline-flex items-center hover:text-primary transition-colors">
                            Katalog Rental
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            <span class="ml-1 capitalize">{{ $category }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            <span class="ml-1 text-slate-800 font-medium truncate max-w-[200px]">{{ $product->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div x-data="{
                    quantity: 1,
                    selectedVariantId: '',
                    mainImage: '{{ img_url($product->main_image) }}',
                    variants: {{ \Illuminate\Support\Js::from($product->variants ?? []) }},
                    specs: {{ \Illuminate\Support\Js::from($product->specifications ?? []) }},
                    hasVariants: {{ ($product->variants && $product->variants->count() > 0) ? 'true' : 'false' }},

                    get displaySpecifications() {
                        // Prefer product-level specs if provided
                        if (Array.isArray(this.specs) && this.specs.length) return this.specs;
                        // If a variant is selected and has specs, show that
                        if (this.currentVariant && Array.isArray(this.currentVariant.specifications) && this.currentVariant.specifications.length) {
                            return this.currentVariant.specifications.map(s => ({ label: s.label || '-', value: s.value || '-' }));
                        }
                        // Fallback: merge first-seen values across variants
                        const map = {};
                        this.variants.forEach(v => {
                            if (v.specifications && Array.isArray(v.specifications)) {
                                v.specifications.forEach(s => {
                                    const label = (s.label || '').toString().trim();
                                    const value = (s.value || '').toString().trim() || '-';
                                    if (!label) return;
                                    if (!map[label] || map[label] === '') map[label] = value;
                                });
                            }
                        });
                        return Object.keys(map).map(k => ({ label: k, value: map[k] }));
                    },
                    
                    get currentVariant() {
                        if (!this.hasVariants) return null;
                        return this.variants.find(v => v.id == this.selectedVariantId);
                    },
                    get currentStock() {
                        if (!this.hasVariants) return {{ $product->total_stock }};
                        return this.currentVariant ? this.currentVariant.stock : 0;
                    },
                    get currentPrice() {
                        if (this.currentVariant && this.currentVariant.price_override) {
                            return this.currentVariant.price_override;
                        }
                        return '{{ $product->price }}';
                    },
                    init() {
                        if (this.variants.length > 0) {
                            this.selectedVariantId = this.variants[0].id;
                        }

                        this.$watch('currentVariant', (val) => {
                            if (val && val.image) {
                                this.mainImage = val.image.startsWith('/') ? val.image : '/' + val.image;
                            } else {
                                this.mainImage = '{{ img_url($product->main_image) }}';
                            }
                            // reset quantity when variant changes (optional)
                            this.quantity = 1;
                        });
                    }
                 }">
                
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden flex flex-col md:flex-row">
                    
                {{-- Product Image & Gallery --}}
                <div class="md:w-1/2 bg-slate-100 flex flex-col">
                    <div class="relative aspect-square md:aspect-auto md:flex-1">
                        <img :src="mainImage" alt="{{ $product->title }}" class="w-full h-full object-cover transition-all duration-300">
                    
                    @if ($product->condition_badge === 'Baru')
                        <span class="absolute top-6 left-6 px-3 py-1.5 bg-emerald-600/95 backdrop-blur-xs text-white text-xs font-bold font-['JetBrains_Mono'] uppercase tracking-wider rounded-md shadow-sm flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span> Baru
                        </span>
                    @else
                        <span class="absolute top-6 left-6 px-3 py-1.5 bg-amber-600/95 backdrop-blur-xs text-white text-xs font-bold font-['JetBrains_Mono'] uppercase tracking-wider rounded-md shadow-sm flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-200"></span> Second
                        </span>
                    @endif

                    @if ($product->is_popular)
                        <span class="absolute top-6 right-6 px-3 py-1.5 bg-kuning text-primary text-xs font-bold font-['JetBrains_Mono'] uppercase tracking-wider rounded-md shadow-sm">
                            Populer
                        </span>
                    @endif
                    </div>
                    
                    {{-- Gallery Thumbnails --}}
                    @php
                        $gallery = is_array($product->gallery_images) ? $product->gallery_images : [];
                        array_unshift($gallery, $product->main_image);
                    @endphp
                    @if(count($gallery) > 1)
                    <div class="p-4 bg-white border-t border-slate-200/60 flex gap-3 overflow-x-auto">
                        @foreach($gallery as $img)
                            <button type="button" @click="mainImage = '{{ asset($img) }}'" 
                                    :class="mainImage === '{{ asset($img) }}' ? 'border-primary ring-2 ring-primary/20' : 'border-slate-200 opacity-70 hover:opacity-100'"
                                    class="w-16 h-16 shrink-0 rounded-xl border-2 overflow-hidden transition-all">
                                <img src="{{ asset($img) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Product Info --}}
                <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                    <span class="inline-block px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold font-['JetBrains_Mono'] uppercase tracking-wider rounded-full w-fit mb-4 capitalize">
                        Kategori: {{ $product->category }}
                    </span>
                    
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4 leading-tight">
                        {{ $product->title }}
                    </h1>
                    
                    <div class="flex items-end gap-2 mb-8">
                        <span class="text-4xl font-black text-secondary-500 font-['Hanken_Grotesk']" x-text="currentPrice"></span>
                        <span class="text-slate-500 text-sm font-medium mb-1.5">/ hari</span>
                    </div>
                    
                    <div class="prose prose-slate prose-sm md:prose-base mb-10">
                        <p class="text-slate-600 leading-relaxed">{{ Str::limit($product->description ?? 'Alat rental berkualitas tinggi siap menemani petualangan Anda.', 140) }}</p>
                    </div>

                    <div class="mt-auto flex flex-col gap-5">
                         
                        <template x-if="hasVariants">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Pilih Varian</label>
                                <div class="flex gap-2 flex-wrap">
                                    <template x-for="variant in variants" :key="variant.id">
                                        <button type="button" 
                                                @click="selectedVariantId = variant.id"
                                                :class="selectedVariantId === variant.id ? 'bg-primary text-white border-primary shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:border-primary/50 hover:bg-slate-50'"
                                                class="px-4 py-2 rounded-xl border text-sm font-medium transition-all duration-200 flex items-center gap-2">
                                                
                                                <template x-if="variant.image">
                                                    <!-- <img :src="variant.image.startsWith('/') ? variant.image : '/' + variant.image" class="w-5 h-5 rounded object-cover border border-slate-200"> -->
                                                </template>
                                                <span x-text="variant.name"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>
                        
                        <div class="flex items-center gap-1.5 text-sm">
                            <span class="text-slate-500">Stok Tersedia:</span>
                            <span class="font-bold font-['JetBrains_Mono']" :class="currentStock > 0 ? 'text-emerald-600' : 'text-rose-600'" x-text="currentStock > 0 ? currentStock : 'Habis / Tidak Tersedia'"></span>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="flex items-center gap-1 bg-slate-100 border border-slate-200 rounded-2xl p-1.5 shrink-0 h-fit self-center">
                                <button
                                    type="button"
                                    @click="if (quantity > 1) quantity--"
                                    class="w-10 h-10 rounded-xl bg-white hover:bg-slate-200 text-slate-700 font-bold flex items-center justify-center transition-colors shadow-2xs"
                                >
                                    -
                                </button>
                                <div class="px-4 text-center">
                                    <span class="text-base font-bold text-slate-800" x-text="quantity"></span>
                                    <span class="text-[10px] text-slate-500 block -mt-1 font-medium">Qty</span>
                                </div>
                                <button
                                    type="button"
                                    @click="quantity++"
                                    class="w-10 h-10 rounded-xl bg-white hover:bg-slate-200 text-slate-700 font-bold flex items-center justify-center transition-colors shadow-2xs"
                                >
                                    +
                                </button>
                            </div>

                            <button
                                type="button"
                                :disabled="currentStock <= 0"
                                @click="if(currentStock > 0) { $store.rentalCart.add({
                                    slug: '{{ $product->slug }}',
                                    title: '{{ addslashes($product->title) }}',
                                    price: currentPrice,
                                    image: (currentVariant && currentVariant.image ? (currentVariant.image.startsWith('http') ? currentVariant.image : (currentVariant.image.startsWith('/') ? currentVariant.image : '/' + currentVariant.image)) : '{{ img_url($product->image) }}'),
                                    category: '{{ $product->category }}',
                                    variant_id: currentVariant ? currentVariant.id : null,
                                    variant_name: currentVariant ? currentVariant.name : null,
                                    stock: currentStock
                                }, quantity) }"
                                :class="currentStock <= 0 ? 'opacity-50 cursor-not-allowed bg-slate-100 text-slate-400' : 'bg-sky-700/10 hover:bg-sky-700/20 text-primary cursor-pointer active:scale-[0.98]'"
                                class="flex-1 flex items-center justify-center gap-2 py-4 rounded-2xl font-bold text-base transition-all"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span x-text="currentStock <= 0 ? 'Stok Habis' : '+ Keranjang'"></span>
                            </button>

                            <a :href="currentStock > 0 ? ('/rental/biodata?slug={{ $product->slug }}&qty=' + quantity + (currentVariant ? '&variant_id=' + currentVariant.id : '')) : '#'" 
                               :class="currentStock <= 0 ? 'opacity-50 cursor-not-allowed pointer-events-none bg-slate-300' : 'bg-primary hover:bg-primary/90 text-white shadow-lg shadow-primary/20 active:scale-[0.98]'"
                               class="flex-1 flex items-center justify-center gap-2 py-4 rounded-2xl font-bold text-base transition-all h-fit">
                                <span>Sewa Langsung</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Shopee Style: Spesifikasi & Deskripsi Produk --}}
            <div class="mt-8 space-y-8">
                
                {{-- Spesifikasi Produk --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="bg-slate-100/80 px-6 md:px-8 py-5 border-b border-slate-200/60">
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Spesifikasi Produk</h2>
                    </div>
                    <div class="p-6 md:p-8">
                        @php
                            // Prepare display specifications: prefer product-level specs, otherwise merge variant specs
                            $displaySpecifications = [];
                            if (!empty($product->specifications) && is_array($product->specifications) && count($product->specifications) > 0) {
                                $displaySpecifications = $product->specifications;
                            } else {
                                // collect first seen value for each label from variants
                                foreach ($product->variants as $variant) {
                                    if (!empty($variant->specifications) && is_array($variant->specifications)) {
                                        foreach ($variant->specifications as $spec) {
                                            $label = trim(data_get($spec, 'label', ''));
                                            $value = trim(data_get($spec, 'value', ''));
                                            if ($label === '') continue;
                                            if (!array_key_exists($label, $displaySpecifications)) {
                                                $displaySpecifications[$label] = $value ?: '-';
                                            } else {
                                                // if already present but empty, prefer non-empty
                                                if (($displaySpecifications[$label] === '-' || $displaySpecifications[$label] === '') && $value !== '') {
                                                    $displaySpecifications[$label] = $value;
                                                }
                                            }
                                        }
                                    }
                                }
                                // convert to array of ['label'=>..., 'value'=>...]
                                $displaySpecifications = array_map(function($k, $v) {
                                    return ['label' => $k, 'value' => $v];
                                }, array_keys($displaySpecifications), $displaySpecifications);
                            }

                        @endphp

                        <div class="divide-y divide-slate-100 text-sm">
                            <div class="py-3.5 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                <span class="text-slate-400 sm:w-1/3 md:w-1/4 shrink-0 font-normal">Kategori</span>
                                <div class="text-slate-700 font-medium flex items-center gap-1.5 flex-wrap">
                                    <a href="{{ route('rental') }}" class="text-blue-600 hover:underline">Katalog Rental</a>
                                    <span class="text-slate-300">&gt;</span>
                                    <a href="{{ route('rental', ['category' => $product->category]) }}" class="text-blue-600 hover:underline capitalize">{{ $product->category }}</a>
                                </div>
                            </div>

                            <div class="py-3.5 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                <span class="text-slate-400 sm:w-1/3 md:w-1/4 shrink-0 font-normal">Kondisi Alat</span>
                                <span class="text-slate-700 font-semibold">{{ $product->condition_badge }} (Terawat & Layak Pakai)</span>
                            </div>

                            <div class="py-3.5 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                <span class="text-slate-400 sm:w-1/3 md:w-1/4 shrink-0 font-normal">Harga Sewa / Hari</span>
                                <span class="text-slate-800 font-bold font-['JetBrains_Mono']">{{ $product->price }}</span>
                            </div>

                            <template x-if="displaySpecifications && displaySpecifications.length">
                                <template x-for="spec in displaySpecifications" :key="spec.label">
                                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                        <span class="text-slate-400 sm:w-1/3 md:w-1/4 shrink-0 font-normal" x-text="spec.label"></span>
                                        <span class="text-slate-700 font-medium" x-text="spec.value"></span>
                                    </div>
                                </template>
                            </template>

                            <template x-if="!displaySpecifications || displaySpecifications.length === 0">
                                <div class="py-3.5 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                    <span class="text-slate-400 sm:w-1/3 md:w-1/4 shrink-0 font-normal">Merek</span>
                                    <span class="text-slate-700 font-medium">-</span>
                                </div>
                                <div class="py-3.5 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                    <span class="text-slate-400 sm:w-1/3 md:w-1/4 shrink-0 font-normal">Masa Garansi</span>
                                    <span class="text-slate-700 font-medium">-</span>
                                </div>
                                <div class="py-3.5 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                    <span class="text-slate-400 sm:w-1/3 md:w-1/4 shrink-0 font-normal">Kebersihan Alat</span>
                                    <span class="text-slate-700 font-medium">-</span>
                                </div>
                            </template>

                            <div class="py-3.5 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                <span class="text-slate-400 sm:w-1/3 md:w-1/4 shrink-0 font-normal">Dikirim Dari</span>
                                <span class="text-slate-700 font-medium uppercase font-['JetBrains_Mono']">Basecamps Outdoor</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi Produk --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="bg-slate-100/80 px-6 md:px-8 py-5 border-b border-slate-200/60">
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Deskripsi Produk</h2>
                    </div>
                    <div class="p-6 md:p-8 text-slate-700 leading-relaxed space-y-4 text-sm md:text-base font-sans whitespace-pre-line">
                        {{ $product->description ?: "Deskripsi lengkap belum ditambahkan oleh Admin.\n\nPeralatan rental ini dijamin dalam kondisi " . strtolower($product->condition_badge) . " dan siap pakai untuk menemani petualangan mendaki gunung atau camping Anda. Sudah melalui pengecekan kualitas dan kelayakan fungsi standar Basecamps Outdoor." }}
                    </div>
                </div>

            </div>
            </div>
        </div>
    </main>

</x-layouts.app>
