<x-layouts.app title="Isi Biodata Sewa Rental - {{ config('app.name') }}" description="Lengkapi biodata diri dan upload foto identitas untuk proses sewa alat camping dan pendakian.">

    @php
        // Persiapkan data awal untuk Alpine.js
        $initialItemJson = 'null';
        if ($singleItem) {
            $priceStr = preg_replace('/[^0-9]/', '', $singleItem->price);
            $priceNum = intval($priceStr);
            if (stripos($singleItem->price, 'k') !== false && $priceNum < 100000) {
                $priceNum *= 1000;
            }
            $initialItemJson = json_encode([
                'slug' => $singleItem->slug,
                'title' => $singleItem->title,
                'price' => $singleItem->price,
                'priceNum' => $priceNum,
                'days' => $days,
                'image' => asset($singleItem->image),
                'category' => $singleItem->category
            ]);
        }
        $defaultStartDate = date('Y-m-d');
        $defaultEndDate = date('Y-m-d', strtotime("+{$days} days"));
    @endphp

    <main class="pt-28 pb-20 min-h-screen bg-slate-50 relative overflow-hidden"
          x-data="{
              singleItem: {{ $initialItemJson }},
              items: [],
              startDate: '{{ $defaultStartDate }}',
              totalDays: {{ $days }},
              imagePreview: null,
              isSubmitting: false,
              jenisAktivitas: '',
              tipePendakian: '',
              subWilayah: '',
              tujuanAktivitas: '',
              gunungJawaTengah: [
                  'Merbabu','Lawu','Sindoro','Sumbing','Slamet',
                  'Prau','Kembang','Ungaran','Pakuwaja','Mongkrang',
                  'Andong','Telomoyo','Bismo','Merapi '
              ],
              nonPendakianKategori: ['Sungai','Waduk','Pantai'],
              init() {
                  if (this.singleItem) {
                      this.items = [this.singleItem];
                  } else if (this.$store.rentalCart && this.$store.rentalCart.items.length > 0) {
                      this.items = JSON.parse(JSON.stringify(this.$store.rentalCart.items));
                      if (this.items[0] && this.items[0].days) {
                          this.totalDays = this.items[0].days;
                      }
                  }
              },
              get totalPrice() {
                  return this.items.reduce((sum, item) => sum + (item.priceNum * (item.quantity || item.days || 1) * this.totalDays), 0);
              },
              formatPrice(amount) {
                  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
              },
              handleFileSelect(event) {
                  const file = event.target.files[0];
                  if (file && file.type.startsWith('image/')) {
                      const reader = new FileReader();
                      reader.onload = (e) => {
                          this.imagePreview = e.target.result;
                      };
                      reader.readAsDataURL(file);
                  } else {
                      this.imagePreview = null;
                  }
              }
          }">

        {{-- Background Decorative Accents --}}
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute bottom-1/3 right-10 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Title --}}
            <div class="mb-8 text-center sm:text-left flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200/80 pb-6">
                <div>
                    <span class="px-3 py-1 bg-primary/10 text-primary font-bold text-xs font-['JetBrains_Mono'] uppercase tracking-wider rounded-full inline-block mb-2">
                        Langkah 1 dari 2: Verifikasi Identitas
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-800 font-['Hanken_Grotesk'] tracking-tight">
                        Form Biodata & Upload Identitas
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Demi keamanan bersama dan jaminan alat, harap lengkapi biodata diri dan lampirkan foto KTP/SIM/KTM Anda.
                    </p>
                </div>
                <a href="{{ route('rental') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-all shadow-xs shrink-0 self-center sm:self-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Katalog</span>
                </a>
            </div>

            {{-- Error Validation Alerts --}}
            @if ($errors->any())
                <div class="mb-8 p-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                    <div class="flex items-center gap-3 font-bold text-sm mb-2">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Mohon periksa kembali isian form Anda:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-rose-700 pl-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Empty Cart State (If No Items) --}}
            <template x-if="items.length === 0">
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm max-w-lg mx-auto my-8">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800">Tidak Ada Alat yang Disewa</h2>
                    <p class="text-sm text-slate-500 mt-1 mb-6">Silakan pilih peralatan camping atau gunung yang ingin Anda sewa dari katalog terlebih dahulu.</p>
                    <a href="{{ route('rental') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-xl text-sm font-bold shadow-md hover:bg-primary/90 transition-all">
                        Lihat Katalog Rental
                    </a>
                </div>
            </template>

            {{-- Main Form Grid --}}
            <form action="{{ route('rental.process-biodata') }}" method="POST" enctype="multipart/form-data" 
                  x-show="items.length > 0" 
                  @submit="isSubmitting = true"
                  class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                @csrf

                {{-- Hidden Fields for Items & Price --}}
                <input type="hidden" name="items_json" :value="JSON.stringify(items)">
                <input type="hidden" name="total_price" :value="totalPrice">
                <input type="hidden" name="total_days" :value="totalDays">

                {{-- Left Column: Biodata Form & ID Card Upload --}}
                <div class="lg:col-span-7 space-y-6">
                    
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 sm:p-8">
                        <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 border-b border-slate-100 pb-4 font-['Hanken_Grotesk']">
                            <span class="w-2 h-6 bg-primary rounded-full inline-block"></span>
                            <span>Informasi Data Diri Pemesan</span>
                        </h2>

                        <div class="space-y-5">
                            {{-- Nama Lengkap --}}
                            <div>
                                <label for="nama_lengkap" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                                       placeholder="Masukkan nama lengkap sesuai KTP/SIM"
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 font-medium placeholder:text-slate-400 bg-slate-50/50 focus:bg-white transition-colors">
                            </div>

                            {{-- Nomor WhatsApp & NIK --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="nomor_wa" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">
                                        Nomor WhatsApp <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="nomor_wa" id="nomor_wa" value="{{ old('nomor_wa') }}" required
                                           placeholder="08xxxxxxxxxx"
                                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 font-medium placeholder:text-slate-400 bg-slate-50/50 focus:bg-white transition-colors">
                                    <span class="text-[11px] text-slate-400 mt-1 block">Pastikan aktif untuk konfirmasi admin</span>
                                </div>
                                <div>
                                    <label for="jaminan_barang" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">
                                        Jaminan Barang <span class="text-rose-500">*</span>
                                    </label>
                                    <select name="nik_ktp" id="jaminan_barang" required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 font-medium bg-slate-50/50 focus:bg-white transition-colors">
                                        <option value="" disabled {{ old('nik_ktp') ? '' : 'selected' }}>-- Pilih Jaminan yang Ditinggalkan --</option>
                                        <option value="KTP" {{ old('nik_ktp') === 'KTP' ? 'selected' : '' }}>🪪 KTP (Kartu Tanda Penduduk)</option>
                                        <option value="KTM" {{ old('nik_ktp') === 'KTM' ? 'selected' : '' }}>🎓 KTM (Kartu Tanda Mahasiswa)</option>
                                        <option value="SIM" {{ old('nik_ktp') === 'SIM' ? 'selected' : '' }}>🚗 SIM (Surat Izin Mengemudi)</option>
                                        <option value="BPJS" {{ old('nik_ktp') === 'BPJS' ? 'selected' : '' }}>🏥 BPJS (Kartu BPJS Kesehatan)</option>
                                    </select>
                                    <span class="text-[11px] text-slate-400 mt-1 block">Kartu jaminan akan dikembalikan saat alat kembali.</span>
                                </div>
                            </div>

                            {{-- Alamat Domisili --}}
                            <div>
                                <label for="alamat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">
                                    Alamat Domisili / Tempat Tinggal <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="alamat" id="alamat" rows="3" required
                                          placeholder="Tuliskan alamat lengkap tempat tinggal Anda saat ini..."
                                          class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 font-medium placeholder:text-slate-400 bg-slate-50/50 focus:bg-white transition-colors">{{ old('alamat') }}</textarea>
                            </div>

                            {{-- Tanggal Mulai Sewa --}}
                            <div class="pt-2 border-t border-slate-100">
                                <label for="tanggal_mulai" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">
                                    Tanggal Mulai Sewa <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" x-model="startDate" required
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 font-bold bg-slate-50/50 focus:bg-white transition-colors">
                            </div>

                            {{-- ===== SECTION JENIS AKTIVITAS ===== --}}
                            <div class="pt-4 border-t border-slate-100 space-y-4">

                                {{-- Dropdown Jenis Aktivitas --}}
                                <div>
                                    <label for="jenis_aktivitas" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">
                                        Jenis Aktivitas <span class="text-rose-500">*</span>
                                    </label>
                                    <select name="jenis_aktivitas" id="jenis_aktivitas" x-model="jenisAktivitas" required
                                            @change="subWilayah = ''; tujuanAktivitas = ''; tipePendakian = ''"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 font-medium bg-slate-50/50 focus:bg-white transition-colors">
                                        <option value="" disabled>-- Pilih Jenis Aktivitas --</option>
                                        <option value="pendakian">🏔️ Pendakian</option>
                                        <option value="non_pendakian">🌿 Non Pendakian</option>
                                    </select>
                                </div>

                                {{-- Dropdown Tipe Pendakian (Tektok / Camping) --}}
                                <div x-show="jenisAktivitas === 'pendakian'" x-transition>
                                    <label for="tipe_pendakian" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">
                                        Tipe Pendakian <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="flex gap-3">
                                        <label class="flex-1 flex items-center gap-3 px-4 py-3 rounded-xl border cursor-pointer transition-all"
                                               :class="tipePendakian === 'tektok' ? 'border-primary bg-primary/5 text-primary' : 'border-slate-200 bg-slate-50/50 text-slate-600 hover:border-primary/40'">
                                            <input type="radio" name="tipe_pendakian" x-model="tipePendakian" value="tektok" class="sr-only">
                                            <span class="text-2xl shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path d="M0 0h24v24H0z" fill="none" />
                                                    <path fill="currentColor" d="m10.9 15l-1.625 7.2q-.075.35-.363.575T8.25 23q-.5 0-.8-.375t-.2-.85L10.075 7.45q.15-.725.675-1.088T11.85 6t1.063.25t.787.75l1 1.6q.45.725 1.163 1.312t1.637.863V9.75q0-.325.213-.537T18.25 9t.538.213t.212.537v12.5q0 .325-.213.538T18.25 23t-.537-.213t-.213-.537v-9.4q-1.2-.275-2.225-.875T13.5 10.5l-.6 3l1.8 1.7q.15.15.225.338t.075.387V22q0 .425-.288.713T14 23t-.712-.288T13 22v-5zm-4.45-2.05l-1.15-.225q-.4-.075-.625-.413t-.15-.762l.75-3.925q.15-.85.9-1.287T7.8 6.075q.425.075.638.413t.137.762l-.95 4.9q-.075.425-.412.65t-.763.15m5.638-8.037Q11.5 4.325 11.5 3.5t.588-1.412T13.5 1.5t1.413.588T15.5 3.5t-.587 1.413T13.5 5.5t-1.412-.587" />
                                                </svg>
                                            </span>
                                            <div>
                                                <span class="text-sm font-bold block">Tektok</span>
                                                <span class="text-[11px] opacity-70">Naik & turun hari yang sama</span>
                                            </div>
                                        </label>
                                        <label class="flex-1 flex items-center gap-3 px-4 py-3 rounded-xl border cursor-pointer transition-all"
                                               :class="tipePendakian === 'camping' ? 'border-primary bg-primary/5 text-primary' : 'border-slate-200 bg-slate-50/50 text-slate-600 hover:border-primary/40'">
                                            <input type="radio" name="tipe_pendakian" x-model="tipePendakian" value="camping" class="sr-only">
                                            <span class="text-2xl shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 80 80">
                                                    <path d="M0 0h80v80H0z" fill="none" />
                                                    <path fill="currentColor" fill-rule="evenodd" d="M30.2 13.6a3 3 0 0 1 4.2.6l5.6 7.467l5.6-7.467a3 3 0 1 1 4.8 3.6l-6.65 8.867L69.5 61H72a3 3 0 1 1 0 6H8a3 3 0 0 1 0-6h2.5l25.75-34.333L29.6 17.8a3 3 0 0 1 .6-4.2m.049 47.4L40 47.998L49.752 61z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                            <div>
                                                <span class="text-sm font-bold block">Camping</span>
                                                <span class="text-[11px] opacity-70">Bermalam di gunung</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                {{-- === PENDAKIAN === --}}
                                <div x-show="jenisAktivitas === 'pendakian'" x-transition class="space-y-3">

                                    {{-- Sub wilayah: Jawa Tengah atau Luar Jawa --}}
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['JetBrains_Mono']">
                                            Wilayah Pendakian
                                        </label>
                                        <div class="flex gap-3">
                                            <label class="flex-1 flex items-center gap-2 px-4 py-3 rounded-xl border cursor-pointer transition-all"
                                                   :class="subWilayah === 'jateng' ? 'border-primary bg-primary/5 text-primary' : 'border-slate-200 bg-slate-50/50 text-slate-600 hover:border-primary/40'">
                                                <input type="radio" x-model="subWilayah" value="jateng" @change="tujuanAktivitas = ''" class="sr-only">
                                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                <span class="text-sm font-semibold">Jawa Tengah</span>
                                            </label>
                                            <label class="flex-1 flex items-center gap-2 px-4 py-3 rounded-xl border cursor-pointer transition-all"
                                                   :class="subWilayah === 'luar_jawa' ? 'border-primary bg-primary/5 text-primary' : 'border-slate-200 bg-slate-50/50 text-slate-600 hover:border-primary/40'">
                                                <input type="radio" x-model="subWilayah" value="luar_jawa" @change="tujuanAktivitas = ''" class="sr-only">
                                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                                                <span class="text-sm font-semibold">Luar Jawa</span>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Dropdown Gunung Jawa Tengah (Custom) --}}
                                    <div x-show="subWilayah === 'jateng'" x-transition
                                         x-data="{ openGunung: false }"
                                         @click.away="openGunung = false"
                                         class="relative">
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">
                                            Pilih Gunung <span class="text-rose-500">*</span>
                                        </label>

                                        {{-- Trigger Button --}}
                                        <button type="button" @click="openGunung = !openGunung"
                                                class="w-full flex items-center gap-2.5 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white text-sm font-medium text-left transition-colors focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                                                :class="tujuanAktivitas ? 'text-slate-800' : 'text-slate-400'">
                                            <span class="shrink-0 text-lg" :class="tujuanAktivitas ? 'text-primary' : 'text-slate-400'">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path d="M0 0h24v24H0z" fill="none" />
                                                    <g fill="none" fill-rule="evenodd">
                                                        <path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
                                                        <path fill="currentColor" d="M8.701 5.75c.577-1 2.02-1 2.598 0l3.5 6.062l.902-1.562c.577-1 2.02-1 2.598 0l4.33 7.5A1.5 1.5 0 0 1 21.33 20H17v-.002l-.072.002H3.072a1.5 1.5 0 0 1-1.3-2.25zm-.91 5.576l.709.472l.945-.63a1 1 0 0 1 1.11 0l.945.63l.709-.472L10 7.5z" />
                                                    </g>
                                                </svg>
                                            </span>
                                            <span x-text="tujuanAktivitas || '-- Pilih Gunung --'" class="flex-1"></span>
                                            <svg class="w-4 h-4 text-slate-400 transition-transform shrink-0" :class="openGunung ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>

                                        {{-- Dropdown List --}}
                                        <div x-show="openGunung" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                             class="absolute z-30 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-56 overflow-y-auto">
                                            <template x-for="gunung in gunungJawaTengah" :key="gunung">
                                                <div @click="tujuanAktivitas = 'Gunung ' + gunung; openGunung = false"
                                                     class="flex items-center gap-2.5 px-4 py-2.5 cursor-pointer hover:bg-slate-50 transition-colors text-sm font-medium text-slate-700"
                                                     :class="tujuanAktivitas === 'Gunung ' + gunung ? 'bg-primary/5 text-primary' : ''">
                                                    <span class="text-base shrink-0" :class="tujuanAktivitas === 'Gunung ' + gunung ? 'text-primary' : 'text-slate-400'">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                            <path d="M0 0h24v24H0z" fill="none" />
                                                            <g fill="none" fill-rule="evenodd">
                                                                <path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
                                                                <path fill="currentColor" d="M8.701 5.75c.577-1 2.02-1 2.598 0l3.5 6.062l.902-1.562c.577-1 2.02-1 2.598 0l4.33 7.5A1.5 1.5 0 0 1 21.33 20H17v-.002l-.072.002H3.072a1.5 1.5 0 0 1-1.3-2.25zm-.91 5.576l.709.472l.945-.63a1 1 0 0 1 1.11 0l.945.63l.709-.472L10 7.5z" />
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <span x-text="gunung"></span>
                                                </div>
                                            </template>
                                        </div>

                                        <span class="text-[11px] text-slate-400 mt-1.5 block">Merapi merupakan jalur tidak resmi, harap perhatikan risiko.</span>
                                    </div>

                                    {{-- Input Gunung Luar Jawa --}}
                                    <div x-show="subWilayah === 'luar_jawa'" x-transition>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">
                                            Nama Gunung <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" x-model="tujuanAktivitas"
                                               :required="jenisAktivitas === 'pendakian' && subWilayah === 'luar_jawa'"
                                               placeholder="Contoh: Gunung Rinjani, Gunung Semeru..."
                                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 font-medium placeholder:text-slate-400 bg-slate-50/50 focus:bg-white transition-colors">
                                    </div>

                                </div>

                                {{-- === NON PENDAKIAN === --}}
                                <div x-show="jenisAktivitas === 'non_pendakian'" x-transition class="space-y-3">

                                    {{-- Dropdown Kategori Tempat --}}
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">
                                            Kategori Tempat <span class="text-rose-500">*</span>
                                        </label>
                                        <select x-model="subWilayah" @change="tujuanAktivitas = ''"
                                                :required="jenisAktivitas === 'non_pendakian'"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 font-medium bg-slate-50/50 focus:bg-white transition-colors">
                                            <option value="" disabled>-- Pilih Kategori --</option>
                                            <template x-for="kat in nonPendakianKategori" :key="kat">
                                                <option :value="kat.toLowerCase()" x-text="kat === 'Sungai' ? '🏞️ ' + kat : kat === 'Waduk' ? '💧 ' + kat : '🌊 ' + kat"></option>
                                            </template>
                                        </select>
                                    </div>

                                    {{-- Input nama tempat --}}
                                    <div x-show="subWilayah !== ''" x-transition>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">
                                            Nama <span x-text="subWilayah ? subWilayah.charAt(0).toUpperCase() + subWilayah.slice(1) : 'Tempat'"></span> <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" x-model="tujuanAktivitas"
                                               :required="jenisAktivitas === 'non_pendakian' && subWilayah !== ''"
                                               :placeholder="'Contoh: ' + (subWilayah === 'sungai' ? 'Sungai Elo, Sungai Progo...' : subWilayah === 'waduk' ? 'Waduk Sermo, Waduk Gajah Mungkur...' : 'Pantai Parangtritis, Pantai Baron...')"
                                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 font-medium placeholder:text-slate-400 bg-slate-50/50 focus:bg-white transition-colors">
                                    </div>

                                </div>

                                {{-- Hidden input untuk submit form --}}
                                <input type="hidden" name="tujuan_aktivitas" :value="tujuanAktivitas">
                                <input type="hidden" name="tipe_pendakian" :value="tipePendakian">

                            </div>

                        </div>
                    </div>


                    {{-- Catatan Tambahan --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 sm:p-8">
                        <label for="catatan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 font-['JetBrains_Mono']">
                            Catatan Tambahan untuk Admin (Opsional)
                        </label>
                        <textarea name="catatan" id="catatan" rows="2"
                                  placeholder="Contoh: Tolong siapkan alat sebelum jam 8 pagi / Request tenda warna gelap..."
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 font-medium placeholder:text-slate-400 bg-slate-50/50 focus:bg-white transition-colors">{{ old('catatan') }}</textarea>
                    </div>

                </div>

                {{-- Right Column: Order Summary & Submit --}}
                <div class="lg:col-span-5 lg:sticky lg:top-28 space-y-6">
                    
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden">
                        
                        <div class="bg-primary px-6 py-5 text-white flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-base font-['Hanken_Grotesk']">Ringkasan Pesanan</h3>
                                <p class="text-xs text-primary-100">Periksa kembali daftar gear yang disewa</p>
                            </div>
                            <span class="px-2.5 py-1 bg-white/10 rounded-lg text-xs font-bold font-['JetBrains_Mono']" x-text="items.length + ' Alat'"></span>
                        </div>

                        <div class="p-6 space-y-4 max-h-[350px] overflow-y-auto divide-y divide-slate-100 pr-2">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="pt-3 first:pt-0 flex items-start gap-3.5">
                                    <img :src="item.image" :alt="item.title" class="w-14 h-14 rounded-xl object-cover bg-slate-100 shrink-0 border border-slate-200">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-bold text-slate-800 truncate" x-text="item.title"></h4>
                                        <div class="flex gap-1.5 flex-wrap mt-1">
                                            <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-slate-500 bg-slate-100 px-2 py-0.5 rounded" x-text="item.category"></span>
                                            <template x-if="item.variant_name">
                                                <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-primary bg-primary/10 px-2 py-0.5 rounded" x-text="item.variant_name"></span>
                                            </template>
                                        </div>
                                        <div class="mt-1 flex items-center justify-between text-xs">
                                            <span class="text-slate-500" x-text="item.price + ' x ' + (item.quantity || item.days || 1) + ' Barang x ' + totalDays + ' Hari'"></span>
                                            <span class="font-bold text-secondary-600 font-['Hanken_Grotesk']" x-text="formatPrice(item.priceNum * (item.quantity || item.days || 1) * totalDays)"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="bg-slate-50/80 p-6 border-t border-slate-200/80 space-y-3">
                            <div class="flex justify-between items-center text-xs text-slate-500">
                                <span>Durasi Sewa</span>
                                <span class="font-bold text-slate-700" x-text="totalDays + ' Hari'"></span>
                            </div>
                            <div class="flex justify-between items-center text-xs text-slate-500">
                                <span>Status Awal Pesanan</span>
                                <span class="px-2 py-0.5 bg-amber-100 text-amber-800 font-bold rounded text-[10px]">Menunggu Pembayaran</span>
                            </div>
                            <div class="pt-3 border-t border-slate-200 flex justify-between items-end">
                                <div>
                                    <span class="text-xs font-semibold text-slate-500 block">Total Tagihan</span>
                                    <span class="text-[11px] text-slate-400">Belum termasuk ongkir/deposit</span>
                                </div>
                                <span class="text-2xl font-black text-secondary-500 font-['Hanken_Grotesk']" x-text="formatPrice(totalPrice)"></span>
                            </div>
                        </div>

                        <div class="p-6 pt-2 bg-slate-50/80">
                            <button type="submit" 
                                    :disabled="isSubmitting"
                                    class="w-full py-4 bg-linear-to-r from-primary to-slate-800 hover:from-primary/90 hover:to-slate-800/90 text-white rounded-2xl font-bold text-base shadow-lg shadow-primary/25 transition-all duration-300 flex items-center justify-center gap-2 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                                <template x-if="!isSubmitting">
                                    <div class="flex items-center gap-2">
                                        <span>Simpan & Lanjut Bayar QRIS</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </div>
                                </template>
                                <template x-if="isSubmitting">
                                    <div class="flex items-center gap-2">
                                        <svg class="animate-spin w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        <span>Memproses Biodata...</span>
                                    </div>
                                </template>
                            </button>
                            <p class="text-[11px] text-slate-400 text-center mt-3 leading-tight">
                                🔒 Data biodata & foto KTP Anda dilindungi dan hanya digunakan oleh Admin Project Gunung untuk keperluan verifikasi rental.
                            </p>
                        </div>

                    </div>

                </div>

            </form>

        </div>
    </main>

</x-layouts.app>
