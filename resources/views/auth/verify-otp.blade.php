<x-layouts.auth
    title="Verifikasi OTP"
    subtitle="Masukkan kode OTP 6 digit yang telah dikirim ke email Anda."
    badge="VERIFIKASI"
>
    @if (session('status') === 'otp-resent')
        <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700">
            Kode OTP baru telah dikirim ke email Anda.
        </div>
    @endif

    <div class="mb-6 p-4 rounded-xl bg-birumuda/30 border border-sky-200/60">
        <p class="text-[11px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest text-stone-500 mb-1">Email Tujuan</p>
        <p class="text-stone-700 font-semibold break-all">{{ $email }}</p>
    </div>

    <form method="POST" action="{{ route('password.verify-otp.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="otp" class="flex items-center gap-2 text-[11px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest text-stone-600 mb-2">
                <svg class="w-4 h-4 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Kode OTP
            </label>
            <input
                id="otp"
                type="text"
                name="otp"
                value="{{ old('otp') }}"
                required
                autofocus
                inputmode="numeric"
                pattern="[0-9]{6}"
                maxlength="6"
                placeholder="000000"
                class="w-full px-5 py-3.5 bg-birumuda/40 border border-sky-200/60 rounded-full text-stone-700 placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/40 transition text-center text-2xl font-bold tracking-[0.4em]"
            />
            <x-input-error :messages="$errors->get('otp')" class="mt-2 text-sm" />
            <p class="mt-2 text-xs text-stone-400">Kode berlaku selama 10 menit.</p>
        </div>

        <button
            type="submit"
            class="w-full py-4 bg-linear-to-b from-kuning to-secondary-600 hover:from-kuning/90 hover:to-secondary-600/90 rounded-full text-zinc-800 font-bold text-base flex items-center justify-center gap-2 transition-all duration-300 shadow-md hover:shadow-lg active:scale-[0.98]"
        >
            Verifikasi OTP
        </button>
    </form>

    <form method="POST" action="{{ route('password.resend-otp') }}" class="mt-4">
        @csrf
        <button
            type="submit"
            class="w-full py-3 rounded-full border border-stone-300 hover:border-stone-400 hover:bg-stone-50 text-stone-600 text-sm font-bold transition-all duration-300"
        >
            Kirim Ulang OTP
        </button>
    </form>

    <a
        href="{{ route('password.request') }}"
        class="mt-4 w-full py-4 rounded-full border border-stone-300 hover:border-stone-400 hover:bg-stone-50 text-stone-700 font-bold text-base flex items-center justify-center transition-all duration-300"
    >
        Ganti Email
    </a>
</x-layouts.auth>
