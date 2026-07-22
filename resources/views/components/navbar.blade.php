@php
    $locale = app()->getLocale();
    $searchPages = collect(config('pages.searchable'))->map(function ($page) use ($locale) {
        return [
            'url' => $page['url'],
            'title' => $page['title'][$locale] ?? $page['title']['id'],
            'description' => $page['description'][$locale] ?? $page['description']['id'],
            'keywords' => $page['keywords'][$locale] ?? $page['keywords']['id'],
        ];
    })->values();
@endphp

<nav
    class="w-full py-2 bg-white border-b border-neutral-700/10 backdrop-blur-[6px] sticky top-0 z-50"
    x-data="{
        mobileMenuOpen: false,
        searchOpen: false,
        langOpen: false,
        searchQuery: '',
        pages: {{ Js::from($searchPages) }},
        get filteredPages() {
            const q = this.searchQuery.trim().toLowerCase();
            if (!q) return this.pages;
            return this.pages.filter(page => {
                const haystack = [
                    page.title,
                    page.description,
                    ...(page.keywords || []),
                ].join(' ').toLowerCase();
                return haystack.includes(q);
            });
        },
        openSearch() {
            this.searchOpen = true;
            this.langOpen = false;
            this.$nextTick(() => this.$refs.searchInput?.focus());
        },
        closeSearch() {
            this.searchOpen = false;
            this.searchQuery = '';
        },
        goToPage(url) {
            window.location.href = url;
        },
    }"
    @keydown.escape.window="searchOpen = false; langOpen = false"
>
    <div class="w-full px-6 lg:px-12 py-4 flex justify-between items-center">

        {{-- KIRI: Logo --}}
        <div class="flex-1 flex justify-start">
            <a href="/">
                <img class="w-auto h-12 object-contain" src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }} Logo" />
            </a>
        </div>

        {{-- TENGAH: Desktop Navigation --}}
        <div class="hidden lg:flex justify-center items-center gap-8" x-data="{ active: '{{ Str::startsWith(request()->path(), 'service') ? '/service' : (request()->path() == '/' ? '/' : '/' . request()->path()) }}' }">

            <a href="/" @click="active = '/'" :class="active === '/' ? 'border-b-2 border-primary' : 'border-b-0'" class="pb-1 flex flex-col justify-start items-start transition-all group">
                <div :class="active === '/' ? 'font-bold text-primary' : 'font-normal text-primary/75'" class="text-base leading-6 transition-colors group-hover:text-primary">{{ __('nav.home') }}</div>
            </a>

            <a href="/rental" @click="active = '/rental'" :class="active === '/rental' ? 'border-b-2 border-primary' : 'border-b-0'" class="pb-1 flex flex-col justify-start items-start group transition-all">
                <div class="flex justify-start items-center gap-1">
                    <div :class="active === '/rental' ? 'font-bold text-primary' : 'font-normal text-primary/75'" class="text-base leading-6 transition-colors group-hover:text-primary">{{ __('nav.rental') }}</div>
                    <div class="flex flex-col justify-start items-center">
                        
                    </div>
                </div>
            </a>

            <div class="relative" x-data="{ serviceOpen: false }" @mouseenter="serviceOpen = true" @mouseleave="serviceOpen = false">
                <a href="/service" @click="active = '/service'" :class="active === '/service' ? 'border-b-2 border-primary' : 'border-b-0'" class="pb-1 flex flex-col justify-start items-start group transition-all">
                    <div class="flex justify-start items-center gap-1">
                        <div :class="active === '/service' ? 'font-bold text-primary' : 'font-normal text-primary/75'" class="text-base leading-6 transition-colors group-hover:text-primary">{{ __('nav.services') }}</div>
                        <div class="flex flex-col justify-start items-center">
                            <svg :class="serviceOpen ? 'rotate-180' : 'rotate-0'" class="w-2 h-2 text-primary/75 group-hover:text-primary transition-all" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </a>

                <div x-show="serviceOpen"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="absolute top-full left-1/2 -translate-x-1/2 pt-3"
                     style="display: none;">
                    <x-layanan-menu />
                </div>
            </div>

            <a href="/about" @click="active = '/about'" :class="active === '/about' ? 'border-b-2 border-primary' : 'border-b-0'" class="pb-1 flex flex-col justify-start items-start group transition-all">
                <div :class="active === '/about' ? 'font-bold text-primary' : 'font-normal text-primary/75'" class="text-base leading-6 transition-colors group-hover:text-primary">{{ __('nav.about') }}</div>
            </a>

            <a href="/info-gunung" @click="active = '/info-gunung'" :class="active === '/info-gunung' ? 'border-b-2 border-primary' : 'border-b-0'" class="pb-1 flex flex-col justify-start items-start group transition-all">
                <div :class="active === '/info-gunung' ? 'font-bold text-primary' : 'font-normal text-primary/75'" class="text-base leading-6 transition-colors group-hover:text-primary">Info Gunung</div>
            </a>

            <a href="/contact" @click="active = '/contact'" :class="active === '/contact' ? 'border-b-2 border-primary' : 'border-b-0'" class="pb-1 flex flex-col justify-start items-start group transition-all">
                <div :class="active === '/contact' ? 'font-bold text-primary' : 'font-normal text-primary/75'" class="text-base leading-6 transition-colors group-hover:text-primary">{{ __('nav.contact') }}</div>
            </a>
        </div>

        {{-- KANAN: Actions (Desktop) --}}
        <div class="hidden lg:flex flex-1 justify-end items-center gap-5">

            {{-- Search --}}
            <button
                type="button"
                @click="openSearch()"
                class="text-primary/75 hover:text-primary transition-colors"
                aria-label="{{ __('nav.search_title') }}"
            >
                <img src="{{ asset('icon/search.svg') }}" alt="" class="w-5 h-5" />
            </button>

            {{-- Language --}}
            <div class="relative" @click.outside="langOpen = false">
                <button
                    type="button"
                    @click="langOpen = !langOpen; searchOpen = false"
                    class="flex items-center gap-1.5 text-primary/75 hover:text-primary transition-colors"
                    aria-label="{{ __('nav.language') }}"
                >
                    <img src="{{ asset('icon/translete.svg') }}" alt="" class="w-5 h-5" />
                    <span class="text-xs font-bold font-['JetBrains_Mono'] uppercase">{{ $locale === 'id' ? 'ID' : 'EN' }}</span>
                </button>

                <div
                    x-show="langOpen"
                    x-transition
                    class="absolute right-0 top-full mt-3 w-44 bg-white rounded-xl border border-gray-200 shadow-xl py-2 z-50"
                    style="display: none;"
                >
                    <a
                        href="{{ route('locale.switch', 'id') }}"
                        class="flex items-center justify-between px-4 py-2.5 text-sm hover:bg-primary/5 transition-colors {{ $locale === 'id' ? 'text-primary font-bold' : 'text-gray-700' }}"
                    >
                        {{ __('nav.language_id') }}
                        @if ($locale === 'id')
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </a>
                    <a
                        href="{{ route('locale.switch', 'en') }}"
                        class="flex items-center justify-between px-4 py-2.5 text-sm hover:bg-primary/5 transition-colors {{ $locale === 'en' ? 'text-primary font-bold' : 'text-gray-700' }}"
                    >
                        {{ __('nav.language_en') }}
                        @if ($locale === 'en')
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </a>
                </div>
            </div>

        </div>

        {{-- Mobile: Search + Lang only (navigation moved to bottom bar) --}}
        <div class="lg:hidden flex flex-1 justify-end items-center gap-4">
            <button type="button" @click="openSearch()" class="text-primary/75 hover:text-primary transition-colors" aria-label="{{ __('nav.search_title') }}">
                <img src="{{ asset('icon/search.svg') }}" alt="" class="w-5 h-5" />
            </button>

            <div class="relative" @click.outside="langOpen = false">
                <button type="button" @click="langOpen = !langOpen" class="flex items-center gap-1 text-primary/75 hover:text-primary transition-colors" aria-label="{{ __('nav.language') }}">
                    <img src="{{ asset('icon/translete.svg') }}" alt="" class="w-5 h-5" />
                    <span class="text-xs font-bold font-['JetBrains_Mono'] uppercase">{{ $locale === 'id' ? 'ID' : 'EN' }}</span>
                </button>
                <div x-show="langOpen" x-transition class="absolute right-0 top-full mt-2 w-40 bg-white rounded-xl border border-gray-200 shadow-xl py-2 z-50" style="display: none;">
                    <a href="{{ route('locale.switch', 'id') }}" class="flex items-center justify-between px-4 py-2.5 text-sm hover:bg-primary/5 transition-colors {{ $locale === 'id' ? 'text-primary font-bold' : 'text-gray-700' }}">{{ __('nav.language_id') }}@if($locale==='id')<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>@endif</a>
                    <a href="{{ route('locale.switch', 'en') }}" class="flex items-center justify-between px-4 py-2.5 text-sm hover:bg-primary/5 transition-colors {{ $locale === 'en' ? 'text-primary font-bold' : 'text-gray-700' }}">{{ __('nav.language_en') }}@if($locale==='en')<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>@endif</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Modal --}}

    <div
        x-show="searchOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex items-start justify-center pt-24 px-4 bg-black/40 backdrop-blur-sm"
        style="display: none;"
        @click.self="closeSearch()"
    >
        <div
            x-show="searchOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            class="w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden"
            @click.stop
        >
            <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                <img src="{{ asset('icon/search.svg') }}" alt="" class="w-5 h-5 opacity-50" />
                <input
                    x-ref="searchInput"
                    x-model="searchQuery"
                    type="search"
                    placeholder="{{ __('nav.search') }}"
                    class="flex-1 text-base text-gray-800 placeholder:text-gray-400 focus:outline-none"
                    @keydown.escape="closeSearch()"
                />
                <button type="button" @click="closeSearch()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="max-h-80 overflow-y-auto py-2">
                <template x-if="filteredPages.length === 0">
                    <p class="px-5 py-8 text-center text-sm text-gray-400">{{ __('nav.search_no_results') }}</p>
                </template>

                <template x-for="page in filteredPages" :key="page.url">
                    <button
                        type="button"
                        @click="goToPage(page.url)"
                        class="w-full text-left px-5 py-3 hover:bg-primary/5 transition-colors flex flex-col gap-0.5"
                    >
                        <span class="text-gray-900 font-semibold text-sm" x-text="page.title"></span>
                        <span class="text-gray-500 text-xs" x-text="page.description"></span>
                    </button>
                </template>

                <p x-show="searchQuery.trim() === '' && filteredPages.length > 0" class="px-5 py-4 text-xs text-gray-400 text-center">
                    {{ __('nav.search_empty') }}
                </p>
            </div>
        </div>
    </div>
</nav>

{{-- ====================================================
     MOBILE BOTTOM NAVIGATION BAR
     Hanya tampil di layar < lg — di luar <nav> agar
     fixed bottom-0 bekerja relatif ke viewport
===================================================== --}}
@php
    $currentPath = '/' . request()->path();
    $isService   = str_starts_with(request()->path(), 'service');
@endphp

<div class="lg:hidden fixed bottom-0 left-0 right-0 z-[90]">
    <div class="bg-white/95 backdrop-blur-md border-t border-gray-200/80 shadow-[0_-4px_24px_rgba(0,0,0,0.08)]">
        <div class="flex items-stretch justify-around px-2 pt-2 pb-2">

            {{-- Home --}}
            <a href="/"
               class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition-all duration-200 active:scale-90
                      {{ $currentPath === '/' ? 'text-primary' : 'text-gray-400' }}">
                <div class="relative">
                    @if($currentPath === '/')
                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-primary"></div>
                    @endif
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="{{ $currentPath === '/' ? '2.5' : '1.8' }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span class="text-[10px] font-{{ $currentPath === '/' ? 'bold' : 'medium' }} leading-none">{{ __('nav.home') }}</span>
            </a>

            {{-- Rental --}}
            <a href="/rental"
               class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition-all duration-200 active:scale-90
                      {{ $currentPath === '/rental' ? 'text-primary' : 'text-gray-400' }}">
                <div class="relative">
                    @if($currentPath === '/rental')
                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-primary"></div>
                    @endif
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="{{ $currentPath === '/rental' ? '2.5' : '1.8' }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <span class="text-[10px] font-{{ $currentPath === '/rental' ? 'bold' : 'medium' }} leading-none">{{ __('nav.rental') }}</span>
            </a>

            {{-- Layanan (center - floating button) --}}
            <a href="/service"
               class="flex flex-col items-center gap-1 px-2 py-1 -mt-5 transition-all duration-200 active:scale-90">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg shadow-primary/30 transition-all duration-200
                            {{ $isService ? 'bg-primary scale-105' : 'bg-gradient-to-b from-blue-400 to-sky-600' }}">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <span class="text-[10px] font-bold leading-none mt-1 {{ $isService ? 'text-primary' : 'text-gray-500' }}">{{ __('nav.services') }}</span>
            </a>

            {{-- Tentang --}}
            <a href="/about"
               class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition-all duration-200 active:scale-90
                      {{ $currentPath === '/about' ? 'text-primary' : 'text-gray-400' }}">
                <div class="relative">
                    @if($currentPath === '/about')
                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-primary"></div>
                    @endif
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="{{ $currentPath === '/about' ? '2.5' : '1.8' }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-{{ $currentPath === '/about' ? 'bold' : 'medium' }} leading-none">{{ __('nav.about') }}</span>
            </a>

            {{-- Info Gunung --}}
            <a href="/info-gunung"
               class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition-all duration-200 active:scale-90
                      {{ $currentPath === '/info-gunung' ? 'text-primary' : 'text-gray-400' }}">
                <div class="relative">
                    @if($currentPath === '/info-gunung')
                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-primary"></div>
                    @endif
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="{{ $currentPath === '/info-gunung' ? '2.5' : '1.8' }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 15m0 0l6-6m0 0l4 4m0 0l8-8M3 15v4m6-10v10m4-10v10m8-14v14"/>
                    </svg>
                </div>
                <span class="text-[10px] font-{{ $currentPath === '/info-gunung' ? 'bold' : 'medium' }} leading-none">Info Gunung</span>
            </a>

            {{-- Kontak --}}
            <a href="/contact"
               class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition-all duration-200 active:scale-90
                      {{ $currentPath === '/contact' ? 'text-primary' : 'text-gray-400' }}">
                <div class="relative">
                    @if($currentPath === '/contact')
                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-primary"></div>
                    @endif
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="{{ $currentPath === '/contact' ? '2.5' : '1.8' }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-{{ $currentPath === '/contact' ? 'bold' : 'medium' }} leading-none">{{ __('nav.contact') }}</span>
            </a>

        </div>
    </div>
</div>

{{-- Spacer agar konten tidak tertutup bottom bar --}}
<div class="lg:hidden h-[72px]"></div>
