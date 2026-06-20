<div id="detail-barang" class="w-full bg-white py-16 lg:py-20 px-6 scroll-mt-24">
    <form action="#" method="POST" class="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-5 gap-12" x-data="{ paket: 'reproofing' }">
        @csrf

        {{-- ============ KIRI: Form Detail Barang ============ --}}
        <div class="lg:col-span-3 flex flex-col gap-12">

            <div class="flex flex-col gap-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Detail Barang</h2>
                    <p class="text-gray-500 text-sm mt-1">Informasikan detail alat yang ingin Anda cuci.</p>
                </div>

                {{-- Atas Nama --}}
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Atas Nama</label>
                    <input type="text" name="nama" id="nama" placeholder="Nama lengkap Anda" class="input" />
                </div>

                {{-- Jenis Alat & Jumlah --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_alat" class="block text-sm font-medium text-gray-700 mb-2">Jenis Alat</label>
                        <div class="relative">
                            <select name="jenis_alat" id="jenis_alat" class="input appearance-none pr-10">
                                <option value="">Pilih Alat</option>
                                <option value="tenda">Tenda</option>
                                <option value="carrier">Carrier / Tas</option>
                                <option value="sleeping_bag">Sleeping Bag</option>
                                <option value="jaket">Jaket Gore-Tex</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" min="1" value="1" class="input" />
                    </div>
                </div>

                {{-- Catatan Khusus --}}
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Khusus (Noda/Kerusakan)</label>
                    <textarea name="catatan" id="catatan" rows="4" placeholder="Contoh: Ada noda oli di bagian bawah tenda atau jahitan lepas di bagian bahu jaket..." class="input resize-none"></textarea>
                </div>

                {{-- Info Box --}}
                <div class="flex items-start gap-3 bg-gray-100 rounded-xl p-4">
                    <svg class="w-5 h-5 text-gray-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-4m0-4h.01"/>
                    </svg>
                    <p class="text-gray-600 text-sm leading-6">
                        Petugas kami akan melakukan inspeksi fisik saat barang diterima untuk memastikan kondisi awal gear Anda.
                    </p>
                </div>
            </div>

            {{-- Mengapa Cuci di Sini --}}
            <div class="flex flex-col gap-6 pt-6 border-t border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Mengapa Cuci di Sini?</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    {{-- Ultrasonic Cleaning --}}
                    <div class="flex flex-col gap-3">
                        <div class="w-11 h-11 bg-primary/8 rounded-xl flex items-center justify-center">
                            <img src="{{ asset('icon/ultrasonic.svg') }}" alt="Ultrasonic Cleaning" class="w-5 h-5" />
                        </div>
                        <h3 class="font-bold text-gray-900">Ultrasonic Cleaning</h3>
                        <p class="text-gray-500 text-sm leading-6">Pembersihan hingga serat terdalam tanpa merusak membran technical.</p>
                    </div>

                    {{-- Technical Detergent --}}
                    <div class="flex flex-col gap-3">
                        <div class="w-11 h-11 bg-primary/8 rounded-xl flex items-center justify-center">
                            <img src="{{ asset('icon/technical.svg') }}" alt="Technical Detergent" class="w-5 h-5" />
                        </div>
                        <h3 class="font-bold text-gray-900">Technical Detergent</h3>
                        <p class="text-gray-500 text-sm leading-6">Deterjen pH netral khusus outdoor gear yang ramah lingkungan.</p>
                    </div>

                    {{-- Controlled Drying --}}
                    <div class="flex flex-col gap-3">
                        <div class="w-11 h-11 bg-primary/8 rounded-xl flex items-center justify-center">
                            <img src="{{ asset('icon/cotrolled.svg') }}" alt="Controlled Drying" class="w-5 h-5" />
                        </div>
                        <h3 class="font-bold text-gray-900">Controlled Drying</h3>
                        <p class="text-gray-500 text-sm leading-6">Pengeringan suhu rendah terkontrol untuk menjaga lofting Down.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ KANAN: Pilih Paket ============ --}}
        <div class="lg:col-span-2">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Pilih Paket</h2>

            <div class="flex flex-col gap-4 mb-6">

                {{-- Deep Clean --}}
                <label class="relative block cursor-pointer">
                    <input type="radio" name="paket" value="deep_clean" x-model="paket" class="sr-only" />
                    <div class="card p-5" :class="paket === 'deep_clean' ? 'border-primary ring-1 ring-primary' : 'border-gray-100'">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-gray-900">Deep Clean</h3>
                            <span class="text-gray-400 text-xs font-medium font-['JetBrains_Mono'] uppercase tracking-wide">3-4 Hari</span>
                        </div>
                        <p class="text-gray-500 text-sm leading-6 mb-4">Pembersihan menyeluruh, sanitasi anti-bakteri, dan penghilangan bau.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary font-bold">Rp 75.000 <span class="text-gray-400 font-normal text-sm">/ item</span></span>
                            <span class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0" :class="paket === 'deep_clean' ? 'border-primary' : 'border-gray-300'">
                                <span class="w-2.5 h-2.5 rounded-full bg-primary" x-show="paket === 'deep_clean'"></span>
                            </span>
                        </div>
                    </div>
                </label>

                {{-- Reproofing DWR --}}
                <label class="relative block cursor-pointer">
                    <input type="radio" name="paket" value="reproofing" x-model="paket" class="sr-only" />
                    <div class="card p-5" :class="paket === 'reproofing' ? 'border-primary ring-1 ring-primary' : 'border-gray-100'">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-gray-900">Reproofing DWR</h3>
                            <span class="px-2 py-1 bg-secondary-400 rounded-sm text-surface-dark text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-wide">Rekomendasi</span>
                        </div>
                        <p class="text-gray-500 text-sm leading-6 mb-4">Deep Clean + Pelapisan ulang water repellent (DWR) berkualitas tinggi.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary font-bold">Rp 125.000 <span class="text-gray-400 font-normal text-sm">/ item</span></span>
                            <span class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0" :class="paket === 'reproofing' ? 'border-primary' : 'border-gray-300'">
                                <span class="w-2.5 h-2.5 rounded-full bg-primary" x-show="paket === 'reproofing'"></span>
                            </span>
                        </div>
                    </div>
                </label>

                {{-- Express --}}
                <label class="relative block cursor-pointer">
                    <input type="radio" name="paket" value="express" x-model="paket" class="sr-only" />
                    <div class="card p-5" :class="paket === 'express' ? 'border-primary ring-1 ring-primary' : 'border-gray-100'">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-gray-900">Express</h3>
                            <span class="text-gray-400 text-xs font-medium font-['JetBrains_Mono'] uppercase tracking-wide">24 Jam</span>
                        </div>
                        <p class="text-gray-500 text-sm leading-6 mb-4">Layanan prioritas untuk kebutuhan mendadak. Selesai dalam 1 hari.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary font-bold">Rp 150.000 <span class="text-gray-400 font-normal text-sm">/ item</span></span>
                            <span class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0" :class="paket === 'express' ? 'border-primary' : 'border-gray-300'">
                                <span class="w-2.5 h-2.5 rounded-full bg-primary" x-show="paket === 'express'"></span>
                            </span>
                        </div>
                    </div>
                </label>
            </div>

            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-lg font-medium text-base text-white transition-all duration-200 cursor-pointer active:scale-95 shadow-sm" style="background-color: #005E97;">
                Kirim Form Cuci
            </button>
            <p class="text-center text-gray-400 text-xs mt-3">Estimasi biaya akan dikonfirmasi via WhatsApp.</p>
        </div>

    </form>
</div>