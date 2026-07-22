@props([
    'title' => 'Welcome',
    'subtitle' => 'Secure your gear and plan your next peak ascent.',
    'badge' => 'HALO, PETUALANG',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — {{ config('app.name') }}</title>
    <meta name="description" content="{{ $description ?? 'Basecamps Outdoor - Layanan Rental Alat Camping, Open Trip, dan Guide Pendakian terpercaya. Booking sekarang untuk petualangan yang tak terlupakan!' }}">
    <meta name="keywords" content="Basecamps Outdoor, Rental Alat Gunung, Open Trip, Guide Pendakian, Sewa Tenda, Pendakian Gunung, basecampsoutdoor.com">
    <meta name="author" content="Basecamps Outdoor">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title }} — {{ config('app.name') }}">
    <meta property="og:description" content="{{ $description ?? 'Basecamps Outdoor - Layanan Rental Alat Camping, Open Trip, dan Guide Pendakian terpercaya. Booking sekarang untuk petualangan yang tak terlupakan!' }}">
    <meta property="og:image" content="{{ asset('img/logo.png') }}">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title }} — {{ config('app.name') }}">
    <meta property="twitter:description" content="{{ $description ?? 'Basecamps Outdoor - Layanan Rental Alat Camping, Open Trip, dan Guide Pendakian terpercaya. Booking sekarang untuk petualangan yang tak terlupakan!' }}">
    <meta property="twitter:image" content="{{ asset('img/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased">
    <div class="min-h-screen flex flex-col lg:flex-row">

        {{-- Kiri: Visual Branding --}}
        <div class="relative hidden lg:flex lg:w-1/2 min-h-screen">
            <img
                src="{{ asset('img/loginimg.png') }}"
                alt="Mountaineering"
                class="absolute inset-0 w-full h-full object-cover object-center"
            />
            <div class="relative z-10 flex flex-col justify-end p-12 xl:p-16 w-full">
                <span class="text-white/70 text-xs font-medium font-['JetBrains_Mono'] uppercase tracking-[0.25em] mb-4">
                    Mountaineering
                </span>
                <h2 class="text-white text-4xl xl:text-5xl font-bold leading-tight max-w-md">
                    Elevate your wilderness journey.
                </h2>
                <div class="w-16 h-px bg-white/40 my-6"></div>
                <p class="text-white/80 text-lg max-w-sm">
                    The summit is just the beginning.
                </p>
            </div>
        </div>

        {{-- Kanan: Form --}}
        <div class="flex-1 flex flex-col min-h-screen bg-white">
            {{-- Tombol Back ke Beranda (Khusus Mobile) --}}
            <div class="lg:hidden p-6 pb-0 max-w-xl mx-auto w-full">
                <a href="/" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-50 border border-sky-200 hover:bg-sky-100 text-primary text-xs font-bold tracking-wide transition active:scale-95">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                     {{ __('nav.home') }}
                </a>
            </div>

            <div class="flex-1 flex flex-col justify-center px-6 sm:px-12 lg:px-16 xl:px-24 py-12 max-w-xl mx-auto w-full">

                {{-- Header --}}
                <div class="mb-10">
                    <span class="text-stone-500 text-xs font-medium font-['JetBrains_Mono'] uppercase tracking-[0.2em]">
                        {{ $badge }}
                    </span>
                    <h1 class="text-primary text-4xl sm:text-5xl font-bold mt-2 leading-tight">
                        {{ $title }}
                    </h1>
                    <p class="text-stone-500 text-sm mt-3 leading-relaxed">
                        {{ $subtitle }}
                    </p>
                </div>

                {{ $slot }}

            </div>

            <footer class="px-6 sm:px-12 lg:px-16 xl:px-24 pb-8 text-center lg:text-left max-w-xl mx-auto w-full">
                <p class="text-stone-400 text-[11px] font-['JetBrains_Mono'] tracking-wide">
                    &copy; {{ date('Y') }} Basecamp Outdoor Mountaineering. All rights reserved.
                </p>
            </footer>
        </div>
    </div>
</body>
</html>
