<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Basecamp') }} — Admin Panel</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|jetbrains-mono:400,500,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 h-full selection:bg-primary/20 selection:text-primary" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex w-full">

        {{-- Overlay untuk Mobile Drawer --}}
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-40 lg:hidden"
             @click="sidebarOpen = false"
             style="display: none;">
        </div>

        {{-- SIDEBAR ala Shadcn UI (Bertema Primary) --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-primary text-white border-r border-white/10 flex flex-col transition-transform duration-300 ease-in-out lg:sticky lg:top-0 lg:h-screen shrink-0 shadow-2xl lg:shadow-none"
               style="align-self: flex-start;">
            
            {{-- Sidebar Header / Brand --}}
            <div class="h-16 px-6 flex items-center justify-between border-b border-white/10 bg-primary/80 backdrop-blur-md">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-md shadow-black/10 group-hover:scale-105 transition-transform p-1">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Basecamp" class="w-full h-full object-contain" />
                    </div>
                    <div>
                        <span class="font-bold text-sm text-white tracking-tight leading-none block">Admin Dashboard</span>
                    </div>
                </a>

                {{-- Close Button di Mobile --}}
                <button @click="sidebarOpen = false" class="lg:hidden text-sky-200 hover:text-white p-1 rounded-lg hover:bg-white/10 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Sidebar Navigation --}}
            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
                
                {{-- Group 1: Overview --}}
                <div>
                    <span class="px-3 text-[10px] font-semibold font-['JetBrains_Mono'] uppercase tracking-wider text-sky-200/70 mb-2 block">
                        Overview
                    </span>
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('dashboard') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('profile.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Akun Pengguna</span>
                        </a>
                    </nav>
                </div>

                {{-- Group 2: Katalog & Layanan --}}
                <div>
                    <span class="px-3 text-[10px] font-semibold font-['JetBrains_Mono'] uppercase tracking-wider text-sky-200/70 mb-2 block">
                        Manajemen Layanan (CRUD)
                    </span>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.rentals.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.rentals.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.rentals.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span>Kelola Rental Alat</span>
                        </a>

                        <a href="{{ route('admin.mountains.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.mountains.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.mountains.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="currentColor" d="M12.88 2.53c-.35-.66-1.42-.66-1.77 0l-8.99 17c-.16.31-.15.68.03.98s.51.48.86.48h18c.35 0 .68-.18.86-.48s.19-.67.03-.98zM12 5.13l3.07 5.81l-1.07.81l-1.4-1.05a.99.99 0 0 0-1.2 0L10 11.75l-1.07-.81z" />
                            </svg>
                            <span>Kelola Info Gunung</span>
                        </a>

                        <a href="{{ route('admin.rental-orders.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.rental-orders.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.rental-orders.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>Pesanan Rental</span>
                        </a>

                        <a href="{{ route('admin.open-trip-orders.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.open-trip-orders.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.open-trip-orders.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>Pesanan Open Trip</span>
                        </a>

                        <a href="{{ route('admin.hiking-guide-orders.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.hiking-guide-orders.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.hiking-guide-orders.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>Pesanan Guide</span>
                        </a>

                        <a href="{{ route('admin.open-trips.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.open-trips.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.open-trips.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            <span>Kelola Open Trip</span>
                        </a>

                        <a href="{{ route('admin.pendaki-bergabung.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.pendaki-bergabung.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.pendaki-bergabung.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Pendaki Bergabung</span>
                        </a>

                        <a href="{{ route('admin.cuci-alats.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.cuci-alats.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.cuci-alats.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            <span>Kelola Cuci Alat</span>
                        </a>

                        <a href="{{ route('admin.marketplaces.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.marketplaces.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.marketplaces.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span>Kelola Marketplace</span>
                        </a>

                        <a href="{{ route('admin.hiking-guides.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.hiking-guides.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.hiking-guides.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>Kelola Guide</span>
                        </a>

                        <a href="{{ route('admin.testimonials.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.testimonials.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.testimonials.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            <span>Kelola Testimoni</span>
                        </a>
                    </nav>
                </div>
                <div>
                    <span class="px-3 text-[10px] font-semibold font-['JetBrains_Mono'] uppercase tracking-wider text-sky-200/70 mb-2 block">
                        Akses Eksternal
                    </span>
                    <nav class="space-y-1">
                        <a href="/" target="_blank"
                           class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-sky-100/80 hover:text-white hover:bg-white/10 transition-all group">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-sky-200/80 group-hover:text-kuning transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <span>Lihat Website Publik</span>
                            </div>
                            <span class="text-[10px] font-['JetBrains_Mono'] px-1.5 py-0.5 rounded bg-white/15 text-white font-semibold">Live</span>
                        </a>
                    </nav>
                </div>

                {{-- Group 3: Navigasi Foto - QRIS --}}
                <div>
                    <span class="px-3 text-[10px] font-semibold font-['JetBrains_Mono'] uppercase tracking-wider text-sky-200/70 mb-2 block">
                        Foto Qris
                    </span>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.qris.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request()->routeIs('admin.qris.*') 
                                     ? 'bg-white text-primary font-bold shadow-md' 
                                     : 'text-sky-100/80 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.qris.*') ? 'text-primary' : 'text-sky-200/80 group-hover:text-white' }} transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            <span>Kelola Foto QRIS</span>
                        </a>
                    </nav>
                </div>

            </div>

            {{-- Sidebar Footer (User Card) --}}
            <div class="p-4 border-t border-white/10 bg-primary/90">
                <div class="flex items-center justify-between p-2 rounded-xl bg-white/10 border border-white/15">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shrink-0 text-primary font-bold text-xs font-['JetBrains_Mono']">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <p class="text-[10px] text-sky-200/80 truncate">{{ Auth::user()->email ?? '' }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                        @csrf
                        <button type="submit" title="Logout"
                                class="p-1.5 text-sky-200 hover:text-rose-300 hover:bg-white/15 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        {{-- MAIN CONTENT WRAPPER --}}
        <div class="flex-1 flex flex-col min-w-0 min-h-screen">

            {{-- TOP HEADER BAR --}}
            <header class="h-16 bg-white border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 shrink-0">
                
                {{-- Left Header: Hamburger + Title --}}
                <div class="flex items-center gap-4 min-w-0">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden p-2 -ml-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    @isset($header)
                        <div class="text-base sm:text-lg font-bold text-slate-800 truncate">
                            {{ $header }}
                        </div>
                    @else
                        <div class="text-base sm:text-lg font-bold text-slate-800">
                            Admin Dashboard
                        </div>
                    @endisset
                </div>

                {{-- Right Header: Search Placeholder + User Badge --}}
                <div class="flex items-center gap-3 sm:gap-4">
                    
                    {{-- Quick Search Ala Shadcn
                    <div class="hidden sm:flex items-center justify-between w-64 px-3 py-1.5 bg-slate-100/80 border border-slate-200/80 rounded-lg text-xs text-slate-400 select-none">
                        <span class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Cari data atau pesanan...
                        </span>
                        <kbd class="px-1.5 py-0.5 text-[10px] font-['JetBrains_Mono'] bg-white border border-slate-200 rounded text-slate-500 shadow-3xs">⌘K</kbd>
                    </div> --}}

                    {{-- Status Badge --}}
                    <div class="flex items-center gap-2 pl-2 sm:pl-3 sm:border-l sm:border-slate-200">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-semibold text-slate-600 hidden sm:inline-block">System Online</span>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 transition border border-transparent hover:border-slate-200">
                        <div class="w-7 h-7 rounded-lg bg-linear-to-br from-primary to-sky-600 flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </a>

                </div>

            </header>

            {{-- MAIN VIEWPORT --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-x-hidden">
                {{ $slot }}
            </main>

        </div>

    </div>

    @stack('scripts')

</body>
</html>
