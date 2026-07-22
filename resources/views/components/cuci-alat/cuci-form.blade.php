@props(['packages' => null])
@php
    $packages = $packages ?? \App\Models\CuciAlat::latest()->get();
@endphp
<div id="detail-barang" class="w-full bg-white py-16 lg:py-20 px-6 scroll-mt-24">
    <form action="/service/cuci-alat" method="POST" class="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-5 gap-12"
        x-data="{
            paket: '{{ $packages->first()?->id ?? '' }}',
            items: [{ jenis_alat: '', jumlah: 1, catatan: '' }],
            addItem() {
                this.items.push({ jenis_alat: '', jumlah: 1, catatan: '' });
            },
            removeItem(index) {
                if (this.items.length > 1) this.items.splice(index, 1);
            }
        }">
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

                {{-- Daftar Barang --}}
                <div class="flex flex-col gap-4">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex flex-col gap-4 p-4 border border-gray-200 rounded-xl relative">

                            {{-- Label nomor barang + tombol hapus --}}
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-700" x-text="'Barang #' + (index + 1)"></span>
                                <button
                                    type="button"
                                    x-show="items.length > 1"
                                    @click="removeItem(index)"
                                    class="flex items-center gap-1 text-xs text-red-500 hover:text-red-700 transition-colors cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>

                            {{-- Jenis Alat & Jumlah --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Alat</label>
                                    <div class="relative">
                                        <select :name="'items[' + index + '][jenis_alat]'" x-model="item.jenis_alat" class="input appearance-none pr-10">
                                            <option value="">Pilih Alat</option>
                                            <option value="tenda">Tenda</option>
                                            <option value="carrier">Carrier / Tas</option>
                                            <option value="sleeping_bag">Sleeping Bag</option>
                                            <option value="jaket">Jaket Gore-Tex</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                        <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                                    <input type="number" :name="'items[' + index + '][jumlah]'" x-model="item.jumlah" min="1" class="input" />
                                </div>
                            </div>

                            {{-- Catatan --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Khusus (Noda/Kerusakan)</label>
                                <textarea :name="'items[' + index + '][catatan]'" x-model="item.catatan" rows="3"
                                    placeholder="Contoh: Ada noda oli di bagian bawah tenda atau jahitan lepas di bagian bahu jaket..."
                                    class="input resize-none"></textarea>
                            </div>

                        </div>
                    </template>
                </div>

                {{-- Tombol Tambah Barang --}}
                <button type="button" @click="addItem()"
                    class="flex items-center justify-center gap-2 w-full py-3 border-2 border-dashed border-gray-300 rounded-xl text-sm font-medium text-gray-500 hover:border-primary hover:text-primary transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Barang
                </button>

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
                @foreach ($packages as $pkg)
                    @php
                        $pkgId = $pkg['id'];
                        $isRecommended = $pkg['is_recommended'] ?? false;
                    @endphp
                    <label class="relative block cursor-pointer">
                        <input type="radio" name="paket" value="{{ $pkgId }}" x-model="paket" class="sr-only" />
                        <div class="card p-5" :class="paket == '{{ $pkgId }}' ? 'border-primary ring-1 ring-primary' : 'border-gray-100'">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ $pkg['name'] }}</h3>
                                @if($isRecommended)
                                    <span class="px-2 py-1 bg-secondary-400 rounded-sm text-surface-dark text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-wide">Rekomendasi</span>
                                @else
                                    <span class="text-gray-400 text-xs font-medium font-['JetBrains_Mono'] uppercase tracking-wide">{{ $pkg['duration'] }}</span>
                                @endif
                            </div>
                            <p class="text-gray-500 text-sm leading-6 mb-4">{{ $pkg['description'] }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-primary font-bold">{{ $pkg['price'] }} <span class="text-gray-400 font-normal text-sm">{{ $pkg['unit'] }}</span></span>
                                <span class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0" :class="paket == '{{ $pkgId }}' ? 'border-primary' : 'border-gray-300'">
                                    <span class="w-2.5 h-2.5 rounded-full bg-primary" x-show="paket == '{{ $pkgId }}'"></span>
                                </span>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-lg font-medium text-base text-white transition-all duration-200 cursor-pointer active:scale-95 shadow-sm" style="background-color: #005E97;">
                Kirim Form Cuci
            </button>
            <p class="text-center text-gray-400 text-xs mt-3">Estimasi biaya akan dikonfirmasi via WhatsApp.</p>
        </div>

    </form>
</div>