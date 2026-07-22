<footer class="bg-biruputih pt-16 pb-8 px-6 lg:px-24 w-full">
    <div class="mx-auto flex flex-col gap-12">

        {{-- Top Section: 3 Columns --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">

            {{-- Column 1: Logo & Address --}}
            <div class="flex flex-col gap-4">
                <img src="{{ asset('img/logo.png') }}" alt="Basecamp Outdoor" class="h-12 w-auto object-contain object-left mb-2">
                <p class="text-sm text-gray-600 leading-relaxed max-w-[260px]">
                    Jaranan Jl. Pedak, Jaranan,<br>
                    Banguntapan, Kec. Banguntapan,<br>
                    Kabupaten Bantul, Daerah<br>
                    Istimewa Yogyakarta 55198
                </p>
                <div class="flex gap-3 mt-2">
                    <a href="https://www.instagram.com/basecamp.outdoorr?igsh=ZmQxdW1sczVpajU5" target="_blank" class="w-9 h-9 rounded-full flex items-center justify-center text-gray-700 hover:text-pink-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4zm9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3" />
                        </svg>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full flex items-center justify-center text-gray-700 hover:bg-blue-400 transition-colors">
                        <img src="{{ asset('icon/lokasi.svg') }}" alt="Lokasi" class="w-8 h-8">
                    </a>
                </div>
            </div>

            {{-- Column 2: Navigasi --}}
            <div class="flex flex-col gap-4 lg:pl-4">
                <h3 class="font-bold text-sm tracking-wider text-primary mb-2 uppercase">{{ __('home.footer_nav_title') }}</h3>
                <ul class="flex flex-col gap-4 text-sm text-gray-600">
                    <li><a href="/" class="hover:text-primary transition-colors">{{ __('nav.home') }}</a></li>
                    <li><a href="/rental" class="hover:text-primary transition-colors">{{ __('nav.rental') }}</a></li>
                    <li><a href="/service" class="hover:text-primary transition-colors">{{ __('nav.services') }}</a></li>
                    <li><a href="/contact" class="hover:text-primary transition-colors">{{ __('nav.contact') }}</a></li>
                </ul>
            </div>

            {{-- Column 3: Layanan --}}
            <div class="flex flex-col gap-4">
                <h3 class="font-bold text-sm tracking-wider text-primary mb-2 uppercase">{{ __('home.layanan_badge') }}</h3>
                <ul class="flex flex-col gap-4 text-sm text-gray-600">
                    <li><a href="/rental" class="hover:text-primary transition-colors">{{ __('home.menu_rental_title') }}</a></li>
                    <li><a href="/service/cuci-alat" class="hover:text-primary transition-colors">{{ __('home.menu_cuci_title') }}</a></li>
                    <li><a href="/service/open-trip" class="hover:text-primary transition-colors">{{ __('home.menu_trip_title') }}</a></li>
                    <li><a href="/service/open-trip?tab=guide" class="hover:text-primary transition-colors">{{ __('home.menu_guide_title') }}</a></li>
                    <li><a href="/service/marketplace" class="hover:text-primary transition-colors">{{ __('home.menu_market_title') }}</a></li>
                </ul>
            </div>

            

        </div>

        {{-- Bottom Section: Copyright --}}
        <div class="border-t border-gray-400/40 pt-6 mt-4 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-medium text-gray-600">
            <p>{{ __('home.footer_copyright') }}</p>
            <div class="flex gap-6">
                <span>{{ __('home.footer_tagline_1') }}</span>
                <span>{{ __('home.footer_tagline_2') }}</span>
            </div>
        </div>

    </div>
</footer>