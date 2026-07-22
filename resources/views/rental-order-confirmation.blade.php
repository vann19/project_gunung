<x-layouts.app title="Konfirmasi Pembayaran - {{ $order->order_code }} - {{ config('app.name') }}" description="Konfirmasi pembayaran pesanan rental alat Anda.">

    @php
        $qrisImage = \App\Models\Setting::get('qris_image');
        
        // Format angka harga
        $formattedTotal = 'Rp ' . number_format($order->total_price, 0, ',', '.');
        
        // Buat pesan WhatsApp
        $waMessage  = "Halo Admin Basecamp Outdoor!\n\n";
        $waMessage .= "Saya ingin mengonfirmasi pembayaran sewa alat rental dengan rincian:\n";
        $waMessage .= "• *Kode Pesanan*: " . $order->order_code . "\n";
        $waMessage .= "• *Nama Pemesan*: " . $order->nama_lengkap . "\n";
        $waMessage .= "• *No. WhatsApp*: " . $order->nomor_wa . "\n";
        $waMessage .= "• *Tanggal Sewa*: " . $order->tanggal_mulai->format('d/m/Y') . "\n";
        $waMessage .= "• *Total Tagihan*: " . $formattedTotal . "\n\n";
        $waMessage .= "*Daftar Alat:*\n";
        if (is_array($order->items)) {
            foreach ($order->items as $idx => $item) {
                $itemTitle = $item['title'] ?? 'Alat';
                if (!empty($item['variant_name'])) {
                    $itemTitle .= " (" . $item['variant_name'] . ")";
                }
                $waMessage .= ($idx + 1) . ". " . $itemTitle . "\n";
            }
        }
        $waMessage .= "\nBerikut saya lampirkan foto screenshot bukti transfer pembayaran.";
        
        $waLink = "https://wa.me/6281227387668?text=" . urlencode($waMessage);
    @endphp

    <main class="pt-28 pb-20 min-h-screen bg-slate-50 relative overflow-hidden"
          x-data="{
              init() {
                  // Bersihkan keranjang belanja setelah berhasil membuat order
                  if (this.$store.rentalCart && typeof this.$store.rentalCart.clear === 'function') {
                      this.$store.rentalCart.clear();
                  }
              }
          }">

        {{-- Background Accents --}}
        <div class="absolute top-10 right-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute bottom-10 left-10 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Status Header Banner --}}
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden mb-8">
                
                <div class="bg-linear-to-r from-primary to-slate-800 p-6 sm:p-8 text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                    
                    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-3 py-1 bg-kuning text-zinc-900 font-extrabold text-xs font-['JetBrains_Mono'] uppercase tracking-wider rounded-full">
                                    Pesanan Tersimpan
                                </span>
                                <span class="text-xs text-primary-100 font-medium">Langkah 2 dari 2</span>
                            </div>
                            <h1 class="text-2xl sm:text-3xl font-black font-['Hanken_Grotesk'] tracking-tight">
                                Pembayaran & Konfirmasi
                            </h1>
                            <p class="text-sm text-primary-100 mt-1">
                                Kode Pesanan: <strong class="text-white font-['JetBrains_Mono'] tracking-wide">{{ $order->order_code }}</strong>
                            </p>
                        </div>

                        <div class="text-left sm:text-right bg-white/10 backdrop-blur-xs p-4 rounded-2xl border border-white/15">
                            <span class="text-xs text-primary-100 block font-medium">Total Pembayaran</span>
                            <span class="text-2xl sm:text-3xl font-black text-kuning font-['Hanken_Grotesk']">{{ $formattedTotal }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                    
                    {{-- QRIS Section --}}
                    <div class="md:col-span-6 flex flex-col items-center justify-center bg-slate-50/80 p-6 rounded-3xl border border-slate-200/80 text-center">
                        <div class="mb-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider font-['JetBrains_Mono'] block mb-1">Scan QRIS Pembayaran</span>
                            <h3 class="font-bold text-slate-800 text-base">Project Gunung Official</h3>
                        </div>

                        <div class="w-56 h-56 bg-white border-2 border-slate-200 rounded-2xl p-4 flex items-center justify-center relative mb-4 shadow-sm">
                            @if ($qrisImage)
                                <img src="{{ img_url($qrisImage) }}" alt="QRIS Barcode" class="w-full h-full object-contain">
                            @else
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode('PAYMENT_' . $order->order_code) }}" alt="QRIS Barcode" class="w-full h-full object-contain">
                                <div class="absolute inset-0 m-auto w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-md border border-slate-100">
                                    <span class="text-[11px] font-black text-rose-600 tracking-tighter">QRIS</span>
                                </div>
                            @endif
                        </div>

                        <p class="text-xs text-slate-500 max-w-xs leading-relaxed mb-6">
                            Buka aplikasi e-Wallet (GoPay, OVO, Dana, ShopeePay) atau M-Banking Anda, lalu scan kode QR di atas untuk menyelesaikan pembayaran.
                        </p>

                        <div class="w-full p-4 bg-amber-50 text-amber-900 rounded-2xl border border-amber-200/80 text-left flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <div class="text-xs space-y-1">
                                <p class="font-bold">Penting:</p>
                                <p class="leading-relaxed">Setelah membayar, ambil foto tangkapan layar (screenshot) bukti transfer, lalu klik tombol konfirmasi WhatsApp di bawah ini.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Order & Customer Detail Section --}}
                    <div class="md:col-span-6 space-y-6">
                        
                        <div>
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 font-['JetBrains_Mono']">
                                Rincian Pemesan
                            </h3>
                            <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-200/80 space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Nama Lengkap</span>
                                    <span class="font-bold text-slate-800">{{ $order->nama_lengkap }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">No. WhatsApp</span>
                                    <span class="font-bold text-slate-800">{{ $order->nomor_wa }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">NIK / Identitas</span>
                                    <span class="font-bold text-slate-800 font-['JetBrains_Mono']">{{ $order->nik_ktp }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Masa Sewa</span>
                                    <span class="font-bold text-primary">{{ $order->tanggal_mulai->format('d/m/Y') }} - {{ $order->tanggal_selesai->format('d/m/Y') }}</span>
                                </div>
                                @if($order->catatan)
                                    <div class="pt-2 border-t border-slate-200">
                                        <span class="text-xs text-slate-400 block mb-1">Catatan:</span>
                                        <p class="text-xs text-slate-600 italic">"{{ $order->catatan }}"</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 font-['JetBrains_Mono']">
                                Daftar Alat yang Disewa
                            </h3>
                            <div class="space-y-2.5 max-h-56 overflow-y-auto pr-1">
                                @if(is_array($order->items))
                                    @foreach($order->items as $item)
                                        <div class="flex items-center justify-between gap-3 p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <img src="{{ $item['image'] ?? '/img/logo.png' }}" alt="" class="w-10 h-10 rounded-lg object-cover bg-slate-100 shrink-0 border border-slate-200">
                                                <div class="min-w-0">
                                                    <h4 class="font-bold text-slate-800 text-xs truncate">{{ $item['title'] ?? 'Alat Rental' }}</h4>
                                                    @if(!empty($item['variant_name']))
                                                        <span class="text-[10px] text-primary font-bold bg-primary/10 px-1.5 py-0.5 rounded uppercase tracking-wider block mt-0.5 w-max">{{ $item['variant_name'] }}</span>
                                                    @endif
                                                    <span class="text-[11px] text-slate-500 block mt-0.5">{{ $item['price'] ?? '-' }} x {{ $item['days'] ?? 1 }} Hari</span>
                                                </div>
                                            </div>
                                            <span class="text-xs font-bold text-secondary-600 shrink-0 font-['Hanken_Grotesk']">
                                                Rp {{ number_format(($item['priceNum'] ?? 0) * ($item['days'] ?? 1), 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="pt-4 space-y-3">
                            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                               style="background-color: #25D366;"
                               class="w-full py-4 text-white rounded-2xl font-bold text-sm text-center transition-all flex items-center justify-center gap-2.5 shadow-lg shadow-emerald-600/20 hover:opacity-95 active:scale-[0.98]">
                                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                Konfirmasi Pembayaran via WhatsApp
                            </a>

                            <a href="{{ route('rental') }}" class="w-full py-3.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-2xl font-bold text-sm text-center transition-colors block">
                                Kembali ke Katalog Rental
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </main>

</x-layouts.app>
