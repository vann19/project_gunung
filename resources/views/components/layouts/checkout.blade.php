<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full antialiased bg-surface-soft text-gray-900">

    {{-- Navbar khusus alur checkout (lebih minim, fokus ke pembayaran) --}}
    <x-checkout.checkout-navbar :active="$navActive ?? 'trip'" />

    {{-- Main Layout Container --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer tetap sama dengan halaman lain --}}
    <x-footer />

    @stack('scripts')
</body>
</html>