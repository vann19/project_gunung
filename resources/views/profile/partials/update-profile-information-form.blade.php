<section>
    <header class="mb-6 pb-4 border-b border-stone-100">
        <h2 class="text-lg font-bold text-stone-800">Informasi Profil</h2>
        <p class="mt-1 text-sm text-stone-500">
            Perbarui nama, email, dan nomor telepon akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        {{-- Nama --}}
        <div>
            <label for="name" class="flex items-center gap-2 text-[11px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest text-stone-600 mb-2">
                <svg class="w-4 h-4 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Nama Pengguna
            </label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
                class="w-full px-5 py-3.5 bg-birumuda/40 border border-sky-200/60 rounded-full text-stone-700 placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/40 transition"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Nomor Telepon --}}
        <div>
            <label for="phone" class="flex items-center gap-2 text-[11px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest text-stone-600 mb-2">
                <svg class="w-4 h-4 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Nomor Telepon
            </label>
            <input
                id="phone"
                name="phone"
                type="tel"
                value="{{ old('phone', $user->phone) }}"
                required
                autocomplete="tel"
                placeholder="+62 812-3456-7890"
                class="w-full px-5 py-3.5 bg-birumuda/40 border border-sky-200/60 rounded-full text-stone-700 placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/40 transition"
            />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="flex items-center gap-2 text-[11px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest text-stone-600 mb-2">
                <svg class="w-4 h-4 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Email
            </label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
                class="w-full px-5 py-3.5 bg-birumuda/40 border border-sky-200/60 rounded-full text-stone-700 placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/40 transition"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-4 bg-amber-50 border border-amber-200/60 rounded-xl">
                    <p class="text-sm text-amber-800">
                        Email Anda belum diverifikasi.
                        <button form="send-verification" class="underline font-medium hover:text-amber-900">
                            Kirim ulang email verifikasi
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600">
                            Link verifikasi baru telah dikirim ke email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button
                type="submit"
                class="px-8 py-3 bg-linear-to-b from-blue-300 to-sky-600 hover:from-blue-400 hover:to-sky-700 rounded-full text-white text-sm font-bold transition-all duration-300 hover:scale-105 active:scale-[0.98]"
            >
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm text-green-600 font-medium"
                >
                    Berhasil disimpan.
                </p>
            @endif
        </div>
    </form>
</section>
