<section>
    <header class="mb-6 pb-4 border-b border-stone-100">
        <h2 class="text-lg font-bold text-stone-800">Ubah Password</h2>
        <p class="mt-1 text-sm text-stone-500">
            Gunakan password yang kuat dan unik untuk menjaga keamanan akun.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="flex items-center gap-2 text-[11px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest text-stone-600 mb-2">
                Password Saat Ini
            </label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="w-full px-5 py-3.5 bg-birumuda/40 border border-sky-200/60 rounded-full text-stone-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/40 transition"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="flex items-center gap-2 text-[11px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest text-stone-600 mb-2">
                Password Baru
            </label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="w-full px-5 py-3.5 bg-birumuda/40 border border-sky-200/60 rounded-full text-stone-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/40 transition"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="flex items-center gap-2 text-[11px] font-medium font-['JetBrains_Mono'] uppercase tracking-widest text-stone-600 mb-2">
                Konfirmasi Password Baru
            </label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="w-full px-5 py-3.5 bg-birumuda/40 border border-sky-200/60 rounded-full text-stone-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/40 transition"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button
                type="submit"
                class="px-8 py-3 bg-linear-to-b from-blue-300 to-sky-600 hover:from-blue-400 hover:to-sky-700 rounded-full text-white text-sm font-bold transition-all duration-300 hover:scale-105 active:scale-[0.98]"
            >
                Update Password
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm text-green-600 font-medium"
                >
                    Password berhasil diperbarui.
                </p>
            @endif
        </div>
    </form>
</section>
