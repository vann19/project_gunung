@props(['selectedGuide' => null, 'allGuides' => []])
@php
    $calendarIcon = '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M3 10h18M8 3v4M16 3v4"/></svg>';
    $mountainIcon = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20L9 9l4 6 2-3 6 8H3z"/></svg>';
    $personIcon   = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>';
    $shieldIcon   = '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.5 12l1.8 1.8L15 10"/></svg>';

    $guidesMap = collect($allGuides)->mapWithKeys(function ($g) {
        $priceStr = preg_replace('/[^0-9]/', '', $g->price);
        $priceNum = intval($priceStr);
        if (stripos($g->price, 'k') !== false && $priceNum < 100000) {
            $priceNum *= 1000;
        }
        $img = !empty($g->image)
            ? (str_starts_with($g->image, '/') || str_starts_with($g->image, 'http') ? asset(ltrim($g->image, '/')) : asset('img/' . $g->image))
            : asset('img/guide-aris-wijaya.png');
        return [$g->id => [
            'title' => $g->title,
            'price' => $g->price,
            'priceNum' => $priceNum,
            'unit' => $g->unit ?? 'Hari',
            'image' => $img
        ]];
    });
@endphp

<div class="w-full px-6 lg:px-12 pb-20"
     x-data="{
        guideId: '{{ $selectedGuide ? $selectedGuide->id : (collect($allGuides)->first()->id ?? '') }}',
        guidesData: @js($guidesMap),
        durasiHari: 2,
        anggota: [],
        addAnggota() {
            this.anggota.push({ nama: '', nik: '' });
        },
        removeAnggota(idx) {
            this.anggota.splice(idx, 1);
        },
        get currentGuide() {
            return this.guidesData[this.guideId] || { title: 'Guide Profesional', price: 'Rp 0', priceNum: 0, unit: 'Hari', image: '' };
        },
        get totalPeserta() {
            return 1 + this.anggota.length;
        },
        get totalTagihan() {
            return this.currentGuide.priceNum * this.durasiHari;
        },
        formatRupiah(num) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
        }
     }">
    <form method="POST" action="{{ route('guide.process') }}" enctype="multipart/form-data" class="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
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

            {{-- Profil / Pilihan Guide --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-4">
                    {!! $mountainIcon !!}
                    <h2 class="text-xl font-bold text-gray-900">Pilihan Guide Pendakian</h2>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-5">
                    <div class="w-24 h-24 rounded-xl overflow-hidden shrink-0 border border-gray-200 bg-gray-100">
                        <img :src="currentGuide.image" :alt="currentGuide.title" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Pilih Guide Profesional</label>
                        <select name="guide_id" x-model="guideId" required class="input font-bold text-gray-900">
                            @foreach ($allGuides as $g)
                                <option value="{{ $g->id }}" {{ ($selectedGuide && $selectedGuide->id == $g->id) ? 'selected' : '' }}>
                                    {{ $g->title }} — {{ $g->price }} / {{ $g->unit ?? 'Hari' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Data Diri Ketua Tim & Jadwal --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-6">
                    {!! $personIcon !!}
                    <h2 class="text-xl font-bold text-gray-900">Data Diri Ketua Tim & Jadwal</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label for="ketua_tim" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Nama Lengkap Ketua Tim <span class="text-rose-500">*</span></label>
                        <input type="text" id="ketua_tim" name="ketua_tim" required placeholder="Contoh: Aris Wijaya" class="input" value="{{ old('ketua_tim') }}" />
                    </div>

                    <div>
                        <label for="whatsapp" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                        <input type="tel" id="whatsapp" name="whatsapp" required placeholder="081234567890" class="input" value="{{ old('whatsapp') }}" />
                    </div>

                    <div>
                        <label for="tanggal_pendakian" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Tanggal Mulai Pendakian <span class="text-rose-500">*</span></label>
                        <input type="date" id="tanggal_pendakian" name="tanggal_pendakian" required class="input" value="{{ old('tanggal_pendakian', date('Y-m-d', strtotime('+3 days'))) }}" />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Durasi Pendakian (Hari) <span class="text-rose-500">*</span></label>
                        <div class="flex items-center gap-3">
                            <button type="button" @click="durasiHari = Math.max(1, durasiHari - 1)" class="w-11 h-11 rounded-xl border border-gray-300 flex items-center justify-center font-bold text-lg hover:bg-gray-100 transition">&minus;</button>
                            <input type="number" name="durasi_hari" x-model="durasiHari" required min="1" class="input text-center font-bold !w-24" />
                            <button type="button" @click="durasiHari++" class="w-11 h-11 rounded-xl border border-gray-300 flex items-center justify-center font-bold text-lg hover:bg-gray-100 transition">+</button>
                            <span class="text-sm font-semibold text-gray-600" x-text="`Total: ${durasiHari} Hari`"></span>
                        </div>
                    </div>

                    <div>
                        <label for="jaminan_type" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Jenis Jaminan Identitas <span class="text-rose-500">*</span></label>
                        <select id="jaminan_type" name="jaminan_type" required class="input">
                            <option value="">-- Pilih Jaminan --</option>
                            <option value="KTP">KTP</option>
                            <option value="BPJS">BPJS</option>
                            <option value="SIM">SIM</option>
                            <option value="PASPOR">Paspor</option>
                        </select>
                    </div>

                    <div>
                        <label for="has_surat_sehat" class="block text-xs font-bold text-gray-500 font-['JetBrains_Mono'] uppercase tracking-widest mb-2">Apakah Anda sudah memiliki Surat Sehat? <span class="text-rose-500">*</span></label>
                        <select id="has_surat_sehat" name="has_surat_sehat" required class="input">
                            <option value="">-- Pilih --</option>
                            <option value="Sudah">Sudah</option>
                            <option value="Belum">Belum</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Dynamic Tambah Anggota Pendaki --}}
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Daftar Anggota Tim Pendaki</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Daftarkan nama-nama rekan yang ikut dalam tim Anda.</p>
                    </div>
                    <button type="button" @click="addAnggota()"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-primary/10 hover:bg-primary/20 text-primary font-bold text-xs transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>+ Tambah Pendaki</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-if="anggota.length === 0">
                        <div class="py-6 text-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <p class="text-sm text-gray-500">Belum ada anggota pendaki lain.</p>
                            <p class="text-xs text-gray-400 mt-0.5">Jika Anda mendaki berdua bersama guide saja, biarkan kosong.</p>
                        </div>
                    </template>

                    <template x-for="(item, index) in anggota" :key="index">
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200/80 relative">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold text-primary uppercase font-['JetBrains_Mono']" x-text="`Pendaki #${index + 2}`"></span>
                                <button type="button" @click="removeAnggota(index)" class="text-xs font-semibold text-rose-500 hover:text-rose-700 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Nama Lengkap Pendaki <span class="text-rose-500">*</span></label>
                                    <input type="text" :name="`anggota[${index}][nama]`" x-model="item.nama" required placeholder="Nama lengkap" class="input !py-2 !text-xs" />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">No. Identitas / NIK / HP <span class="text-rose-500">*</span></label>
                                    <input type="text" :name="`anggota[${index}][nik]`" x-model="item.nik" required placeholder="NIK atau No HP" class="input !py-2 !text-xs" />
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
        </div>

        {{-- ============ KANAN (2/5) ============ --}}
        <div class="lg:col-span-2 flex flex-col gap-6 sticky top-28">

            {{-- Rincian Biaya --}}
            <div class="card p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-5">Rincian Biaya</h2>

                <div class="flex flex-col gap-3 mb-4 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 truncate max-w-[180px]" x-text="currentGuide.title"></span>
                        <span class="text-gray-900 font-medium" x-text="currentGuide.price + ' / ' + currentGuide.unit"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Durasi Sewa Guide</span>
                        <span class="text-gray-900 font-bold" x-text="durasiHari + ' Hari'"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Tim Pendaki</span>
                        <span class="text-primary font-bold" x-text="totalPeserta + ' Orang'"></span>
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
                    <h3 class="text-white font-bold">Guide Berlisensi Resmi</h3>
                </div>
                <p class="text-white/80 text-xs leading-5">
                    Seluruh guide kami bersertifikat resmi dan terlatih dalam navigasi serta P3K pendakian gunung ekstrim.
                </p>
            </div>
        </div>

    </form>
</div>