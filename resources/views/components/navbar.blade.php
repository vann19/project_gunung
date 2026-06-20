<nav class="w-full py-2 bg-white border-b border-neutral-700/10 backdrop-blur-[6px] sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <div class="w-full px-6 lg:px-12 py-4 flex justify-between items-center">
        
        {{-- KIRI: Logo --}}
        <div class="flex-1 flex justify-start">
            <a href="/">
                <img class="w-auto h-12 object-contain" src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }} Logo" />
            </a>
        </div>

{{-- Script AlpineJS untuk state navbar --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.15.12/dist/cdn.min.js"></script>

        {{-- TENGAH: Desktop Navigation --}}
        <div class="hidden lg:flex justify-center items-center gap-8" x-data="{ active: '{{ Str::startsWith(request()->path(), 'service') ? '/service' : (request()->path() == '/' ? '/' : '/' . request()->path()) }}' }">
            
            <a href="/" @click="active = '/'" :class="active === '/' ? 'border-b-2 border-primary' : 'border-b-0'" class="pb-1 flex flex-col justify-start items-start transition-all group">
                <div :class="active === '/' ? 'font-bold text-primary' : 'font-normal text-primary/75'" class="text-base leading-6 transition-colors group-hover:text-primary">Home</div>
            </a>
            
            <a href="/rental" @click="active = '/rental'" :class="active === '/rental' ? 'border-b-2 border-primary' : 'border-b-0'" class="pb-1 flex flex-col justify-start items-start group transition-all">
                <div class="flex justify-start items-center gap-1">
                    <div :class="active === '/rental' ? 'font-bold text-primary' : 'font-normal text-primary/75'" class="text-base leading-6 transition-colors group-hover:text-primary">Rental Alat</div>
                    <div class="flex flex-col justify-start items-center">
                        <svg class="w-2 h-2 text-primary/75 group-hover:text-primary transition-colors" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </a>
            
            <div class="relative" x-data="{ serviceOpen: false }" @mouseenter="serviceOpen = true" @mouseleave="serviceOpen = false">
                <a href="/service" @click="active = '/service'" :class="active === '/service' ? 'border-b-2 border-primary' : 'border-b-0'" class="pb-1 flex flex-col justify-start items-start group transition-all">
                    <div class="flex justify-start items-center gap-1">
                        <div :class="active === '/service' ? 'font-bold text-primary' : 'font-normal text-primary/75'" class="text-base leading-6 transition-colors group-hover:text-primary">Layanan</div>
                        <div class="flex flex-col justify-start items-center">
                            <svg :class="serviceOpen ? 'rotate-180' : 'rotate-0'" class="w-2 h-2 text-primary/75 group-hover:text-primary transition-all" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </a>

                {{-- Dropdown Layanan --}}
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
                <div :class="active === '/about' ? 'font-bold text-primary' : 'font-normal text-primary/75'" class="text-base leading-6 transition-colors group-hover:text-primary">About</div>
            </a>
            
            <a href="/contact" @click="active = '/contact'" :class="active === '/contact' ? 'border-b-2 border-primary' : 'border-b-0'" class="pb-1 flex flex-col justify-start items-start group transition-all">
                <div :class="active === '/contact' ? 'font-bold text-primary' : 'font-normal text-primary/75'" class="text-base leading-6 transition-colors group-hover:text-primary">Contact</div>
            </a>
        </div>

        {{-- KANAN: Actions / Buttons (Desktop) --}}
        <div class="hidden lg:flex flex-1 justify-end items-center gap-5">
            {{-- Icons --}}
            <button class="text hover:text-primary transition-colors group">
                <img src="{{ asset('icon/search.svg') }}" alt="Search" class="w-5 h-5 " />
            </button>
            <button class="text hover:text-primary transition-colors group">
                <img src="{{ asset('icon/translete.svg') }}" alt="Translate" class="w-5 h-5 " />
            </button>
            
            <a href="/login" class="px-6 py-2 bg-linear-to-b from-blue-300 to-sky-600 hover:from-blue-400 hover:to-sky-700 hover:scale-105 hover:shadow-lg rounded-full inline-flex flex-col justify-center items-center transition-all duration-300 cursor-pointer">
                <div class="text-center justify-center text-white text-base font-bold leading-6">Login</div>
            </a>
        </div>

        {{-- KANAN: Mobile Menu Button (Hamburger) --}}
        <div class="lg:hidden flex flex-1 justify-end items-center">
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-primary/75 hover:text-primary focus:outline-none transition-colors">
                <svg x-show="!mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-show="mobileMenuOpen" class="w-7 h-7" style="display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu Dropdown --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden absolute top-full left-0 w-full bg-white backdrop-blur-md border-b border-neutral-700/10"
         style="display: none;"
         @click.away="mobileMenuOpen = false">
        
        <div class="px-6 py-4 flex flex-col gap-4">
            <a href="/" class="text-primary/75 hover:text-primary text-lg font-medium transition-colors py-2 border-b border-primary/5">Home</a>
            <a href="/rental" class="text-primary/75 hover:text-primary text-lg font-medium transition-colors py-2 border-b border-primary/5">Rental Alat</a>
            <a href="/service" class="text-primary/75 hover:text-primary text-lg font-medium transition-colors py-2 border-b border-primary/5">Layanan</a>
            <a href="/about" class="text-primary/75 hover:text-primary text-lg font-medium transition-colors py-2 border-b border-primary/5">About</a>
            <a href="/contact" class="text-primary/75 hover:text-primary text-lg font-medium transition-colors py-2 border-b border-primary/5">Contact</a>
            
            <div class="flex items-center gap-6 pt-4 pb-2">
                <a href="/login" class="w-full text-center py-3 bg-linear-to-b from-blue-300 to-sky-600 rounded-lg text-white text-base font-bold transition-all active:scale-95">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>