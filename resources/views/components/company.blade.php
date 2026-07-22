<div class="w-full py-20 lg:py-32 bg-white text-white overflow-hidden relative">
    <div class="w-full max-w-screen-2xl mx-auto px-6 lg:px-12 flex flex-col lg:flex-row-reverse items-center gap-16 lg:gap-24 relative z-10">

        {{-- KANAN: Teks & Info --}}
        <div class="w-full lg:w-1/2 flex flex-col items-start gap-8">
            <div class="flex flex-col gap-4">
                <h3 class="self-stretch justify-center text-biru text-3xl font-medium leading-10">{{ __('home.company_badge') }}</h3>
                <div class="w-20 h-1 bg-primary rounded-full"></div>
            </div>

            <div class="bg-linear-to-b from-blue-300 to-sky-600 bg-clip-text text-transparent self-stretch justify-center text-4xl font-extrabold leading-[50px]">
                {!! nl2br(e(__('home.company_title'))) !!}
            </div>

            <p class="text-black text-lg leading-relaxed">{{ __('home.company_desc') }}</p>

            <div class="flex flex-col gap-5 mt-2">
                <div class="flex items-center gap-4 group">
                    <img src="{{ asset('icon/acc.svg') }}" alt="Check" class="w-6 h-6 flex-shrink-0 transition-transform group-hover:scale-110" />
                    <span class="text-black text-lg">{{ __('home.company_point_1') }}</span>
                </div>
                <div class="flex items-center gap-4 group">
                    <img src="{{ asset('icon/acc.svg') }}" alt="Check" class="w-6 h-6 flex-shrink-0 transition-transform group-hover:scale-110" />
                    <span class="text-black text-lg">{{ __('home.company_point_2') }}</span>
                </div>
                <div class="flex items-center gap-4 group">
                    <img src="{{ asset('icon/acc.svg') }}" alt="Check" class="w-6 h-6 flex-shrink-0 transition-transform group-hover:scale-110" />
                    <span class="text-black text-lg">{{ __('home.company_point_3') }}</span>
                </div>
            </div>
        </div>

        {{-- KIRI: Gambar --}}
        <div class="w-full lg:w-1/2 relative mt-10 lg:mt-0">
            <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-stone-300/10 rounded-full blur-[40px] z-0 pointer-events-none"></div>
            <div class="absolute -top-6 -left-6 w-24 h-24 opacity-60 rounded-tl-3xl border-l-2 border-t-2 border-stone-400 z-0 pointer-events-none transition-all duration-500 hover:-translate-x-2 hover:-translate-y-2"></div>
            <div class="relative z-10 w-full rounded-2xl shadow-2xl overflow-hidden aspect-[4/3] group">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300 z-20"></div>
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                     src="{{ asset('img/ruangan.jpeg') }}"
                     alt="Company Profile Image" />
            </div>
        </div>

    </div>
</div>
