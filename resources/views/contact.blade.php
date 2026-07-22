<x-layouts.app title="Kontak - {{ config('app.name') }}" description="Hubungi kami untuk pertanyaan, kerja sama, atau reservasi ekspedisi.">

    {{-- Hero Section --}}
    <section class="relative w-full h-[380px] overflow-hidden">
        <img src="{{ asset('img/cucialat.jpeg') }}" class="w-full h-full object-cover object-center" alt="Hero Kontak">
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/30 to-black/60 flex flex-col items-center justify-center text-center px-6">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 drop-shadow-lg">{{ __('contact.hero_title') }}</h1>
            <p class="text-white/80 text-base md:text-lg max-w-xl">
                {{ __('contact.hero_desc') }}
            </p>
        </div>
    </section>

    {{-- Main Contact Section --}}
    <section class="bg-white py-16 px-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- Chat Admin --}}
            <div class="flex flex-col justify-center h-full">
                <div class="bg-white border border-gray-200 shadow-sm rounded-3xl p-10 lg:p-14 relative overflow-hidden group h-full flex flex-col justify-center">
                    {{-- Dekorasi Background --}}
                    <div class="absolute top-0 right-0 w-64 h-64 bg-green-100 rounded-full blur-3xl -mr-20 -mt-20 opacity-40 transition-opacity duration-500 group-hover:opacity-70 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-40 h-40 bg-blue-50 rounded-full blur-2xl -ml-10 -mb-10 opacity-60 pointer-events-none"></div>
                    
                    <div class="relative z-10">
                    
                        
                        <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-4 tracking-tight leading-tight">{{ __('contact.need_help_title') }}</h2>
                        
                        <p class="text-gray-500 text-base leading-relaxed mb-10 max-w-md">
                            {{ __('contact.need_help_desc') }}
                        </p>
                        
                        <a href="https://wa.me/6281227387668" target="_blank"
                            class="inline-flex items-center justify-center gap-3 bg-[#25D366] hover:bg-[#1DA851] text-white font-bold px-8 py-4 rounded-2xl transition-all duration-300 hover:shadow-2xl hover:shadow-[#25D366]/30 hover:-translate-y-1 w-full sm:w-auto text-base">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            {{ __('contact.start_chat') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Info Cards --}}
            <div class="flex flex-col gap-5">

                {{-- Lokasi Kantor --}}
                <div class="bg-[#f8f9fb] border border-gray-100 rounded-xl p-5 flex gap-4">
                    <div class="w-10 h-10 bg-white border-2 border-primary rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm mb-1">{{ __('contact.office_location') }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {!! __('contact.office_address') !!}
                        </p>
                        <a href="https://maps.google.com/?q=Basecamp+Outdoor+Jogja+Jaranan+Banguntapan+Bantul" target="_blank"
                            class="text-primary text-xs font-semibold hover:underline mt-2 inline-flex items-center gap-1">
                            {{ __('contact.view_maps') }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>

               

              

                {{-- Sosial Media --}}
                <div class="bg-[#f8f9fb] border border-gray-100 rounded-xl p-5 flex gap-4">
                    <div class="w-10 h-10 bg-white border-2 border-primary rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4zm9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm mb-1">{{ __('contact.social_media') }}</h3>
                        <p class="text-gray-500 text-xs mb-1.5">{{ __('contact.social_desc') }}</p>
                        <a href="https://www.instagram.com/basecamp.outdoorr?igsh=ZmQxdW1sczVpajU5" target="_blank" class="text-pink-600 text-sm font-bold hover:underline">@basecamp.outdoorr</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Lokasi Cabang / Google Maps Section --}}
    <section class="bg-[#f4f6f9] py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="mb-10 text-center">
                <span class="text-xs font-bold uppercase tracking-widest text-primary">{{ __('contact.network_badge') }}</span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">{{ __('contact.network_title') }}</h2>
                <p class="text-gray-500 text-sm mt-2 max-w-lg mx-auto">{{ __('contact.network_desc') }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">

                {{-- Card 1: Jogja (Pusat) --}}
                <a href="https://maps.app.goo.gl/t8bhCkrqerkD2fLe8" target="_blank"
                    class="group bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative h-36 overflow-hidden bg-gray-100">
                        <img src="{{ asset('img/peta.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Basecamp Jogja">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute top-3 left-3 bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">{{ __('contact.center') }}</span>
                        <p class="absolute bottom-2 left-3 text-white font-bold text-xs">Basecamp Jogja</p>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-[11px] text-gray-500 leading-relaxed flex-1">Jaranan Jl. Pedak, Jaranan, Banguntapan, Kabupaten Bantul, DIY 55198</p>
                        <span class="mt-3 text-primary text-xs font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ __('contact.open_maps') }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </span>
                    </div>
                </a>

                {{-- Card 2: Bakauheni --}}
                <a href="https://maps.app.goo.gl/H8rfZd6qS3yLeGNYA" target="_blank"
                    class="group bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative h-36 overflow-hidden bg-gray-100">
                        <img src="{{ asset('img/peta.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Basecamp Bakauheni">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute top-3 left-3 bg-slate-600 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">{{ __('contact.branch') }} 2</span>
                        <p class="absolute bottom-2 left-3 text-white font-bold text-xs">Basecamp Bakauheni</p>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-[11px] text-gray-500 leading-relaxed flex-1">Way Bakak, Kelawi, Kec. Bakauheni, Lampung Selatan, Lampung 35592</p>
                        <span class="mt-3 text-primary text-xs font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ __('contact.open_maps') }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </span>
                    </div>
                </a>

                {{-- Card 3: Kledung --}}
                <a href="https://maps.app.goo.gl/85FdzVBXXcZddQ3w8" target="_blank"
                    class="group bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative h-36 overflow-hidden bg-gray-100">
                        <img src="{{ asset('img/peta.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Basecamp Kledung">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute top-3 left-3 bg-slate-600 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">{{ __('contact.branch') }} 3</span>
                        <p class="absolute bottom-2 left-3 text-white font-bold text-xs">Basecamp Kledung</p>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-[11px] text-gray-500 leading-relaxed flex-1">Jl. Raya Parakan - Wonosobo, Kledung, Kec. Kledung, Kab. Temanggung, Jawa Tengah 56254</p>
                        <span class="mt-3 text-primary text-xs font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ __('contact.open_maps') }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </span>
                    </div>
                </a>

                {{-- Card 4: Blora --}}
                <a href="https://maps.app.goo.gl/NihNFGkaQrkSctdU9" target="_blank"
                    class="group bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative h-36 overflow-hidden bg-gray-100">
                        <img src="{{ asset('img/peta.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Basecamp Blora">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute top-3 left-3 bg-slate-600 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">{{ __('contact.branch') }} 4</span>
                        <p class="absolute bottom-2 left-3 text-white font-bold text-xs">Basecamp Blora</p>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-[11px] text-gray-500 leading-relaxed flex-1">Dk Beran, RT.02/RW.03, Beran, Randublatung, Kab. Blora, Jawa Tengah 58382</p>
                        <span class="mt-3 text-primary text-xs font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ __('contact.open_maps') }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </span>
                    </div>
                </a>

                {{-- Card 5: Solo --}}
                <a href="https://maps.app.goo.gl/g4oMYggLKrEASUVE9" target="_blank"
                    class="group bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative h-36 overflow-hidden bg-gray-100">
                        <img src="{{ asset('img/peta.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Basecamp Solo">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute top-3 left-3 bg-slate-600 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">{{ __('contact.branch') }} 5</span>
                        <p class="absolute bottom-2 left-3 text-white font-bold text-xs">Basecamp Solo</p>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-[11px] text-gray-500 leading-relaxed flex-1">Jl. Sekar Jagad No.37, Pajang, Kec. Laweyan, Kota Surakarta, Jawa Tengah 57146</p>
                        <span class="mt-3 text-primary text-xs font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ __('contact.open_maps') }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </span>
                    </div>
                </a>

                {{-- Card 6: Tegal --}}
                <a href="#" target="_blank"
                    class="group bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative h-36 overflow-hidden bg-gray-100">
                        <img src="{{ asset('img/peta.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Basecamp Tegal">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute top-3 left-3 bg-slate-600 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">{{ __('contact.branch') }} 6</span>
                        <p class="absolute bottom-2 left-3 text-white font-bold text-xs">Basecamp Tegal</p>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-[11px] text-gray-500 leading-relaxed flex-1">Timbangrejo Kulon, Timbangreja, Kec. Lebaksiu, Kabupaten Tegal, Jawa Tengah 52461</p>
                        <span class="mt-3 text-primary text-xs font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ __('contact.open_maps') }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </span>
                    </div>
                </a>

                {{-- Card 7: Kebumen --}}
                <a href="#" target="_blank"
                    class="group bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative h-36 overflow-hidden bg-gray-100">
                        <img src="{{ asset('img/peta.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Basecamp Kebumen">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute top-3 left-3 bg-slate-600 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">{{ __('contact.branch') }} 7</span>
                        <p class="absolute bottom-2 left-3 text-white font-bold text-xs">Basecamp Kebumen</p>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-[11px] text-gray-500 leading-relaxed flex-1">Jl. Kejayan KM. 7, Desa Rantewringin, Kec. Buluspesantren, Kabupaten Kebumen</p>
                        <span class="mt-3 text-primary text-xs font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ __('contact.open_maps') }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </span>
                    </div>
                </a>

            </div>
        </div>
    </section>

    {{-- Newsletter Section --}}
    

</x-layouts.app>
