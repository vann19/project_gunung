<x-layouts.app title="Service - {{ config('app.name') }}"
    description="Layanan lengkap untuk mendukung ekspedisi pendakian Anda.">

    <div class="bg-white min-h-screen">
        {{-- Hero Section --}}
        <section class="relative w-full h-[400px] overflow-hidden">
            <img src="{{ asset('img/background service.png') }}" class="w-full h-full object-cover" alt="Service Hero">
            <div class="absolute inset-0 bg-black/30 flex flex-col justify-center px-16">
                <span class="text-blue-200 font-semibold uppercase tracking-widest text-sm">{{ __('service.hero_badge') }}</span>
                <h1 class="text-5xl font-bold text-black mt-2 leading-tight">{{ __('service.hero_title') }}</h1>
                <p class="text-[#404751] mt-4 max-w-xl text-lg opacity-90">{{ __('service.hero_desc') }}</p>
            </div>
        </section>

        {{-- 2. Main Grid Layout --}}
        <div class="max-w-7xl mx-auto py-12 px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">

                {{-- ROW 1 --}}

                {{-- Cuci Alat (1/3 lebar) --}}
                <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex flex-col">
                    <div class="w-10 h-10 bg-blue-50 flex items-center justify-center rounded-lg mb-4">
                        <img src="{{ asset('icon/cuci alat.svg') }}" class="w-6 h-6" alt="Icon">
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3">{{ __('service.cuci_title') }}</h2>
                    <p class="text-gray-600 mb-4 text-sm">{{ __('service.cuci_desc') }}</p>
                    
                    <a href="{{ url('/service/cuci-alat') }}" class="mt-auto bg-[#005a8d] text-white px-6 py-2.5 rounded-md font-semibold hover:bg-[#004a75] transition-colors text-sm text-center">
                        {{ __('service.cuci_cta') }}
                    </a>
                </div>

                {{-- Open Trip (2/3 lebar) --}}
                <div class="lg:col-span-2 relative rounded-lg overflow-hidden min-h-[320px]">
                    <img src="{{ asset('img/fotogunung2.jpeg') }}"
                        class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent p-6 flex flex-col justify-end text-white">
                        <div class="flex items-center gap-2 mb-3">
                 
                        </div>
                       
                        <div class="flex items-end justify-between gap-4">
                           
                            <a href="{{ url('/service/open-trip') }}" class="bg-white text-gray-900 px-6 py-2.5 rounded-md font-semibold hover:bg-gray-100 text-sm whitespace-nowrap text-center">
                                {{ __('service.trip_cta') }}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ROW 2 --}}

                {{-- Guide Pendakian (2/3 lebar) --}}
                <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex flex-col md:flex-row gap-6">
                    <div class="flex-1">
                        <h2 class="text-xl font-bold mb-3 text-gray-900">{{ __('service.guide_title') }}</h2>
                        <p class="text-gray-600 mb-4 text-sm">{{ __('service.guide_desc') }}</p>
                        <div class="grid grid-cols-2 gap-3 mb-4">
                           
                          
                        </div>
                        <a href="{{ url('/service/open-trip') }}?tab=guide" class="bg-[#005a8d] text-white px-6 py-2.5 rounded-md font-semibold hover:bg-[#004a75] text-sm text-center">
                            {{ __('service.guide_cta') }}
                        </a>
                    </div>
                    <div class="w-full md:w-48 flex-shrink-0">
                        <div class="relative h-56 rounded-lg overflow-hidden shadow-md border-4 border-white rotate-3">
                            <img src="{{ asset('img/opentrip.jpeg') }}" class="w-full h-full object-cover" alt="Guide">
                            <div class="absolute bottom-0 left-0 right-0 bg-[#005a8d] text-white text-[10px] py-2 text-center font-bold tracking-widest uppercase">
                                {{ __('service.guide_chief') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Marketplace (1/3 lebar) --}}
                <div class="lg:col-span-1 bg-white p-5 rounded-lg shadow-sm border border-gray-200 flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="bg-yellow-100 p-1.5 rounded">
                            <img src="{{ asset('icon/market.svg') }}" class="w-5 h-5" alt="Marketplace Icon">
                        </div>
                        <h3 class="font-bold text-base">{{ __('service.market_title') }}</h3>
                    </div>
                    <p class="text-gray-600 text-xs mb-3">{{ __('service.market_desc') }}</p>
                    
                    <a href="{{ url('/service/marketplace') }}" class="mt-auto w-full border border-[#005a8d] text-[#005a8d] py-2.5 rounded-md font-semibold hover:bg-blue-50 transition-colors text-sm text-center block">
                        {{ __('service.market_cta') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>