<x-layouts.auth
    title="Reset Password"
    subtitle="Masukkan email Anda dan kami akan mengirimkan kode OTP untuk reset password."
    badge="LUPA PASSWORD"
>
    @if (session('status') === 'otp-sent')
        <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700">
            Jika email terdaftar, kode OTP telah dikirim. Periksa inbox Anda.
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="flex items-center gap-2 text-[11px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest text-stone-600 mb-2">
                <svg class="w-4 h-4 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Email
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                placeholder="nama@email.com"
                class="w-full px-5 py-3.5 bg-birumuda/40 border border-sky-200/60 rounded-full text-stone-700 placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/40 transition"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm" />
        </div>

        <button
            type="submit"
            class="w-full py-4 bg-linear-to-b from-kuning to-secondary-600 hover:from-kuning/90 hover:to-secondary-600/90 rounded-full text-zinc-800 font-bold text-base flex items-center justify-center gap-2 transition-all duration-300 shadow-md hover:shadow-lg active:scale-[0.98]"
        >
            Kirim Kode OTP
        </button>

        <a
            href="{{ route('login') }}"
            class="w-full py-4 rounded-full border border-stone-300 hover:border-stone-400 hover:bg-stone-50 text-stone-700 font-bold text-base flex items-center justify-center transition-all duration-300"
        >
            Kembali ke Login
        </a>
    </form>
</x-layouts.auth>
