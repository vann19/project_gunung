<div class="w-full h-auto bg-white py-10 px-6">
    <div class="flex flex-col justify-center items-center text-center">
        <h1 class="text-lg md:text-2xl text-primary">{{ __('home.layanan_badge') }}</h1>
        <h2 class="text-2xl md:text-4xl py-6 md:py-12 text-primary font-bold mt-2 md:mt-4">{{ __('home.layanan_title') }}</h2>
    </div>

    {{-- grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-[1280px] mx-auto mt-4 md:mt-8">

        {{-- card 1 --}}
        <div class="flex flex-col items-center text-center p-6">
            <div class="bg-primary/8 p-4 rounded-xl mb-4">
                <img src="icon/cuci.svg" alt="cuci" class="w-8 h-8">
            </div>
            <h3 class="text-lg font-bold text-primary mb-2">{{ __('home.layanan_1_title') }}</h3>
            <p class="text-stone-900/75 text-sm leading-6">{{ __('home.layanan_1_desc') }}</p>
        </div>

        {{-- card 2 --}}
        <div class="flex flex-col items-center text-center p-6">
            <div class="bg-primary/8 p-4 rounded-xl mb-4">
                <img src="icon/guide.svg" alt="open trip" class="w-8 h-8">
            </div>
            <h3 class="text-lg font-bold text-primary mb-2">{{ __('home.layanan_2_title') }}</h3>
            <p class="text-stone-900/75 text-sm leading-6">{{ __('home.layanan_2_desc') }}</p>
        </div>

        {{-- card 3 --}}
        <div class="flex flex-col items-center text-center p-6">
            <div class="bg-primary/8 p-4 rounded-xl mb-4">
                <img src="icon/tag.svg" alt="tag" class="w-8 h-8">
            </div>
            <h3 class="text-lg font-bold text-primary mb-2">{{ __('home.layanan_3_title') }}</h3>
            <p class="text-stone-900/75 text-sm leading-6">{{ __('home.layanan_3_desc') }}</p>
        </div>

        {{-- card 4 --}}
        <div class="flex flex-col items-center text-center p-6">
            <div class="bg-primary/8 p-4 rounded-xl mb-4">
                <img src="icon/label.svg" alt="cuci" class="w-8 h-8">
            </div>
            <h3 class="text-lg font-bold text-primary mb-2">{{ __('home.layanan_4_title') }}</h3>
            <p class="text-stone-900/75 text-sm leading-6">{{ __('home.layanan_4_desc') }}</p>
        </div>

    </div>
</div>
