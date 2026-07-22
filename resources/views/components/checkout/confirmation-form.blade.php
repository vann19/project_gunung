@props(['selectedTrip' => null, 'allTrips' => []])
@php
    $personIcon   = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>';
    $mountainIcon = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20L9 9l4 6 2-3 6 8H3z"/></svg>';
    $cardIcon     = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M3 10h18"/></svg>';
    $shieldIcon   = '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.5 12l1.8 1.8L15 10"/></svg>';

    $tripsMap = collect($allTrips)->mapWithKeys(function ($t) {
        $priceStr = preg_replace('/[^0-9]/', '', $t->price);
        $priceNum = intval($priceStr);
        if (stripos($t->price, 'k') !== false && $priceNum < 100000) {
            $priceNum *= 1000;
        }
        return [$t->id => [
            'title' => $t->title,
            'price' => $t->price,
            'priceNum' => $priceNum,
            'slot' => $t->slot ?? 10
        ]];
    });
@endphp

<div class="w-full px-6 lg:px-12 pb-20"
     x-data="{
        tripId: '{{ $selectedTrip ? $selectedTrip->id : (collect($allTrips)->first()->id ?? '') }}',
        tripsData: @js($tripsMap),
        anggota: [],
        addAnggota() {
            this.anggota.push({ nama: '', nik: '' });
        },
        removeAnggota(idx) {
            this.anggota.splice(idx, 1);
        },
        get currentTrip() {
            return this.tripsData[this.tripId] || { title: 'Paket Open Trip', price: 'Rp 0', priceNum: 0, slot: 10 };
        },
        get totalPeserta() {
            return 1 + this.anggota.length;
        },
        get totalTagihan() {
            return this.currentTrip.priceNum * this.totalPeserta;
        },
        formatRupiah(num) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
        }
     }">
    <form method="POST" action="{{ route('opentrip.process') }}" enctype="multipart/form-data" class="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
        @csrf

        {{-- ============ KIRI (3/5) ============ --}}
        <div class="lg:col-span-3 flex flex-col gap-6">

            @if ($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                    <p class="font-bold mb-1">Harap periksa kembali form pengisian:</p>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Pilih Paket Trip --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-4">
                    {!! $mountainIcon !!}
                    <h2 class="text-xl font-bold text-gray-900">Pilihan Paket Open Trip</h2>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Pilih Destinasi / Paket</label>
                    <select name="trip_id" x-model="tripId" required class="input font-bold text-gray-900">
                        @foreach ($allTrips as $t)
                            <option value="{{ $t->id }}" {{ ($selectedTrip && $selectedTrip->id == $t->id) ? 'selected' : '' }}>
                                {{ $t->title }} — {{ $t->price }} / Orang
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Data Diri Penanggung Jawab --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-6">
                    {!! $personIcon !!}
                    <h2 class="text-xl font-bold text-gray-900">Data Diri Penanggung Jawab</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label for="penanggung_jawab" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Nama Lengkap Ketua / Penanggung Jawab <span class="text-rose-500">*</span></label>
                        <input type="text" id="penanggung_jawab" name="penanggung_jawab" required placeholder="Contoh: Budi Santoso" class="input" value="{{ old('penanggung_jawab') }}" />
                    </div>

                    <div>
                        <label for="whatsapp" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                        <input type="tel" id="whatsapp" name="whatsapp" required placeholder="081234567890" class="input" value="{{ old('whatsapp') }}" />
                    </div>

                    {{-- No. Identitas removed for Open Trip per request --}}

                    <div>
                        <label for="jaminan_type" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Jenis Jaminan Identitas <span class="text-rose-500">*</span></label>
                        <select id="jaminan_type" name="jaminan_type" required class="input">
                            <option value="">-- Pilih Jaminan --</option>
                            <option value="KTP">KTP</option>
                            <option value="BPJS">BPJS</option>
                            <option value="SIM">SIM</option>
                            <option value="PASPOR">Paspor</option>
                        </select>
                        <p class="text-xs text-gray-400 mt-1">Pilih jenis identitas yang akan menjadi jaminan.</p>
                    </div>

                    <div>
                        <label for="has_surat_sehat" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Apakah Anda sudah memiliki Surat Sehat? <span class="text-rose-500">*</span></label>
                        <select id="has_surat_sehat" name="has_surat_sehat" required class="input">
                            <option value="">-- Pilih --</option>
                            <option value="Sudah">Sudah</option>
                            <option value="Belum">Belum</option>
                        </select>
                        <p class="text-xs text-gray-400 mt-1">Jika belum, Anda bisa melengkapi surat setelah pendaftaran.</p>
                    </div>
                </div>
            </div>

            {{-- Dynamic Tambah Anggota --}}
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Daftar Anggota Tambahan</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Tambahkan data anggota lain yang ikut dalam rombongan Anda.</p>
                    </div>
                    <button type="button" @click="addAnggota()"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-primary/10 hover:bg-primary/20 text-primary font-bold text-xs transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>+ Tambah Anggota</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-if="anggota.length === 0">
                        <div class="py-6 text-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <p class="text-sm text-gray-500">Belum ada anggota tambahan.</p>
                            <p class="text-xs text-gray-400 mt-0.5">Jika Anda mendaki sendiri (1 orang), Anda tidak perlu menambah baris ini.</p>
                        </div>
                    </template>

                    <template x-for="(item, index) in anggota" :key="index">
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200/80 relative">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold text-primary uppercase font-['JetBrains_Mono']" x-text="`Anggota #${index + 2}`"></span>
                                <button type="button" @click="removeAnggota(index)" class="text-xs font-semibold text-rose-500 hover:text-rose-700 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Nama Lengkap Anggota <span class="text-rose-500">*</span></label>
                                    <input type="text" :name="`anggota[${index}][nama]`" x-model="item.nama" required placeholder="Nama anggota" class="input !py-2 !text-xs" />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">No. Identitas / NIK / HP <span class="text-rose-500">*</span></label>
                                    <input type="text" :name="`anggota[${index}][nik]`" x-model="item.nik" required placeholder="NIK atau No HP darurat" class="input !py-2 !text-xs" />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Jenis Jaminan Identitas <span class="text-rose-500">*</span></label>
                                    <select :name="`anggota[${index}][jaminan_type]`" x-model="item.jaminan_type" required class="w-full text-xs input">
                                        <option value="">-- Pilih --</option>
                                        <option value="KTP">KTP</option>
                                        <option value="BPJS">BPJS</option>
                                        <option value="SIM">SIM</option>
                                        <option value="PASPOR">Paspor</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Apakah Sudah Memiliki Surat Sehat? <span class="text-rose-500">*</span></label>
                                    <select :name="`anggota[${index}][has_surat_sehat]`" x-model="item.has_surat_sehat" required class="w-full text-xs input">
                                        <option value="">-- Pilih --</option>
                                        <option value="Sudah">Sudah</option>
                                        <option value="Belum">Belum</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Ringkasan Perjalanan --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-4">
                    {!! $mountainIcon !!}
                    <h2 class="text-xl font-bold text-gray-900">Ringkasan Ekspedisi</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-4 text-sm">
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Paket Terpilih</span>
                        <span class="text-gray-900 font-bold" x-text="currentTrip.title"></span>
                    </div>
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Total Peserta</span>
                        <span class="text-primary font-bold" x-text="totalPeserta + ' Orang'"></span>
                    </div>
                    <div>
                        <span class="block text-gray-400 text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Harga Satuan</span>
                        <span class="text-gray-900 font-bold" x-text="currentTrip.price"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ KANAN (2/5) ============ --}}
        <div class="lg:col-span-2 flex flex-col gap-6 sticky top-28">

            {{-- Rincian Biaya --}}
            <div class="card p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-5">Rincian Biaya</h2>

                <div class="flex flex-col gap-3 mb-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 truncate max-w-[180px]" x-text="currentTrip.title"></span>
                        <span class="text-gray-900 font-medium" x-text="currentTrip.price"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Jumlah Peserta</span>
                        <span class="text-gray-900 font-bold" x-text="totalPeserta + ' Orang'"></span>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-gray-100 mb-6">
                    <span class="font-bold text-gray-900">Total Tagihan</span>
                    <span class="text-primary text-2xl font-black font-['Hanken_Grotesk']" x-text="formatRupiah(totalTagihan)"></span>
                </div>

                <button type="submit" class="btn-primary w-full justify-center py-3.5 text-base !bg-secondary-400 hover:!bg-secondary-500 !text-surface-dark shadow-md">
                    Lanjutkan ke Pembayaran QRIS
                </button>

                <p class="text-center text-gray-400 text-xs mt-3">
                    Setelah klik tombol ini, Anda akan diarahkan ke halaman pembayaran QRIS & konfirmasi WhatsApp.
                </p>
            </div>

            {{-- Aman & Terpercaya --}}
            <div class="bg-primary rounded-2xl p-6 flex flex-col gap-2 shadow-md">
                <div class="flex items-center gap-2">
                    {!! $shieldIcon !!}
                    <h3 class="text-white font-bold">Jaminan Ekspedisi Resmi</h3>
                </div>
                <p class="text-white/80 text-xs leading-5">
                    Data peserta otomatis terdaftar dalam protokol keselamatan porter & guide Project Gunung.
                </p>
            </div>
        </div>

    </form>
</div>