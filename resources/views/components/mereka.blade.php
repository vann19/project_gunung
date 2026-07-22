@php
    $dbReviews = \App\Models\Testimonial::where('is_visible', true)->latest()->get();
    
    if ($dbReviews->count() > 0) {
        $reviews = $dbReviews->map(function($review) {
            return [
                'text' => $review->text,
                'name' => $review->name,
                'date' => $review->date,
                'stars' => $review->stars,
            ];
        })->toArray();
    } else {
        $reviews = __('home.mereka_reviews');
    }

    $colors  = ['bg-sky-950','bg-primary','bg-emerald-900','bg-violet-900','bg-rose-900','bg-amber-900'];
    $initials
    = fn(string $name): string =>
        collect(explode(' ', $name))
            ->map(fn($w) => strtoupper($w[0] ?? ''))
            ->take(2)
            ->implode('');
@endphp

<section class="relative w-full bg-white pt-16 pb-20 overflow-hidden"
         x-data="{
             current: 0,
             total: {{ count($reviews) }},
             isDragging: false,
             startX: 0,
             scrollLeft: 0,
             prev() {
                 if (this.current > 0) { this.current--; this.scrollTo(this.current); }
             },
             next() {
                 if (this.current < this.total - 1) { this.current++; this.scrollTo(this.current); }
             },
             goTo(i) { this.current = i; this.scrollTo(i); },
             scrollTo(i) {
                 const track = this.$refs.track;
                 const card  = track.querySelectorAll('[data-card]')[i];
                 if (card) track.scrollTo({ left: card.offsetLeft - 24, behavior: 'smooth' });
             },
             onScroll() {
                 const track  = this.$refs.track;
                 const cards  = track.querySelectorAll('[data-card]');
                 const center = track.scrollLeft + track.clientWidth / 2;
                 let closest = 0, minDist = Infinity;
                 cards.forEach((c, i) => {
                     const dist = Math.abs(c.offsetLeft + c.offsetWidth / 2 - center);
                     if (dist < minDist) { minDist = dist; closest = i; }
                 });
                 this.current = closest;
             },
         }"
>
    {{-- Peta background utuh di belakang header & rating --}}
    <img src="{{ asset('img/peta.png') }}" alt=""
         class="absolute top-10 left-0 right-0 w-full max-w-6xl mx-auto h-[450px] object-contain object-center opacity-60 pointer-events-none select-none">

    {{-- ── HEADER ── --}}
    <div class="relative z-10 flex flex-col items-center text-center px-6 mb-0">
        <span class="text-base lg:text-lg text-primary font-semibold mb-2">{{ __('home.mereka_badge') }}</span>
        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">{{ __('home.mereka_title') }}</h2>
    </div>

    {{-- ── RATING BAR ── --}}
    <div class="relative z-10 w-full mt-8 mb-10 py-6">
        {{-- Konten rating --}}
        <div class="flex items-center justify-center gap-5 flex-wrap px-6">
            {{-- Angka 4.9 besar --}}
            <span class="text-7xl lg:text-8xl font-black text-primary leading-none select-none">4.9</span>

            {{-- Bintang + teks --}}
            <div class="flex flex-col gap-2">
                <div class="flex gap-1.5">
                    @for ($i = 0; $i < 5; $i++)
                        <img src="{{ asset('icon/star.svg') }}" alt="★" class="w-7 h-7">
                    @endfor
                </div>
                <p class="text-gray-700 font-semibold text-base">{{ __('home.mereka_rating_text') }}</p>
            </div>

            {{-- Google G logo --}}
            <img src="{{ asset('img/goggle.png') }}" alt="Google" class="w-16 h-16">
        </div>
    </div>

    {{-- ── SLIDER CARDS ── --}}
    <div class="relative">
        {{-- Fade edges --}}
        <div class="pointer-events-none absolute left-0 top-0 bottom-0 w-12 bg-gradient-to-r from-white to-transparent z-10"></div>
        <div class="pointer-events-none absolute right-0 top-0 bottom-0 w-12 bg-gradient-to-l from-white to-transparent z-10"></div>

        {{-- Track --}}
        <div
            x-ref="track"
            @scroll="onScroll()"
            @mousedown="isDragging=true; startX=$event.pageX - $refs.track.offsetLeft; scrollLeft=$refs.track.scrollLeft"
            @mouseleave="isDragging=false"
            @mouseup="isDragging=false"
            @mousemove="if(isDragging){ const x=$event.pageX - $refs.track.offsetLeft; $refs.track.scrollLeft = scrollLeft-(x-startX); }"
            class="flex gap-5 overflow-x-auto scroll-smooth px-6 lg:px-16 pb-3 cursor-grab active:cursor-grabbing select-none"
            style="scrollbar-width: none; -ms-overflow-style: none;"
        >
            @foreach ($reviews as $i => $review)
            @php $bg = $colors[$i % count($colors)]; @endphp
            <div
                data-card
                class="w-[320px] lg:w-[380px] flex-shrink-0 bg-sky-50 rounded-2xl border border-sky-200
                       shadow-sm flex flex-col gap-3 p-6 transition-all duration-300"
            >
                {{-- Quote icon + Stars --}}
                <div class="flex items-center gap-3">
                    {{-- Kutip biru besar --}}
                    <svg class="w-9 h-9 text-sky-400 flex-shrink-0" viewBox="0 0 40 40" fill="currentColor">
                        <path d="M11 27.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5c.6 0 1.1.1 1.6.2C11.5 11.1 9.2 8.4 6 7l1.5-2.5C13.5 7.3 17.5 13 17.5 21c0 3.6-2.9 6.5-6.5 6.5zm18 0c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5c.6 0 1.1.1 1.6.2C29.5 11.1 27.2 8.4 24 7l1.5-2.5C31.5 7.3 35.5 13 35.5 21c0 3.6-2.9 6.5-6.5 6.5z"/>
                    </svg>
                    {{-- Bintang --}}
                    <div class="flex gap-0.5">
                        @php $reviewStars = $review['stars'] ?? 5; @endphp
                        @for ($s = 0; $s < 5; $s++)
                            @if ($s < $reviewStars)
                                <img src="{{ asset('icon/star.svg') }}" alt="★" class="w-4 h-4">
                            @else
                                <img src="{{ asset('icon/star.svg') }}" alt="☆" class="w-4 h-4 opacity-30 grayscale">
                            @endif
                        @endfor
                    </div>
                </div>

                {{-- Teks Review --}}
                <p class="text-gray-700 text-sm leading-relaxed flex-1">
                    {{ $review['text'] }}
                </p>

                {{-- Divider --}}
                <div class="border-t border-sky-200"></div>

                {{-- Avatar + Nama + Google --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full {{ $bg }} flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-sm font-bold">{{ $initials($review['name']) }}</span>
                        </div>
                        <div>
                            <p class="text-gray-900 text-sm font-black leading-tight">{{ $review['name'] }}</p>
                            <p class="text-gray-500 text-xs leading-tight mt-0.5">{{ $review['date'] }}</p>
                        </div>
                    </div>
                    <img src="{{ asset('img/goggle.png') }}" alt="Google" class="w-9 h-9 flex-shrink-0">
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── DOT INDICATORS ── --}}
    <div class="flex justify-center gap-2 mt-5">
        @foreach ($reviews as $i => $_)
        <button
            type="button"
            @click="goTo({{ $i }})"
            :class="current === {{ $i }} ? 'w-5 bg-primary' : 'w-2 bg-gray-300 hover:bg-gray-400'"
            class="h-2 rounded-full transition-all duration-300"
            aria-label="Review {{ $i + 1 }}"
        ></button>
        @endforeach
    </div>

  
</section>

<style>
    [x-ref="track"]::-webkit-scrollbar { display: none; }
</style>
