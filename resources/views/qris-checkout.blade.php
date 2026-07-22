<x-layouts.app title="Checkout {{ $product->title }} - {{ config('app.name') }}" description="Pembayaran sewa alat rental.">


    <div class="pt-24 pb-16 min-h-screen bg-slate-50 flex items-center justify-center">
        <div class="max-w-md w-full mx-auto px-4">
            
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200/60 overflow-hidden">
                
                {{-- Header Modal --}}
                <div class="bg-primary p-6 text-center text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                    <h1 class="text-xl font-bold relative z-10 font-['Hanken_Grotesk']">Pembayaran Sewa</h1>
                    <p class="text-primary-100 text-sm mt-1 relative z-10">Silakan scan kode QRIS di bawah ini</p>
                </div>

                <div class="p-8">
                    {{-- Detail Pesanan --}}
                    <div class="mb-8 pb-6 border-b border-dashed border-slate-200">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 font-['JetBrains_Mono']">Detail Pesanan</h2>
                        <div class="flex gap-4">
                            <img src="{{ img_url($product->image) }}" alt="{{ $product->title }}" class="w-16 h-16 rounded-xl object-cover bg-slate-100 shrink-0">
                            <div>
                                <h3 class="font-bold text-slate-800 leading-tight">{{ $product->title }}</h3>
                                <p class="text-sm text-slate-500 capitalize mt-1">{{ $product->category }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- QR Code Area (Mockup) --}}
                    @php
                        $qrisImage = \App\Models\Setting::get('qris_image');
                    @endphp
                    <div class="flex flex-col items-center justify-center mb-8">
                        <div class="w-48 h-48 bg-white border-2 border-slate-200 rounded-2xl p-4 flex items-center justify-center relative mb-4 shadow-sm shadow-slate-100">
                            @if ($qrisImage)
                                <img src="{{ img_url($qrisImage) }}" alt="QRIS Barcode" class="w-full h-full object-contain">
                            @else
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode('MOCKUP_PAYMENT_' . $product->slug) }}" alt="QRIS Barcode" class="w-full h-full object-contain">
                                <div class="absolute inset-0 m-auto w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-md">
                                    <span class="text-[10px] font-black text-rose-600 tracking-tighter">QRIS</span>
                                </div>
                            @endif
                        </div>
                        <p class="text-sm text-slate-500 text-center px-4">
                            Buka aplikasi M-Banking atau e-Wallet Anda (GoPay, OVO, Dana, LinkAja), lalu scan kode ini.
                        </p>
                    </div>

                    {{-- Total Tagihan --}}
                    <div class="bg-slate-50 rounded-2xl p-4 flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-600">Total Tagihan</span>
                        <span class="text-xl font-black text-secondary-500 font-['Hanken_Grotesk']">{{ $product->price }}</span>
                    </div>

                    <div class="mt-6 flex flex-col gap-4">
                        <div class="p-4 bg-blue-50 text-blue-800 rounded-xl border border-blue-100 flex items-start gap-3">
                            <svg class="w-5 h-5 shrink-0 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-xs leading-relaxed">
                                Setelah berhasil melakukan pembayaran, harap ambil tangkapan layar (screenshot) bukti transfer Anda. <strong>Kirimkan bukti tersebut ke WhatsApp admin</strong> untuk proses konfirmasi pesanan.
                            </p>
                        </div>

                        @php
                            $waMessage = "Halo Admin Basecamp Outdoor!%0A%0ASaya ingin mengonfirmasi pembayaran sewa alat rental dengan rincian:%0ANama Alat: *{$product->title}*%0ATotal Tagihan: *{$product->price}*%0A%0ABerikut saya lampirkan foto screenshot bukti transfer pembayaran.";
                            $waLink = "https://wa.me/6281227387668?text={$waMessage}"; // Nomor admin
                        @endphp

                        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                           style="background-color: #25D366;"
                           class="w-full py-3.5 text-white rounded-xl font-bold text-sm text-center transition-colors flex items-center justify-center gap-2 shadow-sm hover:opacity-90">
                            <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Konfirmasi Pembayaran via WhatsApp
                        </a>
                        <a href="{{ route('rental.show', ['category' => $product->category, 'slug' => $product->slug]) }}" class="w-full py-3.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl font-bold text-sm text-center transition-colors">
                            Batalkan
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-layouts.app>
