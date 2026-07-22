<x-app-layout>
    <x-slot name="header">
        Kelola Foto QRIS Pembayaran
    </x-slot>

    <div class="space-y-8 max-w-4xl mx-auto">

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs" id="flash-message">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('flash-message').remove()" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs">
                <div class="flex items-center gap-2 font-bold text-sm mb-1">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Terjadi Kesalahan:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header Bar --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Foto Barcode QRIS Pembayaran</h1>
            <p class="text-sm text-slate-500 mt-1">
                Foto QRIS yang Anda unggah di sini akan otomatis digunakan sebagai barcode pembayaran di halaman Checkout Rental, Keranjang Rental, dan Cuci Alat.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            
            {{-- Preview QRIS Saat Ini --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col items-center text-center">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider font-['JetBrains_Mono'] mb-4 block w-full text-left">
                    Preview Foto Saat Ini
                </span>

                <div class="w-64 h-64 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-4 flex items-center justify-center relative mb-4">
                    @if ($qrisImage)
                        <img src="{{ asset($qrisImage) }}" alt="Foto QRIS Saat Ini" class="max-w-full max-h-full object-contain rounded-lg shadow-2xs">
                    @else
                        <div class="text-slate-400 flex flex-col items-center">
                            <svg class="w-12 h-12 mb-2 stroke-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            <span class="text-xs font-medium">Belum ada foto QRIS kustom.<br>Menggunakan barcode default.</span>
                        </div>
                    @endif
                </div>

                <p class="text-xs text-slate-500 max-w-xs">
                    @if ($qrisImage)
                        Status: <span class="text-emerald-600 font-bold">Aktif & Live</span> di seluruh halaman pembayaran.
                    @else
                        Status: <span class="text-amber-600 font-bold">Default Barcode</span>. Unggah foto untuk mengganti.
                    @endif
                </p>
            </div>

            {{-- Form Unggah / Ganti Foto --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider font-['JetBrains_Mono'] mb-4 block">
                    Unggah / Ganti Foto QRIS Baru
                </span>

                <form method="POST" action="{{ route('admin.qris.update') }}" enctype="multipart/form-data" class="space-y-6" x-data="{ photoName: null, photoPreview: null }">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Pilih Foto Barcode (JPG / PNG / WEBP)</label>
                        
                        {{-- Area Upload --}}
                        <div class="flex flex-col items-center justify-center w-full">
                            <label for="qris_image_input" class="flex flex-col items-center justify-center w-full h-44 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100/80 transition relative overflow-hidden">
                                
                                {{-- Preview foto yang dipilih --}}
                                <template x-if="photoPreview">
                                    <div class="absolute inset-0 flex items-center justify-center bg-white p-2">
                                        <img :src="photoPreview" class="max-h-full max-w-full object-contain rounded-lg">
                                    </div>
                                </template>

                                <template x-if="!photoPreview">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                        <div class="p-3 bg-white rounded-full shadow-xs mb-3 text-primary">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                        </div>
                                        <p class="mb-1 text-sm font-semibold text-slate-700">Klik untuk memilih foto</p>
                                        <p class="text-xs text-slate-500">atau drag & drop foto ke sini (Maks. 2MB)</p>
                                    </div>
                                </template>

                                <input id="qris_image_input" name="qris_image" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg, image/webp" required
                                       @change="
                                           const file = $event.target.files[0];
                                           if (file) {
                                               photoName = file.name;
                                               const reader = new FileReader();
                                               reader.onload = (e) => { photoPreview = e.target.result; };
                                               reader.readAsDataURL(file);
                                           }
                                       ">
                            </label>
                        </div>

                        <template x-if="photoName">
                            <p class="mt-2 text-xs text-emerald-600 font-medium flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                File dipilih: <span class="font-bold underline" x-text="photoName"></span>
                            </p>
                        </template>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <button type="submit"
                                class="w-full py-3.5 bg-primary hover:bg-primary/90 text-white rounded-xl font-bold text-sm shadow-md shadow-primary/20 transition active:scale-98 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <span>Simpan & Terapkan Foto QRIS</span>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</x-app-layout>
