<div class="flex flex-col justify-center items-center text-center bg-white">
        <h1 class="text-lg md:text-2xl text-primary">Apa Kata Mereka?</h1>
        <h2 class="text-2xl md:text-4xl py-6 md:py-12 text-primary font-bold mt-2 md:mt-4">Testimoni Dari Pendaki Kami</h2>
    </div>

<div class="relative py-10 bg-white overflow-hidden">
    <!-- Background peta -->
    <img src="{{ asset('img/peta.png') }}"
    alt="Peta Dunia"
    class="absolute inset-0 w-full h-full object-cover ">
    
    <!-- Content -->
    <div class="relative z-10 flex items-center justify-center gap-6">
        
        <!-- Rating -->
        <img src="img/4.9.png" alt="">

        <!-- Bintang + Text -->
        <div>
            <div class="flex items-center gap-1">
                <img src="icon/star.svg" alt="">
                <img src="icon/star.svg" alt="">
                <img src="icon/star.svg" alt="">
                <img src="icon/star.svg" alt="">
                <img src="icon/star.svg" alt="">
            </div>

            <p class="text-gray-700 text-2xl font-medium">
                dari 350+ review di Google
            </p>
        </div>

        <!-- Logo Google -->
        <img src="{{ asset('img/goggle.png') }}"
             alt="Google"
             class="w-16 h-16">
    </div>


    {{-- Review Cards --}}
    <div class="relative z-10 mt-30 px-6 lg:px-16">
        <div class="flex gap-6 overflow-x-auto pb-4 scrollbar-hide">

            {{-- Card 1 --}}
            <div class="w-[440px] h-72 shrink-0 relative bg-biruputih rounded-3xl border border-sky-700">
                {{-- Quote Icon --}}
                <div class="absolute left-[20px] top-[18px]">
                    <img src="{{ asset('img/titikkoma.png') }}" alt="" class="w-16 h-16">
                </div>
                {{-- Stars --}}
                <div class="flex items-center gap-[3px] absolute left-[92px] top-[32px]">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                </div>
                {{-- Review Text --}}
                <p class="absolute left-[26px] top-[64px] right-[26px] text-stone-900/75 text-base font-semibold font-[Hanken_Grotesk] leading-6">
                    "kualitas barang sewaan bagus banget, buruan yang mau sewa alat' buat camping sini dah, sepatu, celana, tas, jaket semua pada baru
                </p>
                {{-- Avatar --}}
                <div class="size-14 absolute left-[26px] top-[193px] overflow-hidden rounded-full bg-sky-950 flex items-center justify-center">
                    <svg class="w-7 h-7 text-sky-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                    </svg>
                </div>
                {{-- Name & Date --}}
                <p class="absolute left-[106px] top-[193px] text-stone-900 text-base font-black font-[Hanken_Grotesk] leading-6">Farel Agistya</p>
                <p class="absolute left-[106px] top-[219px] text-stone-900/75 text-xs font-semibold font-[Hanken_Grotesk] leading-6">seminggu lalu</p>
                {{-- Google Logo --}}
                <img class="size-11 absolute right-[16px] top-[201px]" src="{{ asset('img/goggle.png') }}" alt="Google">
            </div>

            {{-- Card 2 --}}
            <div class="w-[440px] h-72 shrink-0 relative bg-biruputih rounded-3xl border border-sky-700">
                <div class="absolute left-[20px] top-[18px]">
                    <img src="{{ asset('img/titikkoma.png') }}" alt="" class="w-16 h-16">
                </div>
                <div class="flex items-center gap-[3px] absolute left-[92px] top-[32px]">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                </div>
                <p class="absolute left-[26px] top-[64px] right-[26px] text-stone-900/75 text-base font-semibold font-[Hanken_Grotesk] leading-6">
                    "kualitas barang sewaan bagus banget, buruan yang mau sewa alat' buat camping sini dah, sepatu, celana, tas, jaket semua pada baru
                </p>
                <div class="size-14 absolute left-[26px] top-[193px] overflow-hidden rounded-full bg-sky-950 flex items-center justify-center">
                    <svg class="w-7 h-7 text-sky-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                    </svg>
                </div>
                <p class="absolute left-[106px] top-[193px] text-stone-900 text-base font-black font-[Hanken_Grotesk] leading-6">Farel Agistya</p>
                <p class="absolute left-[106px] top-[219px] text-stone-900/75 text-xs font-semibold font-[Hanken_Grotesk] leading-6">seminggu lalu</p>
                <img class="size-11 absolute right-[16px] top-[201px]" src="{{ asset('img/goggle.png') }}" alt="Google">
            </div>

            {{-- Card 3 --}}
            <div class="w-[440px] h-72 shrink-0 relative bg-biruputih rounded-3xl border border-sky-700">
                <div class="absolute left-[20px] top-[18px]">
                    <img src="{{ asset('img/titikkoma.png') }}" alt="" class="w-16 h-16">
                </div>
                <div class="flex items-center gap-[3px] absolute left-[92px] top-[32px]">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                    <img src="{{ asset('icon/star.svg') }}" alt="star" class="w-5 h-5">
                </div>
                <p class="absolute left-[26px] top-[64px] right-[26px] text-stone-900/75 text-base font-semibold font-[Hanken_Grotesk] leading-6">
                    "kualitas barang sewaan bagus banget, buruan yang mau sewa alat' buat camping sini dah, sepatu, celana, tas, jaket semua pada baru
                </p>
                <div class="size-14 absolute left-[26px] top-[193px] overflow-hidden rounded-full bg-sky-950 flex items-center justify-center">
                    <svg class="w-7 h-7 text-sky-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                    </svg>
                </div>
                <p class="absolute left-[106px] top-[193px] text-stone-900 text-base font-black font-[Hanken_Grotesk] leading-6">Farel Agistya</p>
                <p class="absolute left-[106px] top-[219px] text-stone-900/75 text-xs font-semibold font-[Hanken_Grotesk] leading-6">seminggu lalu</p>
                <img class="size-11 absolute right-[16px] top-[201px]" src="{{ asset('img/goggle.png') }}" alt="Google">
            </div>

        </div>

        {{-- CTA Button --}}
        <div class="flex justify-center mt-8">
            <a href="#" class="inline-flex items-center gap-2 bg-kuningbaru text-gray-800 font-semibold px-8 py-3 rounded-full shadow-md hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                Lihat Semua Review Google
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>

</div>

