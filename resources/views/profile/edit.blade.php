<x-app-layout>
    <x-slot name="header">
        Pengaturan Akun & Profil
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Header Profil Card --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="w-20 h-20 shrink-0 rounded-2xl bg-linear-to-br from-primary to-sky-600 flex items-center justify-center shadow-md shadow-primary/20">
                <span class="text-3xl font-bold text-white font-['JetBrains_Mono']">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>
            <div class="text-center sm:text-left flex-1 min-w-0">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest text-primary bg-primary/10 px-2.5 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                    Administrator Akun
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 mt-2 tracking-tight truncate">{{ $user->name }}</h1>
                <p class="text-slate-500 text-sm mt-1 truncate">{{ $user->email }}</p>
                @if ($user->phone)
                    <p class="inline-flex items-center gap-1.5 text-slate-500 text-sm mt-2">
                        <svg class="w-4 h-4 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ $user->phone }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Informasi Profil --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Ubah Password --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        {{-- Hapus Akun --}}
        <div class="bg-white rounded-2xl border border-red-200/80 shadow-xs p-6 sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</x-app-layout>
