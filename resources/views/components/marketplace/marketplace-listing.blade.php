@php
    $categoryIcons = [
        'all'       => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20L9 9l4 6 2-3 6 8H3z"/></svg>',
        'tents'     => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20L12 4l9 16M12 4l5 16M12 4L7 20M9 20h6"/></svg>',
        'backpacks' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8a5 5 0 0110 0v2h1a1 1 0 011 1v8a1 1 0 01-1 1H6a1 1 0 01-1-1v-8a1 1 0 011-1h1V8z"/><path stroke-linecap="round" stroke-width="2" d="M9 13h6M9 17h6"/></svg>',
        'clothing'  => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4L4 7l2 3 2-1.5V20h8V8.5L18 10l2-3-4-3-2 2h-4L8 4z"/></svg>',
        'footwear'  => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19h18M4 19v-3.5c0-1 .5-1.7 1.3-2.2L10 10l1-3c.3-1 1-1.5 2-1.5h1c1 3 3 5 6 5.5 1 .2 1.7 1 1.7 2v2.5"/></svg>',
    ];

    $categories = [
        ['key' => 'all',       'label' => 'All Gear',    'active' => true],
        ['key' => 'tents',     'label' => 'Tents',       'active' => false],
        ['key' => 'backpacks', 'label' => 'Backpacks',   'active' => false],
        ['key' => 'clothing',  'label' => 'Clothing',    'active' => false],
        ['key' => 'footwear',  'label' => 'Footwear',    'active' => false],
    ];

    $products = [
        [
            'badge'      => 'Seperti Baru',
            'badgeClass' => 'bg-secondary-400 text-surface-dark',
            'image'      => 'jaket.png',
            'title'      => "Arc'teryx Alpha SV (Bekas)",
            'spec'       => 'ALT: 5000m Performance',
            'oldPrice'   => 'Rp 12.500.000',
            'price'      => 'Rp 7.850.000',
        ],
        [
            'badge'      => 'Bagus',
            'badgeClass' => 'bg-white text-gray-700 border border-gray-200',
            'image'      => 'camping.png',
            'title'      => 'The North Face VE 25 Tent',
            'spec'       => 'WIND: 100km/h Tested',
            'oldPrice'   => null,
            'price'      => 'Rp 4.200.000',
        ],
        [
            'badge'      => 'Seperti Baru',
            'badgeClass' => 'bg-secondary-400 text-surface-dark',
            'image'      => 'sepatu.png',
            'title'      => 'La Sportiva Nepal Cube GTX',
            'spec'       => 'SIZE: 42 EU / ICE Ready',
            'oldPrice'   => null,
            'price'      => 'Rp 5.500.000',
        ],
        [
            'badge'      => 'Layak Pakai',
            'badgeClass' => 'bg-red-50 text-red-600',
            'image'      => 'tas.png',
            'title'      => 'Osprey Aether Plus 70L',
            'spec'       => 'LOAD: 25kg Capacity',
            'oldPrice'   => null,
            'price'      => 'Rp 2.100.000',
        ],
    ];
@endphp

<div id="produk" class="w-full px-6 lg:px-12 py-10 lg:py-12 scroll-mt-24">
    <div class="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">

        {{-- ============ SIDEBAR ============ --}}
        <aside class="lg:col-span-1 flex flex-col gap-6">
            <div>
                <h2 class="text-primary font-bold text-lg">Categories</h2>
                <p class="text-gray-400 text-xs font-['JetBrains_Mono'] uppercase tracking-wide mt-0.5">Technical Gear Filters</p>
            </div>

            <div class="flex flex-col gap-1">
                @foreach ($categories as $cat)
                    <button type="button"
                            class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium text-left transition-colors
                                   {{ $cat['active'] ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <span class="{{ $cat['active'] ? 'text-white' : 'text-gray-400' }}">{!! $categoryIcons[$cat['key']] !!}</span>
                        {{ $cat['label'] }}
                    </button>
                @endforeach
            </div>

            <div class="pt-4 border-t border-gray-200">
                <h3 class="font-bold text-gray-900 text-sm mb-3">Kondisi</h3>
                <div class="flex flex-col gap-2.5">
                    <label class="flex items-center gap-2.5 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/50" />
                        Seperti Baru
                    </label>
                    <label class="flex items-center gap-2.5 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/50" />
                        Bagus
                    </label>
                    <label class="flex items-center gap-2.5 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/50" />
                        Layak Pakai
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200">
                <h3 class="font-bold text-gray-900 text-sm mb-3">Rentang Harga (Rp)</h3>
                <div class="w-full h-1.5 bg-gray-100 rounded-full relative mb-2">
                    <div class="absolute inset-y-0 left-0 w-full bg-primary/30 rounded-full"></div>
                    <div class="absolute -top-1 left-0 w-3.5 h-3.5 bg-primary rounded-full border-2 border-white shadow"></div>
                    <div class="absolute -top-1 right-0 w-3.5 h-3.5 bg-primary rounded-full border-2 border-white shadow"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-400 font-['JetBrains_Mono']">
                    <span>0</span>
                    <span>10jt+</span>
                </div>
            </div>

            <a href="#" class="text-center w-full bg-primary hover:bg-primary/90 rounded-lg py-3 font-bold text-white text-sm transition-colors">
                Post Your Gear
            </a>
        </aside>

        {{-- ============ PRODUK ============ --}}
        <div class="lg:col-span-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                <h2 class="text-xl font-bold text-gray-900">Menampilkan 24 Produk</h2>
                <div class="relative w-full sm:w-44">
                    <select class="input appearance-none pr-9 text-sm">
                        <option>Terbaru</option>
                        <option>Harga Terendah</option>
                        <option>Harga Tertinggi</option>
                    </select>
                    <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                @foreach ($products as $product)
                    <div class="card overflow-hidden p-0">
                        <div class="relative w-full aspect-[4/3] bg-gray-100">
                            <img src="{{ asset('img/' . $product['image']) }}" alt="{{ $product['title'] }}" class="absolute inset-0 w-full h-full object-contain p-4" />
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $product['badgeClass'] }}">
                                {{ $product['badge'] }}
                            </span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 mb-1">{{ $product['title'] }}</h3>
                            <p class="text-gray-400 text-xs font-['JetBrains_Mono'] uppercase tracking-wide mb-3">{{ $product['spec'] }}</p>

                            <div class="flex items-center justify-between">
                                <div>
                                    @if ($product['oldPrice'])
                                        <span class="block text-gray-400 text-xs line-through">{{ $product['oldPrice'] }}</span>
                                    @endif
                                    <span class="text-primary font-bold text-lg">{{ $product['price'] }}</span>
                                </div>
                                <a href="#" aria-label="Lihat {{ $product['title'] }}" class="w-9 h-9 flex-shrink-0 bg-primary hover:bg-primary/90 rounded-lg flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>

                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>