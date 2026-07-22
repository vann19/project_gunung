<x-layouts.app title="{{ $mountain->name }} - Info Gunung" description="{{ Str::limit($mountain->description, 150) }}">
    
    {{-- Hero Section --}}
    <section class="relative pt-24 pb-12 lg:pt-32 lg:pb-24 overflow-hidden bg-gray-900">
        @if($mountain->image)
            <img src="{{ asset($mountain->image) }}" alt="{{ $mountain->name }}" class="absolute inset-0 w-full h-full object-cover opacity-40">
        @else
            <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-primary to-gray-900 opacity-80"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
            <a href="{{ route('info-gunung.index') }}" class="inline-flex items-center gap-2 text-white/70 hover:text-white transition-colors text-sm font-semibold mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Gunung
            </a>

            <div class="flex flex-col md:flex-row gap-6 md:items-end justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-md border border-white/10 rounded-lg text-white text-xs font-bold tracking-wider uppercase">
                            {{ $mountain->elevation ?? 'Ketinggian N/A' }}
                        </span>
                        <span class="flex items-center gap-1.5 text-white/80 text-sm font-medium">
                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $mountain->location ?? 'Lokasi tidak diketahui' }}
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight">
                        {{ $mountain->name }}
                    </h1>
                </div>
            </div>
        </div>
    </section>

    {{-- Content Section --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                {{-- Kiri: Deskripsi & Info Umum --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Informasi Gunung
                        </h3>
                        <div class="prose prose-sm sm:prose-base text-gray-600 max-w-none">
                            @if($mountain->description)
                                {!! nl2br(e($mountain->description)) !!}
                            @else
                                <p class="italic text-gray-400">Belum ada deskripsi untuk gunung ini.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kanan: Jalur Pendakian --}}
                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Jalur Pendakian & Pos</h2>

                    @if($mountain->routes->count() > 0)
                        <div class="space-y-6" x-data="{ activeRoute: 0 }">
                            @foreach($mountain->routes as $index => $route)
                                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden transition-all duration-300">
                                    
                                    {{-- Header Jalur (Clickable) --}}
                                    <button @click="activeRoute = activeRoute === {{ $index }} ? null : {{ $index }}"
                                            class="w-full flex items-center justify-between p-5 sm:p-6 text-left hover:bg-gray-50 transition-colors focus:outline-none">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900">{{ $route->name }}</h3>
                                            @if($route->basecamp_info)
                                                <p class="text-sm text-gray-500 mt-1 flex items-center gap-1.5">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                                    Basecamp: {{ $route->basecamp_info }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="shrink-0 ml-4 flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-500" :class="{ 'rotate-180 bg-primary/10 text-primary': activeRoute === {{ $index }} }">
                                            <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </button>

                                    {{-- Body Jalur (Expandable) --}}
                                    <div x-show="activeRoute === {{ $index }}" x-collapse x-cloak>
                                        <div class="p-5 sm:p-6 border-t border-gray-100 bg-gray-50/50">
                                            @if($route->description)
                                                <p class="text-sm text-gray-600 mb-6 bg-blue-50/50 p-4 rounded-xl border border-blue-100/50">
                                                    {{ $route->description }}
                                                </p>
                                            @endif

                                            <h4 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">Daftar Pos & Estimasi</h4>
                                            
                                            @if(is_array($route->posts) && count($route->posts) > 0)
                                                <div class="relative">
                                                    {{-- Garis vertikal timeline --}}
                                                    <div class="absolute left-3 top-2 bottom-2 w-0.5 bg-gray-200"></div>

                                                    <ul class="space-y-4">
                                                        @foreach($route->posts as $postIndex => $post)
                                                            <li class="relative pl-10">
                                                                {{-- Titik timeline --}}
                                                                <div class="absolute left-1.5 top-1.5 w-3.5 h-3.5 rounded-full bg-white border-2 border-primary z-10 shadow-[0_0_0_4px_rgba(249,250,251,1)]"></div>
                                                                
                                                                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                                                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                                                        <h5 class="font-bold text-gray-900">{{ $post['name'] ?? 'Pos' }}</h5>
                                                                        @if(!empty($post['estimasi']))
                                                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-orange-50 text-orange-700 text-xs font-semibold font-['JetBrains_Mono'] border border-orange-100">
                                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                                {{ $post['estimasi'] }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                    @if(!empty($post['keterangan']))
                                                                        <p class="text-sm text-gray-500 mt-2 flex items-start gap-2">
                                                                            <svg class="w-4 h-4 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                            {{ $post['keterangan'] }}
                                                                        </p>
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <div class="p-4 rounded-xl bg-gray-100/50 text-gray-500 text-sm text-center border border-gray-200 border-dashed">
                                                    Info pos untuk jalur ini belum tersedia.
                                                </div>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white p-8 rounded-2xl border border-gray-200/80 shadow-sm text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            <h3 class="text-lg font-bold text-gray-900">Belum Ada Jalur</h3>
                            <p class="text-gray-500 mt-1">Data jalur pendakian untuk gunung ini belum ditambahkan.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

</x-layouts.app>
