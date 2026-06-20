<div class="lg:col-span-2 flex flex-col gap-6">

    {{-- Ringkasan Biaya --}}
    <div class="card p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-5">Ringkasan Biaya</h2>

        <div class="flex flex-col gap-3 mb-4">
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600">Layanan Pemandu (5 Hari)</span>
                <span class="text-gray-900 font-medium">Rp 4.500.000</span>
            </div>
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600">Logistik & Izin Masuk</span>
                <span class="text-gray-900 font-medium">Rp 1.250.000</span>
            </div>
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600">Asuransi Pendakian</span>
                <span class="text-gray-900 font-medium">Rp 250.000</span>
            </div>
        </div>

        <div class="flex justify-between items-center pt-4 border-t border-gray-100 mb-6">
            <span class="font-bold text-gray-900">Total Pembayaran</span>
            <span class="text-primary text-2xl font-bold">Rp 6.000.000</span>
        </div>

        <button type="button" class="btn-primary w-full justify-center py-3.5 text-base">
            Selesaikan Pembayaran
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>

        <p class="text-center text-gray-400 text-xs mt-3">Pembayaran aman melalui enkripsi 256-bit.</p>
    </div>

    {{-- Kebijakan Pembatalan --}}
    <div class="bg-gray-100 rounded-2xl p-6 flex items-start gap-3">
        <svg class="w-5 h-5 text-gray-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="9" stroke-width="2"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-4m0-4h.01"/>
        </svg>
        <div>
            <h3 class="font-bold text-gray-900 mb-1">Kebijakan Pembatalan</h3>
            <p class="text-gray-500 text-sm leading-6">
                Refund 100% untuk pembatalan minimal 7 hari sebelum keberangkatan. Biaya administrasi Rp 50.000 berlaku.
            </p>
        </div>
    </div>
</div>