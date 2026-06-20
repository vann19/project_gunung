@props(['active' => 'trip'])

<nav class="w-full py-2 bg-white border-b border-neutral-700/10 backdrop-blur-[6px] sticky top-0 z-50">
    <div class="w-full px-6 lg:px-12 py-4 flex justify-between items-center">

        {{-- KIRI: Logo --}}
        <div class="flex-1 flex justify-start">
            <a href="/">
                <img class="w-auto h-12 object-contain" src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }} Logo" />
            </a>
        </div>

        {{-- TENGAH: Tab Trip / Guide --}}
        <div class="flex justify-center items-center gap-8">
            <a href="/service/open-trip" class="pb-1 flex flex-col justify-start items-start transition-all group {{ $active === 'trip' ? 'border-b-2 border-primary' : 'border-b-0' }}">
                <div class="text-base leading-6 transition-colors {{ $active === 'trip' ? 'font-bold text-primary' : 'font-normal text-primary/75 group-hover:text-primary' }}">Trip</div>
            </a>
            <a href="/service/open-trip" class="pb-1 flex flex-col justify-start items-start transition-all group {{ $active === 'guide' ? 'border-b-2 border-primary' : 'border-b-0' }}">
                <div class="text-base leading-6 transition-colors {{ $active === 'guide' ? 'font-bold text-primary' : 'font-normal text-primary/75 group-hover:text-primary' }}">Guide</div>
            </a>
        </div>

        {{-- KANAN: Actions / Buttons --}}
        <div class="flex flex-1 justify-end items-center gap-5">
            <button class="text hover:text-primary transition-colors group" aria-label="Keranjang">
                <img src="{{ asset('icon/search.svg') }}" alt="Keranjang" class="w-5 h-5" />
            </button>
            <button class="text hover:text-primary transition-colors group" aria-label="Terjemahkan">
                <img src="{{ asset('icon/translete.svg') }}" alt="Translate" class="w-5 h-5" />
            </button>

            <a href="/akun" class="px-6 py-2 bg-linear-to-b from-blue-300 to-sky-600 rounded-full inline-flex flex-col justify-center items-center">
                <div class="text-center justify-center text-white text-base font-bold leading-6">Akun</div>
            </a>
        </div>
    </div>
</nav>