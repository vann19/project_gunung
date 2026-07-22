@props(['trips' => null, 'guides' => null])
@php
    $icons = [
        'transport' => '<svg class="w-4 h-4 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M6 16a2 2 0 100 4 2 2 0 000-4zm12 0a2 2 0 100 4 2 2 0 000-4zM5 16V7a2 2 0 012-2h10a2 2 0 012 2v9M5 16h14M5 11h14"/></svg>',
        'food'      => '<svg class="w-4 h-4 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3v6a2 2 0 002 2v10M8 3a2 2 0 00-2 2v4a2 2 0 002 2M8 3v8M16 3v18M16 3a3 3 0 013 3v4a3 3 0 01-3 3"/></svg>',
        'porter'    => '<svg class="w-4 h-4 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="5" r="2" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9l-2 4 3 1v8m4-13l2 4-3 1v8M9 14h6"/></svg>',
        'tent'      => '<svg class="w-4 h-4 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20L12 4l9 16M12 4l5 16M12 4L7 20M9 20h6"/></svg>',
    ];

    $checkIcon = '<svg class="w-4 h-4 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 12.5l2.5 2.5 4.5-5"/></svg>';

    $trips = $trips ?? \App\Models\OpenTrip::latest()->get();
    $guides = $guides ?? \App\Models\HikingGuide::latest()->get();
@endphp

<div class="w-full bg-surface-soft py-16 lg:py-20 px-6" x-data="{ tab: '{{ in_array(request('tab'), ['opentrip', 'guide']) ? request('tab') : 'opentrip' }}' }">
    <div class="max-w-[1280px] mx-auto flex flex-col items-center text-center gap-4">

        {{-- Judul: Open Trip --}}
        <div x-show="tab === 'opentrip'" x-cloak class="flex flex-col items-center gap-4">
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">{{ __('open-trip.opentrip_title') }}</h1>
            <p class="text-gray-500 text-lg max-w-2xl">{{ __('open-trip.opentrip_desc') }}</p>
        </div>

        {{-- Judul: Guide Pendakian --}}
        <div x-show="tab === 'guide'" x-cloak class="flex flex-col items-center gap-4">
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">{{ __('open-trip.guide_title') }}</h1>
            <p class="text-gray-500 text-lg max-w-2xl">{{ __('open-trip.guide_desc') }}</p>
        </div>

        {{-- Tab Switcher --}}
        <div class="inline-flex bg-gray-200/70 rounded-full p-1 mt-2">
            <button type="button" @click="tab = 'opentrip'"
                    :class="tab === 'opentrip' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                    class="px-6 py-2.5 rounded-full text-sm font-bold transition-all">
                {{ __('open-trip.tab_opentrip') }}
            </button>
            <button type="button" @click="tab = 'guide'"
                    :class="tab === 'guide' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                    class="px-6 py-2.5 rounded-full text-sm font-bold transition-all">
                {{ __('open-trip.tab_guide') }}
            </button>
        </div>
    </div>

    {{-- ============ PANEL: OPEN TRIP ============ --}}
    <div x-show="tab === 'opentrip'" x-cloak class="max-w-[1280px] mx-auto mt-12 lg:mt-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
            @foreach ($trips as $trip)
                @php
                    $isFeatured = $trip['is_featured'] ?? $trip['featured'] ?? false;
                    $badgeClass = $trip['badge_class'] ?? $trip['badgeClass'] ?? 'bg-secondary-400 text-surface-dark';
                    $featuresList = is_string($trip['features']) ? json_decode($trip['features'], true) : ($trip['features'] ?? []);
                    $tripImgSrc = !empty($trip['image'])
                        ? (str_starts_with($trip['image'], '/') || str_starts_with($trip['image'], 'http') ? asset(ltrim($trip['image'], '/')) : asset('img/' . $trip['image']))
                        : null;
                @endphp
                <div class="relative bg-white rounded-2xl flex flex-col
                            {{ $isFeatured
                                ? 'border-2 border-primary shadow-xl z-10 lg:-my-4'
                                : 'border border-gray-200 shadow-sm' }}">

                    @if ($isFeatured)
                        <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 bg-primary rounded-md text-white text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest z-20">
                            {{ __('open-trip.trip_best_value') }}
                        </span>
                    @endif

                    @if($tripImgSrc)
                    <div class="relative w-full h-52 overflow-hidden rounded-t-2xl">
                        <img src="{{ $tripImgSrc }}" alt="{{ $trip['title'] }}" class="w-full h-full object-cover" />
                        <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $badgeClass }} shadow-md border border-white/20 backdrop-blur-sm">
                            {{ $trip['badge'] ?? 'TERBUKA' }}
                        </span>
                    </div>
                    @endif
                    
                    <div class="p-6 flex flex-col flex-1">
                        @if(!$tripImgSrc)
                        <div class="flex justify-between items-start mb-5">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $badgeClass }}">
                                {{ $trip['badge'] ?? 'TERBUKA' }}
                            </span>
                            <div class="text-right">
                                <span class="block text-gray-400 text-[10px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest">{{ __('open-trip.trip_slot_label') }}</span>
                                <span class="block text-gray-900 text-xl font-bold leading-tight">{{ $trip['slot'] ?? 10 }}</span>
                            </div>
                        </div>
                        @else
                        <div class="flex justify-end items-start mb-5 -mt-2">
                            <div class="text-right">
                                <span class="block text-gray-400 text-[10px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest">{{ __('open-trip.trip_slot_label') }}</span>
                                <span class="block text-gray-900 text-xl font-bold leading-tight">{{ $trip['slot'] ?? 10 }}</span>
                            </div>
                        </div>
                        @endif

                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $trip['title'] }}</h3>
                    <span class="text-gray-400 text-xs">{{ __('open-trip.trip_from') }}</span>
                    <span class="block text-primary text-2xl font-bold mb-5">{{ $trip['price'] }}</span>

                    <ul class="flex flex-col gap-3 mb-6">
                        @if(is_array($featuresList))
                            @foreach ($featuresList as $feature)
                                @php
                                    $iconKey = is_array($feature) ? ($feature['icon'] ?? 'transport') : 'transport';
                                    $label = is_array($feature) ? ($feature['label'] ?? '') : $feature;
                                @endphp
                                <li class="flex items-center gap-3 text-gray-700 text-sm">
                                    {!! $icons[$iconKey] ?? $icons['transport'] !!}
                                    {{ $label }}
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    <a href="{{ route('opentrip.book', ['id' => $trip['id'] ?? null]) }}" class="mt-auto w-full bg-secondary-400 hover:bg-secondary-500 rounded-lg py-3 flex items-center justify-center gap-2 font-bold text-surface-dark text-sm transition-colors">
                        {{ __('open-trip.trip_cta') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============ PANEL: GUIDE PENDAKIAN ============ --}}
    <div x-show="tab === 'guide'" x-cloak class="max-w-[1280px] mx-auto mt-12 lg:mt-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
            @foreach ($guides as $guide)
                @php
                    $isFeatured = $guide['is_featured'] ?? $guide['featured'] ?? false;
                    $badgeClass = $guide['badge_class'] ?? $guide['badgeClass'] ?? 'bg-secondary-400 text-surface-dark';
                    $featuresList = is_string($guide['features']) ? json_decode($guide['features'], true) : ($guide['features'] ?? []);
                    $imgSrc = !empty($guide['image'])
                        ? (str_starts_with($guide['image'], '/') || str_starts_with($guide['image'], 'http') ? asset(ltrim($guide['image'], '/')) : asset('img/' . $guide['image']))
                        : asset('img/Guide helping climber.png');
                @endphp
                <div class="relative bg-white rounded-2xl flex flex-col
                            {{ $isFeatured
                                ? 'border-2 border-primary shadow-xl z-10'
                                : 'border border-gray-200 shadow-sm' }}">

                    @if ($isFeatured)
                        <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 bg-primary rounded-md text-white text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest z-20">
                            {{ __('open-trip.guide_most_popular') }}
                        </span>
                    @endif

                    <div class="relative w-full h-56 overflow-hidden rounded-t-2xl">
                        <img src="{{ $imgSrc }}" alt="{{ $guide['title'] }}" class="w-full h-full object-cover" />
                        @unless ($isFeatured)
                            <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $badgeClass }} shadow-md border border-white/20 backdrop-blur-sm">
                                {{ $guide['badge'] ?? 'TERVERIFIKASI' }}
                            </span>
                        @endunless
                    </div>

                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex justify-end items-start mb-5 -mt-2">
                            <div class="text-right">
                                <span class="block text-gray-400 text-[10px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest">{{ __('open-trip.trip_slot_label') }}</span>
                                <span class="block text-gray-900 text-xl font-bold leading-tight">{{ $guide['slot'] ?? 10 }}</span>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $guide['title'] }}</h3>
                        <span class="block mb-5">
                            <span class="text-primary text-2xl font-bold">{{ $guide['price'] }}</span>
                            <span class="text-gray-400 text-sm">/ {{ $guide['unit'] ?? __('open-trip.guide_per_day') }}</span>
                        </span>

                        <ul class="flex flex-col gap-3 mb-6">
                            @if(is_array($featuresList))
                                @foreach ($featuresList as $feature)
                                    @php
                                        $isBold = is_array($feature) ? ($feature['bold'] ?? false) : false;
                                        $label = is_array($feature) ? ($feature['label'] ?? '') : $feature;
                                    @endphp
                                    <li class="flex items-start gap-3 text-sm {{ $isBold ? 'text-gray-900 font-bold' : 'text-gray-700' }}">
                                        {!! $checkIcon !!}
                                        {{ $label }}
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <a href="{{ route('guide.book', ['id' => $guide['id'] ?? null]) }}" class="mt-auto w-full bg-secondary-400 hover:bg-secondary-500 rounded-lg py-3 flex items-center justify-center gap-2 font-bold text-surface-dark text-sm transition-colors">
                            {{ __('open-trip.guide_cta') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>