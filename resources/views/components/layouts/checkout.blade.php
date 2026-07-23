<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="description" content="{{ $description ?? 'Basecamps Outdoor - Layanan Rental Alat Camping, Open Trip, dan Guide Pendakian terpercaya. Booking sekarang untuk petualangan yang tak terlupakan!' }}">
    <meta name="keywords" content="Basecamps Outdoor, Rental Alat Gunung, Open Trip, Guide Pendakian, Sewa Tenda, Pendakian Gunung, basecampsoutdoor.com">
    <meta name="author" content="Basecamps Outdoor">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $description ?? 'Basecamps Outdoor - Layanan Rental Alat Camping, Open Trip, dan Guide Pendakian terpercaya. Booking sekarang untuk petualangan yang tak terlupakan!' }}">
    <meta property="og:image" content="{{ asset('img/logo.png') }}">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title ?? config('app.name') }}">
    <meta property="twitter:description" content="{{ $description ?? 'Basecamps Outdoor - Layanan Rental Alat Camping, Open Trip, dan Guide Pendakian terpercaya. Booking sekarang untuk petualangan yang tak terlupakan!' }}">
    <meta property="twitter:image" content="{{ asset('img/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full antialiased bg-surface-soft text-gray-900">

    {{-- Navbar Utama --}}
    <x-navbar />

    {{-- Main Layout Container --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer tetap sama dengan halaman lain --}}
    <x-footer />

    @stack('scripts')
</body>
</html>