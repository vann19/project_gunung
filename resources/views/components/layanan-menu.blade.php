@props(['items' => null])

@php
    $items = $items ?? [
        [
            'icon'  => 'rental.svg',
            'title' => 'Rental Alat',
            'desc'  => 'Gear for every climb.',
            'href'  => '/rental',
        ],
        [
            'icon'  => 'cuci.svg',
            'title' => 'Cuci & Perawatan',
            'desc'  => 'Professional gear maintenance.',
            'href'  => '/service/cuci-alat',
        ],
        [
            'icon'  => 'open trip.svg',
            'title' => 'Open Trip',
            'desc'  => 'Join collective expeditions.',
            'href'  => '/service#open-trip',
        ],
        [
            'icon'  => 'guide.svg',
            'title' => 'Guide Pendakian',
            'desc'  => 'Expert certified guides.',
            'href'  => '/service#guide',
        ],
        [
            'icon'  => 'market biru.svg',
            'title' => 'Marketplace Second',
            'desc'  => 'Quality pre-owned technical gear.',
            'href'  => '/service#marketplace',
        ],
    ];
@endphp

<div {{ $attributes->merge(['class' => 'w-80 bg-white rounded-2xl border border-gray-200 shadow-xl p-3']) }}>
    <div class="flex flex-col">
        @foreach ($items as $item)
            <a href="{{ $item['href'] }}" class="flex items-start gap-3 p-3 rounded-xl hover:bg-primary/5 transition-colors group">
                <div class="w-10 h-10 flex-shrink-0 bg-primary/10 group-hover:bg-primary/15 rounded-lg flex items-center justify-center transition-colors">
                    <img src="{{ asset('icon/' . $item['icon']) }}" alt="{{ $item['title'] }}" class="w-5 h-5" />
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-900 text-sm font-bold">{{ $item['title'] }}</span>
                    <span class="text-gray-500 text-xs leading-5">{{ $item['desc'] }}</span>
                </div>
            </a>
        @endforeach
    </div>
</div>