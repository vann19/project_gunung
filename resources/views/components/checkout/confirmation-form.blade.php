@php
    $personIcon   = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>';
    $mountainIcon = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20L9 9l4 6 2-3 6 8H3z"/></svg>';
    $cardIcon     = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M3 10h18"/></svg>';
    $shieldIcon   = '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.5 12l1.8 1.8L15 10"/></svg>';
@endphp

<div class="w-full px-6 lg:px-12 pb-20">
    <div class="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">

        {{-- ============ KIRI (3/5) ============ --}}
        <div class="lg:col-span-3 flex flex-col gap-6">

            {{-- Data Diri & Anggota --}}
            <div class="card p-6" x-data="{ jumlah: 2 }">
                <div class="flex items-center gap-2 mb-6">
                    {!! $personIcon !!}
                    <h2 class="text-xl font-bold text-gray-900">Data Diri & Anggota</h2>
                </div>

                <div class="flex flex-col gap-5">
                    <div>
                        <label for="penanggung_jawab" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Nama Lengkap Penanggung Jawab</label>
                        <input type="text" id="penanggung_jawab" name="penanggung_jawab" placeholder="Contoh: Budi Santoso" class="input" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Jumlah Peserta</label>
                            <div class="flex items-center justify-between border border-gray-200 rounded-lg px-2 py-1">
                                <button type="button" @click="jumlah = Math.max(1, jumlah - 1)" class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-primary text-xl font-bold">&minus;</button>
                                <input type="number" name="jumlah_peserta" x-model="jumlah" class="w-12 text-center font-bold text-gray-900 border-0 focus:ring-0" readonly />
                                <button type="button" @click="jumlah++" class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-primary text-xl font-bold">+</button>
                            </div>
                        </div>
                        <div>
                            <label for="anggota_lain" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Daftar Nama Anggota Lain</label>
                            <textarea id="anggota_lain" name="anggota_lain" rows="2" placeholder="Masukkan nama anggota lain (pisahkan dengan koma)" class="input resize-none"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Perjalanan --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-6">
                    {!! $mountainIcon !!}
                    <h2 class="text-xl font-bold text-gray-900">Ringkasan Perjalanan</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-5">
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Destinasi</span>
                        <span class="text-gray-900 font-semibold">Gunung Rinjani, Lombok</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Tanggal</span>
                        <span class="text-gray-900 font-semibold">12 - 16 Agustus 2026</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Durasi</span>
                        <span class="text-gray-900 font-semibold">5 Hari 4 Malam</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Peserta</span>
                        <span class="text-gray-900 font-semibold">2 Orang (Dewasa)</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Meeting Point</span>
                        <span class="text-gray-900 font-semibold">Bandara LOP Praya</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Status</span>
                        <span class="inline-block px-3 py-1 bg-secondary-400 rounded-full text-surface-dark text-xs font-bold">Menunggu Pembayaran</span>
                    </div>
                </div>
            </div>

            {{-- Instruksi Pembayaran --}}
            <div class="card p-6"
                 x-data="{
                    remaining: 86399,
                    copied: false,
                    get formatted() {
                        const h = String(Math.floor(this.remaining / 3600)).padStart(2, '0');
                        const m = String(Math.floor((this.remaining % 3600) / 60)).padStart(2, '0');
                        const s = String(this.remaining % 60).padStart(2, '0');
                        return `${h}:${m}:${s}`;
                    }
                 }"
                 x-init="setInterval(() => { if (remaining > 0) remaining--; }, 1000)">

                <div class="flex items-center gap-2 mb-6">
                    {!! $cardIcon !!}
                    <h2 class="text-xl font-bold text-gray-900">Instruksi Pembayaran</h2>
                </div>

                {{-- Countdown Info --}}
                <div class="flex items-start gap-3 bg-gray-100 rounded-xl p-4 mb-5">
                    <svg class="w-5 h-5 text-gray-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-4m0-4h.01"/>
                    </svg>
                    <p class="text-gray-600 text-sm leading-6">
                        Selesaikan pembayaran dalam waktu <span class="font-bold text-gray-900" x-text="formatted"></span> untuk menjamin ketersediaan kuota grup.
                    </p>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <button type="button" class="flex items-center gap-3 border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors text-left">
                        <span class="px-2 py-1 bg-gray-100 rounded text-xs font-bold text-gray-600">BCA</span>
                        <span class="flex-1">
                            <span class="block font-bold text-gray-900 text-sm">Virtual Account</span>
                            <span class="block text-gray-400 text-xs">Otomatis Terverifikasi</span>
                        </span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <button type="button" class="flex items-center gap-3 border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors text-left">
                        <span class="px-2 py-1 bg-gray-100 rounded text-xs font-bold text-gray-600">MDR</span>
                        <span class="flex-1">
                            <span class="block font-bold text-gray-900 text-sm">Mandiri Transfer</span>
                            <span class="block text-gray-400 text-xs">Verifikasi Manual</span>
                        </span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                {{-- Nomor Rekening --}}
                <div class="border border-dashed border-primary/40 bg-primary/5 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <span class="block text-primary/70 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Nomor Rekening Tujuan</span>
                        <span class="block text-primary text-xl font-bold tracking-wide">8830 0921 1120 445</span>
                    </div>
                    <button type="button"
                            @click="navigator.clipboard.writeText('8830 0921 1120 445'); copied = true; setTimeout(() => copied = false, 1500)"
                            class="flex items-center gap-1.5 text-primary text-sm font-bold hover:text-primary/80 transition-colors flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="9" y="9" width="11" height="11" rx="2" stroke-width="2"/><path stroke-width="2" d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                        <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                    </button>
                </div>
            </div>
        </div>

        {{-- ============ KANAN (2/5) ============ --}}
        <div class="lg:col-span-2 flex flex-col gap-6">

            {{-- Rincian Biaya --}}
            <div class="card p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-5">Rincian Biaya</h2>

                <div class="flex flex-col gap-3 mb-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Paket Rinjani (2 Peserta)</span>
                        <span class="text-gray-900 font-medium">Rp 7.000.000</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Sewa Peralatan (Full Set)</span>
                        <span class="text-gray-900 font-medium">Rp 450.000</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Biaya Administrasi</span>
                        <span class="text-gray-900 font-medium">Rp 25.000</span>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-gray-100 mb-6">
                    <span class="font-bold text-gray-900">Total Bayar</span>
                    <span class="text-primary text-2xl font-bold">Rp 7.475.000</span>
                </div>

                <button type="button" class="btn-primary w-full justify-center py-3.5 text-base !bg-secondary-400 hover:!bg-secondary-500 !text-surface-dark">
                    Konfirmasi Pembayaran
                </button>

                <p class="text-center text-gray-400 text-xs mt-3">
                    Dengan melanjutkan, Anda menyetujui <a href="#" class="underline hover:text-primary">Syarat & Ketentuan</a> kami.
                </p>
            </div>

            {{-- Aman & Terpercaya --}}
            <div class="bg-primary rounded-2xl p-6 flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    {!! $shieldIcon !!}
                    <h3 class="text-white font-bold">Aman & Terpercaya</h3>
                </div>
                <p class="text-white/80 text-sm leading-6">
                    Pembayaran Anda dilindungi oleh enkripsi 256-bit dan jaminan pengembalian dana sesuai kebijakan pembatalan.
                </p>
            </div>
        </div>

    </div>
</div>