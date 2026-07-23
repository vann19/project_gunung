@props(['items' => null])
@php
    $categoryIcons = [
        'all'       => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20L9 9l4 6 2-3 6 8H3z"/></svg>',
        'camping'   => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20L12 4l9 16M12 4l5 16M12 4L7 20M9 20h6"/></svg>',
        'kelompok'  => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
        'masak'     => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v1a5 5 0 01-5 5H8a5 5 0 01-5-5v-1a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>',
        'makan'     => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z"/></svg>',
        'piknik'    => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
        'grill'     => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>',
        'pribadi'   => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>',
        'hydropack' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>',
    ];

    $categories = [
        ['key' => 'all',       'label' => 'Semua Alat',    'active' => true],
        ['key' => 'camping',   'label' => 'Camping',       'active' => false],
        ['key' => 'kelompok',  'label' => 'Kelompok',      'active' => false],
        ['key' => 'masak',     'label' => 'Masak',         'active' => false],
        ['key' => 'makan',     'label' => 'Makan',         'active' => false],
        ['key' => 'piknik',    'label' => 'Piknik Santai', 'active' => false],
        ['key' => 'grill',     'label' => 'Grill',         'active' => false],
        ['key' => 'pribadi',   'label' => 'Pribadi',       'active' => false],
        ['key' => 'hydropack', 'label' => 'Hydropack',     'active' => false],
    ];

    $items = $items ?? \App\Models\MarketplaceItem::latest()->get();
@endphp

<div id="produk" class="w-full px-6 lg:px-12 py-10 lg:py-12 scroll-mt-24">
    <form action="{{ url()->current() }}" method="GET" class="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
        <input type="hidden" name="category" id="cat-input" value="{{ request('category', 'all') }}">

        {{-- ============ SIDEBAR ============ --}}
        <div x-data="{ showFilters: false }" class="lg:col-span-1">
            <button @click="showFilters = !showFilters" type="button" class="lg:hidden w-full flex items-center justify-between bg-white border border-gray-200 p-4 rounded-xl font-bold text-gray-900 mb-6 shadow-sm">
                <span>Filter & Kategori</span>
                <svg class="w-5 h-5 text-gray-500 transition-transform" :class="showFilters ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <aside class="flex-col gap-6 lg:flex" :class="showFilters ? 'flex' : 'hidden'">
            <div>
                <h2 class="text-primary font-bold text-lg">Categories</h2>
                <p class="text-gray-400 text-xs font-['JetBrains_Mono'] uppercase tracking-wide mt-0.5">Technical Gear Filters</p>
            </div>

            <div class="flex flex-col gap-1">
                @foreach ($categories as $cat)
                    @php
                        $isActive = request('category', 'all') === $cat['key'];
                    @endphp
                    <button type="button"
                            onclick="document.getElementById('cat-input').value = '{{ $cat['key'] }}'; this.form.submit();"
                            class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium text-left transition-colors
                                   {{ $isActive ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <span class="{{ $isActive ? 'text-white' : 'text-gray-400' }}">{!! $categoryIcons[$cat['key']] !!}</span>
                        {{ $cat['label'] }}
                    </button>
                @endforeach
            </div>

            <div class="pt-4 border-t border-gray-200">
                <h3 class="font-bold text-gray-900 text-sm mb-3">Kondisi</h3>
                <div class="flex flex-col gap-2.5">
                    <label class="flex items-center gap-2.5 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="kondisi[]" value="bekas" onchange="this.form.submit()" {{ in_array('bekas', (array)request('kondisi')) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/50" />
                        Bekas
                    </label>
                    <label class="flex items-center gap-2.5 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="kondisi[]" value="baru" onchange="this.form.submit()" {{ in_array('baru', (array)request('kondisi')) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/50" />
                        Baru
                    </label>
                  
                </div>
            </div>

       

            <a href="#" class="text-center w-full bg-primary hover:bg-primary/90 rounded-lg py-3 font-bold text-white text-sm transition-colors">
                Post Your Gear
            </a>
            </aside>
        </div>

        {{-- ============ PRODUK ============ --}}
        <div class="lg:col-span-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                <h2 class="text-xl font-bold text-gray-900">Menampilkan {{ count($items) }} Produk</h2>
                <div class="relative w-full sm:w-44">
                    <select name="sort" onchange="this.form.submit()" class="input appearance-none pr-9 text-sm">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terendah" {{ request('sort') == 'terendah' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="tertinggi" {{ request('sort') == 'tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                    <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                @foreach ($items as $product)
                    @php
                        $badge = $product['condition_badge'] ?? $product['badge'] ?? 'Bagus';
                        $badgeClass = $product['badge_class'] ?? $product['badgeClass'] ?? 'bg-white text-gray-700 border border-gray-200';
                        $oldPrice = $product['old_price'] ?? $product['oldPrice'] ?? null;
                        $image = $product['image'] ?? 'jaket.png';
                        $imgSrc = (str_starts_with($image, '/') || str_starts_with($image, 'http')) ? asset(ltrim($image, '/')) : asset('img/' . $image);
                    @endphp
                    <div class="card overflow-hidden p-0">
                        <div class="relative w-full aspect-[4/3] bg-gray-100">
                            <img src="{{ $imgSrc }}" alt="{{ $product['title'] }}" class="absolute inset-0 w-full h-full object-contain p-4" />
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $badgeClass }}">
                                {{ $badge }}
                            </span>
                            @if (($product['stock'] ?? 1) <= 0)
                                <div class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center">
                                    <span class="px-4 py-1.5 bg-rose-500 text-white font-bold text-sm rounded-full shadow-lg">Habis</span>
                                </div>
                            @else
                                <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-slate-800/80 text-white backdrop-blur-sm">
                                    Sisa: {{ $product['stock'] ?? 1 }}
                                </span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 mb-1">{{ $product['title'] }}</h3>
                            <p class="text-gray-400 text-xs font-['JetBrains_Mono'] uppercase tracking-wide mb-3">{{ $product['spec'] }}</p>

                            <div class="flex items-center justify-between">
                                <div>
                                    @if ($oldPrice)
                                        <span class="block text-gray-400 text-xs line-through">{{ $oldPrice }}</span>
                                    @endif
                                    <span class="text-primary font-bold text-lg">{{ $product['price'] }}</span>
                                </div>
                                @if (($product['stock'] ?? 1) > 0)
                                    <a href="{{ route('marketplace.detail', $product->id ?? $product['id'] ?? 0) }}" aria-label="Lihat {{ $product['title'] }}" class="w-9 h-9 flex-shrink-0 bg-primary hover:bg-primary/90 rounded-lg flex items-center justify-center transition-colors">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                @else
                                    <div class="w-9 h-9 flex-shrink-0 bg-gray-200 rounded-lg flex items-center justify-center cursor-not-allowed">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </form>
</div>