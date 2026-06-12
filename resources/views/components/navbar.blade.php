<nav class="w-full py-2 bg-primary border-b border-neutral-700/10 backdrop-blur-[6px] sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <div class="w-full px-6 lg:px-12 py-4 flex justify-between items-center">
        
        {{-- KIRI: Logo --}}
        <div class="flex-1 flex justify-start">
            <a href="/">
                <img class="w-auto h-12 object-contain" src="{{ asset('img/logo (1) 1.png') }}" alt="{{ config('app.name') }} Logo" />
            </a>
        </div>

{{-- Script AlpineJS untuk state navbar --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.15.12/dist/cdn.min.js"></script>

        {{-- TENGAH: Desktop Navigation --}}
        <div class="hidden lg:flex justify-center items-center gap-8" x-data="{ active: '{{ request()->path() == '/' ? '/' : '/' . request()->path() }}' }">
            
            <a href="/" @click="active = '/'" :class="active === '/' ? 'border-stone-300' : 'border-transparent'" class="pb-1 border-b-2 flex flex-col justify-start items-start transition-colors group">
                <div :class="active === '/' ? 'font-bold text-white' : 'font-normal text-stone-300 group-hover:text-white'" class="text-base leading-6 transition-colors">Home</div>
            </a>
            
            <a href="/rental" @click="active = '/rental'" :class="active === '/rental' ? 'border-stone-300' : 'border-transparent'" class="pb-1 border-b-2 flex flex-col justify-start items-start group transition-colors">
                <div class="flex justify-start items-center gap-1">
                    <div :class="active === '/rental' ? 'font-bold text-white' : 'font-normal text-stone-300 group-hover:text-white'" class="text-base leading-6 transition-colors">Rental Alat</div>
                    <div class="flex flex-col justify-start items-center">
                        <svg class="w-2 h-2 text-stone-300 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </a>
            
            <a href="/service" @click="active = '/service'" :class="active === '/service' ? 'border-stone-300' : 'border-transparent'" class="pb-1 border-b-2 flex flex-col justify-start items-start group transition-colors">
                <div class="flex justify-start items-center gap-1">
                    <div :class="active === '/service' ? 'font-bold text-white' : 'font-normal text-stone-300 group-hover:text-white'" class="text-base leading-6 transition-colors">Service</div>
                    <div class="flex flex-col justify-start items-center">
                        <svg class="w-2 h-2 text-stone-300 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </a>
            
            <a href="/about" @click="active = '/about'" :class="active === '/about' ? 'border-stone-300' : 'border-transparent'" class="pb-1 border-b-2 flex flex-col justify-start items-start group transition-colors">
                <div :class="active === '/about' ? 'font-bold text-white' : 'font-normal text-stone-300 group-hover:text-white'" class="text-base leading-6 transition-colors">About</div>
            </a>
            
            <a href="/contact" @click="active = '/contact'" :class="active === '/contact' ? 'border-stone-300' : 'border-transparent'" class="pb-1 border-b-2 flex flex-col justify-start items-start group transition-colors">
                <div :class="active === '/contact' ? 'font-bold text-white' : 'font-normal text-stone-300 group-hover:text-white'" class="text-base leading-6 transition-colors">Contact</div>
            </a>
        </div>

        {{-- KANAN: Actions / Buttons (Desktop) --}}
        <div class="hidden lg:flex flex-1 justify-end items-center gap-5">
            {{-- Icons --}}
            <button class="text-stone-300 hover:text-white transition-colors">
                <img src="{{ asset('icon/search.svg') }}" alt="Search" class="w-5 h-5 opacity-80 hover:opacity-100 transition-opacity" />
            </button>
            <button class="text-stone-300 hover:text-white transition-colors">
                <img src="{{ asset('icon/translete.svg') }}" alt="Translate" class="w-5 h-5 opacity-80 hover:opacity-100 transition-opacity" />
            </button>
            
            <a href="/login" class="px-6 py-2 bg-hijau hover:bg-hijau/80 rounded-full flex flex-col justify-center items-center transition-all shadow-sm active:scale-95 cursor-pointer">
                <div class="text-amber-950 text-base font-bold leading-6">Login</div>
            </a>
        </div>

        {{-- KANAN: Mobile Menu Button (Hamburger) --}}
        <div class="lg:hidden flex flex-1 justify-end items-center">
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-stone-300 hover:text-white focus:outline-none transition-colors">
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
         class="lg:hidden absolute top-full left-0 w-full bg-primary/95 backdrop-blur-md border-b border-neutral-700/10"
         style="display: none;"
         @click.away="mobileMenuOpen = false">
        
        <div class="px-6 py-4 flex flex-col gap-4">
            <a href="/" class="text-stone-300 hover:text-white text-lg font-medium transition-colors py-2 border-b border-white/5">Home</a>
            <a href="/rental" class="text-stone-300 hover:text-white text-lg font-medium transition-colors py-2 border-b border-white/5">Rental Alat</a>
            <a href="/service" class="text-stone-300 hover:text-white text-lg font-medium transition-colors py-2 border-b border-white/5">Service</a>
            <a href="/about" class="text-stone-300 hover:text-white text-lg font-medium transition-colors py-2 border-b border-white/5">About</a>
            <a href="/contact" class="text-stone-300 hover:text-white text-lg font-medium transition-colors py-2 border-b border-white/5">Contact</a>
            
            <div class="flex items-center gap-6 pt-4 pb-2">
                <a href="/login" class="w-full text-center py-3 bg-hijau hover:bg-hijau/80 rounded-lg text-amber-950 text-base font-bold transition-all active:scale-95">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>
