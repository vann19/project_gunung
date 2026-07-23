@php
    $slides = config('mountains.slides', []);
    $defaults = [
        0 => ['temp' => '8°C', 'weather' => 'cloudy', 'label' => 'Berawan'],
        1 => ['temp' => '7°C', 'weather' => 'foggy', 'label' => 'Berkabut'],
        2 => ['temp' => '5°C', 'weather' => 'cloudy', 'label' => 'Berawan'],
        3 => ['temp' => '10°C', 'weather' => 'cloudy', 'label' => 'Berawan'],
    ];
@endphp

<div
    class="relative w-full min-h-screen lg:h-screen lg:overflow-hidden"
    x-data="{
        active: 0,
        total: {{ count($slides) }},
        interval: null,
        weatherRefresh: null,
        weatherData: {},
        weatherLoading: true,
        next() {
            this.active = (this.active + 1) % this.total;
        },
        goTo(index) {
            this.active = index;
        },
        startAutoplay() {
            this.interval = setInterval(() => this.next(), 5000);
        },
        resetAutoplay() {
            clearInterval(this.interval);
            this.startAutoplay();
        },
        getWeather(index) {
            return this.weatherData[index] ?? null;
        },
        tempFor(index, fallback) {
            const w = this.getWeather(index);
            return w ? w.temperature_formatted : fallback;
        },
        weatherType(index) {
            const w = this.getWeather(index);
            return w ? w.weather : 'cloudy';
        },
        weatherLabel(index) {
            const w = this.getWeather(index);
            return w ? w.weather_label : '';
        },
        async fetchWeather() {
            try {
                const res = await fetch('{{ url('/api/v1/mountain-weather') }}');
                const json = await res.json();
                if (json.status && Array.isArray(json.data)) {
                    json.data.forEach(item => {
                        this.weatherData[item.index] = item;
                    });
                }
            } catch (e) {
                console.warn('Gagal memuat cuaca gunung:', e);
            }
            this.weatherLoading = false;
        },
    }"
    x-init="
        fetchWeather();
        startAutoplay();
        weatherRefresh = setInterval(() => fetchWeather(), 900000);
    "
>
    {{-- Background Image Slides --}}
    @foreach ($slides as $index => $slide)
        <div
            class="absolute inset-0"
            @if ($index > 0) x-cloak @endif
            x-show="active === {{ $index }}"
            x-transition:enter="transition-opacity ease-out duration-700"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-700"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <img
                src="{{ asset($slide['image']) }}"
                alt="{{ $slide['name'] }}"
                class="absolute inset-0 w-full h-full object-cover object-center"
                style="filter: brightness(1.1) contrast(1.1);"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/30"></div>
        </div>
    @endforeach

    {{-- Konten Utama (Text, Button, dan Weather Card di Mobile) --}}
    <div class="relative z-10 h-full max-w-[1280px] mx-auto px-5 sm:px-6 lg:px-12 flex flex-col justify-center pt-20 pb-10 sm:pt-24 sm:pb-16 lg:py-0">
        <div class="w-full lg:w-1/2 flex flex-col items-start gap-3 sm:gap-6">
            <div class="px-3.5 py-1.5 bg-primary/20 rounded-full border border-primary/30 backdrop-blur-sm inline-flex items-center">
                <span class="text-white text-xs font-medium font-['JetBrains_Mono'] uppercase tracking-widest">
                    {{ __('home.hero_tagline') }}
                </span>
            </div>

            <h1 class="text-2xl sm:text-5xl lg:text-6xl font-bold text-zinc-200 leading-[1.15] tracking-tight">
                {{ __('home.hero_title_1') }}<br/>
                <span class="text-stone-400 italic">{{ __('home.hero_title_2') }}</span>
            </h1>

            <p class="hidden sm:block text-stone-300 text-sm sm:text-base lg:text-lg leading-relaxed max-w-[500px]">
                {{ __('home.hero_desc') }}
            </p>

            {{-- Button Sewa Sekarang --}}
            <div class="flex flex-row items-center gap-4 mt-1 sm:mt-2">
                <a href="/rental" class="px-6 py-3 sm:px-8 sm:py-4 bg-kuning hover:bg-kuning/90 rounded-lg flex justify-center items-center gap-2 transition-all active:scale-95 shadow-lg">
                    <span class="text-zinc-800 text-xs sm:text-base font-bold">{{ __('home.hero_cta_rent') }}</span>
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            {{-- Widget Cuaca Khusus Mobile (Tampil Rapi DI BAWAH Button) --}}
            <div class="w-full mt-3 lg:hidden">
                <div class="bg-black/60 rounded-xl border border-white/15 backdrop-blur-md p-3 flex items-center justify-between gap-2 shadow-2xl">
                    @foreach ($slides as $index => $slide)
                        @php
                            $def = $defaults[$index] ?? $defaults[0];
                        @endphp
                        <div
                            class="flex items-center justify-between w-full gap-2"
                            @if ($index > 0) x-cloak @endif
                            x-show="active === {{ $index }}"
                            x-transition:enter="transition-opacity ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                        >
                            <div class="flex flex-col items-center min-w-[65px]">
                                <span class="text-biru text-[8px] font-medium font-['JetBrains_Mono'] tracking-widest mb-0.5 text-center">{{ __('home.hero_label_mountain') }}</span>
                                <span class="text-zinc-200 text-xs font-semibold text-center leading-tight">{{ $slide['name'] }}</span>
                            </div>

                            <div class="w-px h-7 bg-neutral-600/50 shrink-0"></div>

                            <div class="flex flex-col items-center shrink-0">
                                <span class="text-biru text-[8px] font-medium font-['JetBrains_Mono'] tracking-widest mb-0.5">{{ __('home.hero_label_elev') }}</span>
                                <span class="text-zinc-200 text-xs font-semibold">{{ $slide['elevation'] }}</span>
                            </div>

                            <div class="w-px h-7 bg-neutral-600/50 shrink-0"></div>

                            <div class="flex flex-col items-center min-w-[40px] shrink-0">
                                <span class="text-biru text-[8px] font-medium font-['JetBrains_Mono'] tracking-widest mb-0.5">{{ __('home.hero_label_temp') }}</span>
                                <span
                                    class="text-zinc-200 text-xs font-semibold tabular-nums"
                                    x-text="tempFor({{ $index }}, '{{ $def['temp'] }}')"
                                    :class="weatherLoading && 'opacity-50 animate-pulse'"
                                >{{ $def['temp'] }}</span>
                            </div>

                            <div class="w-px h-7 bg-neutral-600/50 shrink-0"></div>

                            <div class="flex flex-col items-center min-w-[40px] shrink-0">
                                <span class="text-biru text-[8px] font-medium font-['JetBrains_Mono'] tracking-widest mb-0.5">{{ __('home.hero_label_weather') }}</span>

                                <svg x-show="weatherType({{ $index }}) === 'sunny'" @if($def['weather'] !== 'sunny') x-cloak @endif class="w-4 h-4 text-yellow-300 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0-5a1 1 0 1 1 1 1v1a1 1 0 1 1-2 0V3a1 1 0 0 1 1-1zm0 18a1 1 0 0 1-1-1v-1a1 1 0 1 1 2 0v1a1 1 0 0 1-1 1zm10-8a1 1 0 0 1-1 1h-1a1 1 0 1 1 0-2h1a1 1 0 0 1 1 1zM4 12a1 1 0 0 1-1 1H2a1 1 0 1 1 0-2h1a1 1 0 0 1 1 1z"/>
                                </svg>
                                <svg x-show="weatherType({{ $index }}) === 'rainy'" @if($def['weather'] !== 'rainy') x-cloak @endif class="w-4 h-4 text-blue-300 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.995 12c2.893 0 5.234-2.379 5.234-5.31A5.36 5.36 0 0 0 12 5.051a6 6 0 1 1-5.005 6.949z"/>
                                </svg>
                                <svg x-show="weatherType({{ $index }}) === 'snowy'" @if($def['weather'] !== 'snowy') x-cloak @endif class="w-4 h-4 text-sky-200 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.995 12c2.893 0 5.234-2.379 5.234-5.31A5.36 5.36 0 0 0 12 5.051a6 6 0 1 1-5.005 6.949z"/>
                                </svg>
                                <svg x-show="weatherType({{ $index }}) === 'foggy'" @if($def['weather'] !== 'foggy') x-cloak @endif class="w-4 h-4 text-stone-400 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.995 12c2.893 0 5.234-2.379 5.234-5.31A5.36 5.36 0 0 0 12 5.051a6 6 0 1 1-5.005 6.949z"/>
                                </svg>
                                <svg x-show="weatherType({{ $index }}) === 'cloudy'" @if($def['weather'] !== 'cloudy') x-cloak @endif class="w-4 h-4 text-stone-300 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.995 12c2.893 0 5.234-2.379 5.234-5.31A5.36 5.36 0 0 0 12 5.051a6 6 0 1 1-5.005 6.949z"/>
                                </svg>

                                <span class="text-stone-400 text-[8px] font-['JetBrains_Mono'] mt-0.5 uppercase tracking-wide" x-text="weatherLabel({{ $index }})">{{ $def['label'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Widget Cuaca Khusus Desktop (Kanan Bawah) --}}
    <div class="hidden lg:block absolute bottom-12 right-12 z-20">
        <div class="bg-neutral-800/60 rounded-2xl border border-stone-300/10 backdrop-blur-md p-6 flex items-center gap-10 shadow-2xl">
            @foreach ($slides as $index => $slide)
                @php
                    $def = $defaults[$index] ?? $defaults[0];
                @endphp
                <div
                    class="flex items-center gap-10"
                    @if ($index > 0) x-cloak @endif
                    x-show="active === {{ $index }}"
                    x-transition:enter="transition-opacity ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                >
                    <div class="flex flex-col items-center min-w-[100px]">
                        <span class="text-biru text-xs font-medium font-['JetBrains_Mono'] tracking-widest mb-1 text-center">{{ __('home.hero_label_mountain') }}</span>
                        <span class="text-zinc-200 text-lg font-semibold text-center leading-tight">{{ $slide['name'] }}</span>
                    </div>

                    <div class="w-px h-12 bg-neutral-600/50 shrink-0"></div>

                    <div class="flex flex-col items-center shrink-0">
                        <span class="text-biru text-xs font-medium font-['JetBrains_Mono'] tracking-widest mb-1">{{ __('home.hero_label_elev') }}</span>
                        <span class="text-zinc-200 text-3xl font-semibold">{{ $slide['elevation'] }}</span>
                    </div>

                    <div class="w-px h-12 bg-neutral-600/50 shrink-0"></div>

                    <div class="flex flex-col items-center min-w-[72px] shrink-0">
                        <span class="text-biru text-xs font-medium font-['JetBrains_Mono'] tracking-widest mb-1">{{ __('home.hero_label_temp') }}</span>
                        <span
                            class="text-zinc-200 text-3xl font-semibold tabular-nums"
                            x-text="tempFor({{ $index }}, '{{ $def['temp'] }}')"
                            :class="weatherLoading && 'opacity-50 animate-pulse'"
                        >{{ $def['temp'] }}</span>
                    </div>

                    <div class="w-px h-12 bg-neutral-600/50 shrink-0"></div>

                    <div class="flex flex-col items-center min-w-[72px] shrink-0">
                        <span class="text-biru text-xs font-medium font-['JetBrains_Mono'] tracking-widest mb-1">{{ __('home.hero_label_weather') }}</span>

                        <svg x-show="weatherType({{ $index }}) === 'sunny'" @if($def['weather'] !== 'sunny') x-cloak @endif class="w-8 h-8 text-yellow-300 mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0-5a1 1 0 1 1 1 1v1a1 1 0 1 1-2 0V3a1 1 0 0 1 1-1zm0 18a1 1 0 0 1-1-1v-1a1 1 0 1 1 2 0v1a1 1 0 0 1-1 1zm10-8a1 1 0 0 1-1 1h-1a1 1 0 1 1 0-2h1a1 1 0 0 1 1 1zM4 12a1 1 0 0 1-1 1H2a1 1 0 1 1 0-2h1a1 1 0 0 1 1 1z"/>
                        </svg>
                        <svg x-show="weatherType({{ $index }}) === 'rainy'" @if($def['weather'] !== 'rainy') x-cloak @endif class="w-8 h-8 text-blue-300 mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.995 12c2.893 0 5.234-2.379 5.234-5.31A5.36 5.36 0 0 0 12 5.051a6 6 0 1 1-5.005 6.949z"/>
                        </svg>
                        <svg x-show="weatherType({{ $index }}) === 'snowy'" @if($def['weather'] !== 'snowy') x-cloak @endif class="w-8 h-8 text-sky-200 mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.995 12c2.893 0 5.234-2.379 5.234-5.31A5.36 5.36 0 0 0 12 5.051a6 6 0 1 1-5.005 6.949z"/>
                        </svg>
                        <svg x-show="weatherType({{ $index }}) === 'foggy'" @if($def['weather'] !== 'foggy') x-cloak @endif class="w-8 h-8 text-stone-400 mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.995 12c2.893 0 5.234-2.379 5.234-5.31A5.36 5.36 0 0 0 12 5.051a6 6 0 1 1-5.005 6.949z"/>
                        </svg>
                        <svg x-show="weatherType({{ $index }}) === 'cloudy'" @if($def['weather'] !== 'cloudy') x-cloak @endif class="w-8 h-8 text-stone-300 mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.995 12c2.893 0 5.234-2.379 5.234-5.31A5.36 5.36 0 0 0 12 5.051a6 6 0 1 1-5.005 6.949z"/>
                        </svg>

                        <span class="text-stone-400 text-[10px] font-['JetBrains_Mono'] mt-1 uppercase tracking-wide" x-text="weatherLabel({{ $index }})">{{ $def['label'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Indikator Carousel --}}
    <div class="hidden sm:flex absolute bottom-8 lg:bottom-12 left-1/2 -translate-x-1/2 z-20 items-center gap-2">
        @foreach ($slides as $index => $slide)
            <button
                type="button"
                @click="goTo({{ $index }}); resetAutoplay()"
                class="h-2 rounded-full transition-all duration-300"
                :class="active === {{ $index }} ? 'w-8 bg-white' : 'w-4 bg-white/40 hover:bg-white/60'"
                aria-label="Ke slide {{ $index + 1 }}"
            ></button>
        @endforeach
    </div>
</div>
