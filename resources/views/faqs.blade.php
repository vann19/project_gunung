<x-layouts.app title="FAQ (Tanya Jawab) - {{ config('app.name') }}" description="Temukan jawaban atas pertanyaan yang sering diajukan mengenai layanan rental, open trip, dan guide pendakian.">
    
    {{-- Header --}}
    <section class="pt-28 pb-12 bg-white border-b border-slate-100">
        <div class="max-w-4xl mx-auto px-6 lg:px-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-800 tracking-tight">Tanya Jawab (FAQ)</h1>
            <p class="mt-4 text-slate-500 text-lg">Temukan jawaban atas pertanyaan yang sering diajukan oleh sobat pendaki.</p>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-16 bg-surface-soft min-h-screen">
        <div class="max-w-3xl mx-auto px-6 lg:px-12" x-data="{ active: null }">
            
            <div class="space-y-4">
                @forelse($faqs as $faq)
                <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-xs">
                    <button @click="active !== {{ $faq->id }} ? active = {{ $faq->id }} : active = null" 
                            class="w-full flex items-center justify-between p-6 text-left focus:outline-hidden transition-colors hover:bg-slate-50">
                        <span class="text-lg font-bold text-slate-800 pr-4" :class="active === {{ $faq->id }} ? 'text-primary' : ''">
                            {{ $faq->question }}
                        </span>
                        <span class="shrink-0 text-slate-400 transition-transform duration-300" 
                              :class="active === {{ $faq->id }} ? 'rotate-180 text-primary' : ''">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </button>
                    
                    <div x-show="active === {{ $faq->id }}" 
                         x-collapse 
                         x-cloak
                         class="px-6 pb-6 text-slate-600 prose prose-slate max-w-none">
                        <div class="pt-2 border-t border-slate-100">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-20 text-center">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <h3 class="text-lg font-bold text-slate-700">Belum Ada FAQ</h3>
                    <p class="text-slate-500 mt-2">Daftar tanya jawab sedang dalam tahap penyusunan.</p>
                </div>
                @endforelse
            </div>

        </div>
    </section>

</x-layouts.app>
