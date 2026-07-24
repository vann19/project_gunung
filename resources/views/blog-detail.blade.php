<x-layouts.app title="{{ $blog->title }} - {{ config('app.name') }}" description="{{ Str::limit(strip_tags($blog->content), 150) }}">
    
    <article class="pt-24 pb-16 lg:pb-24 bg-white min-h-screen">
        <div class="max-w-4xl mx-auto px-6 lg:px-12">
            
            {{-- Breadcrumb --}}
            <nav class="flex text-sm text-slate-500 mb-8 mt-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('blog.index') }}" class="hover:text-primary transition-colors">Blog</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-slate-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            <span class="text-slate-400 line-clamp-1">{{ $blog->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            {{-- Header Artikel --}}
            <header class="mb-10 text-center lg:text-left">
                <div class="text-sm font-semibold text-primary mb-4 tracking-wider uppercase">{{ $blog->created_at->format('d F Y') }}</div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight leading-tight mb-6">
                    {{ $blog->title }}
                </h1>
            </header>

            {{-- Cover Image --}}
            @if($blog->image)
            <div class="mb-12 rounded-3xl overflow-hidden bg-slate-100 shadow-lg border border-slate-200/50">
                <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="w-full h-auto max-h-[500px] object-cover">
            </div>
            @endif

            {{-- Konten Artikel --}}
            <div class="prose prose-slate prose-lg md:prose-xl max-w-none 
                        prose-headings:font-bold prose-headings:tracking-tight prose-headings:text-slate-900
                        prose-a:text-primary hover:prose-a:text-primary/80
                        prose-img:rounded-2xl prose-img:border prose-img:border-slate-200/60 prose-img:shadow-sm">
                {!! nl2br(e($blog->content)) !!}
            </div>

            {{-- Share & Back --}}
            <div class="mt-16 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-primary font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Artikel Lainnya
                </a>
            </div>

        </div>
    </article>

</x-layouts.app>
