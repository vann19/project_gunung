<nav class="w-full py-2 bg-primary border-b border-neutral-700/10 backdrop-blur-[6px] sticky top-0 z-50">
    <div class="w-full px-6 lg:px-12 py-4 flex justify-between items-center">
        
        {{-- KIRI: Logo --}}
        <div class="flex-1 flex justify-start">
            <a href="/">
                <img class="w-auto h-12 object-contain" src="{{ asset('img/logo (1) 1.png') }}" alt="{{ config('app.name') }} Logo" />
            </a>
        </div>

        {{-- TENGAH: Desktop Navigation --}}
        <div class="hidden lg:flex justify-center items-center gap-8">
            <a href="/" class="pb-1 border-b-2 border-stone-300 flex flex-col justify-start items-start transition-colors">
                <div class="text-stone-300 text-base font-bold leading-6">Home</div>
            </a>
            
            <a href="#" class="flex flex-col justify-start items-start group">
                <div class="flex justify-start items-center gap-1">
                    <div class="text-stone-300 text-base font-normal leading-6 group-hover:text-white transition-colors">Rental Alat</div>
                    <div class="flex flex-col justify-start items-center">
                        <svg class="w-2 h-2 text-stone-300 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </a>
            
            <a href="#" class="flex flex-col justify-start items-start group">
                <div class="flex justify-start items-center gap-1">
                    <div class="text-stone-300 text-base font-normal leading-6 group-hover:text-white transition-colors">Service</div>
                    <div class="flex flex-col justify-start items-center">
                        <svg class="w-2 h-2 text-stone-300 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </a>
            
            <a href="#" class="flex flex-col justify-start items-start">
                <div class="text-stone-300 text-base font-normal leading-6 hover:text-white transition-colors">About</div>
            </a>
            
            <a href="#" class="flex flex-col justify-start items-start">
                <div class="text-stone-300 text-base font-normal leading-6 hover:text-white transition-colors">Contact</div>
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
            
            <a href="/login" class="px-6 py-2 bg-lime-600 hover:bg-lime-500 rounded-full flex flex-col justify-center items-center transition-all shadow-sm active:scale-95 cursor-pointer">
                <div class="text-amber-950 text-base font-bold leading-6">Login</div>
            </a>
        </div>

        {{-- KANAN: Mobile Menu Button (Hamburger) --}}
        <div class="lg:hidden flex flex-1 justify-end items-center">
            <button type="button" class="text-stone-300 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>
</nav>
