<x-layouts.app title="Info Gunung - {{ config('app.name') }}" description="Informasi Gunung dan Jalur Pendakian di Jawa Tengah">
    
    {{-- Header Section --}}
    <section class="pt-32 pb-16 bg-white relative overflow-hidden">
        <div class="absolute inset-0 bg-primary/5 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight mb-4">
                Jelajahi <span class="text-primary">Gunung</span> Jawa Tengah
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Temukan informasi lengkap seputar ketinggian, lokasi, serta detail jalur dan pos-pos pendakian untuk merencanakan petualangan Anda berikutnya.
            </p>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-12 bg-gray-50/50 min-h-[50vh]">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($mountains as $mountain)
                    <a href="{{ route('info-gunung.show', $mountain->slug) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-200/60 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all duration-300 flex flex-col h-full">
                        
                        {{-- Image --}}
                        <div class="relative h-48 sm:h-56 overflow-hidden bg-gray-100">
                            @if($mountain->image)
                                <img src="{{ img_url($mountain->image) }}" alt="{{ $mountain->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-primary text-xs font-bold rounded-lg shadow-sm">
                                    {{ $mountain->elevation ?? 'Ketinggian N/A' }}
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $mountain->name }}</h3>
                            <div class="flex items-center gap-1.5 text-gray-500 mt-1.5 text-sm">
                                <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="truncate">{{ $mountain->location ?? 'Jawa Tengah' }}</span>
                            </div>
                            <p class="text-gray-600 text-sm mt-3 line-clamp-2">
                                {{ $mountain->description ?? 'Tidak ada deskripsi tersedia.' }}
                            </p>
                            <div class="mt-auto pt-5 flex items-center justify-between">
                                <span class="text-xs font-semibold text-gray-400 font-['JetBrains_Mono']">
                                    {{ $mountain->routes()->count() }} Jalur Pendakian
                                </span>
                                <span class="text-primary group-hover:translate-x-1 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <h3 class="text-xl font-bold text-gray-900">Belum ada info gunung</h3>
                        <p class="text-gray-500 mt-2">Data informasi gunung saat ini sedang kosong atau belum dipublikasikan.</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </section>

</x-layouts.app>
