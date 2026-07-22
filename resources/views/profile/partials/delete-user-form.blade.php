<section>
    <header class="mb-6 pb-4 border-b border-red-100">
        <h2 class="text-lg font-bold text-red-700">Hapus Akun</h2>
        <p class="mt-1 text-sm text-stone-500">
            Setelah akun dihapus, semua data akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
        </p>
    </header>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 rounded-full border border-red-300 text-red-600 text-sm font-bold hover:bg-red-50 transition-all duration-300 active:scale-[0.98]"
    >
        Hapus Akun Saya
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-stone-800">
                Yakin ingin menghapus akun?
            </h2>

            <p class="mt-2 text-sm text-stone-500">
                Masukkan password Anda untuk mengonfirmasi penghapusan akun secara permanen.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Password"
                    class="w-full px-5 py-3.5 bg-birumuda/40 border border-sky-200/60 rounded-full text-stone-700 focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-300 transition"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="px-5 py-2.5 rounded-full border border-stone-300 text-stone-600 text-sm font-bold hover:bg-stone-50 transition"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-full bg-red-600 hover:bg-red-700 text-white text-sm font-bold transition"
                >
                    Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
