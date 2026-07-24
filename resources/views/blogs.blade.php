<x-layouts.app title="Blog & Berita - {{ config('app.name') }}" description="Baca artikel, tips pendakian, dan berita terbaru dari Basecamps Outdoor.">
    
    {{-- Header --}}
    <section class="pt-28 pb-12 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-800 tracking-tight">Blog & Artikel</h1>
            <p class="mt-4 text-slate-500 max-w-2xl mx-auto">Temukan tips pendakian, panduan alat camping, dan cerita petualangan terbaru di sini.</p>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-16 bg-surface-soft min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($blogs as $blog)
                <a href="{{ route('blog.show', $blog->slug) }}" class="group bg-white rounded-2xl border border-slate-200/60 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                    <div class="aspect-[16/10] overflow-hidden bg-slate-100 relative">
                        @if($blog->image)
                            <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300 group-hover:scale-105 transition-transform duration-500">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6 flex flex-col grow">
                        <div class="text-xs font-semibold text-primary mb-3">{{ $blog->created_at->format('d M Y') }}</div>
                        <h2 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-primary transition-colors line-clamp-2">
                            {{ $blog->title }}
                        </h2>
                        <p class="text-slate-600 text-sm line-clamp-3 mt-auto">
                            {{ Str::limit(strip_tags($blog->content), 120) }}
                        </p>
                    </div>
                </a>
                @empty
                <div class="col-span-full py-20 text-center">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <h3 class="text-lg font-bold text-slate-700">Belum Ada Artikel</h3>
                    <p class="text-slate-500 mt-2">Nantikan tips dan berita terbaru dari kami segera!</p>
                </div>
                @endforelse
            </div>

        </div>
    </section>

</x-layouts.app>
