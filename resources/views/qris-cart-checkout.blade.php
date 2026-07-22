<x-layouts.app title="Checkout Keranjang Rental - {{ config('app.name') }}" description="Pembayaran sewa alat rental multi-item.">

    <div
        x-data="{
            getWaUrl() {
                if (!this.$store.rentalCart || this.$store.rentalCart.items.length === 0) return '#';
                let msg = 'Halo Admin Basecamp Outdoor!\n\nSaya ingin mengonfirmasi pembayaran sewa alat rental dengan rincian:\n\n';
                this.$store.rentalCart.items.forEach((item, idx) => {
                    msg += `${idx + 1}. *${item.title}*\n`;
                });
                msg += `\n*Total Tagihan: ${this.$store.rentalCart.formatPrice(this.$store.rentalCart.totalPrice)}*\n\nBerikut saya lampirkan foto screenshot bukti transfer pembayaran.`;
                return 'https://wa.me/6281227387668?text=' + encodeURIComponent(msg);
            }
        }"
        class="pt-28 pb-16 min-h-screen bg-slate-50 flex items-center justify-center px-4"
    >
        <div class="max-w-xl w-full mx-auto">
            
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200/60 overflow-hidden">
                
                {{-- Header Modal --}}
                <div class="bg-primary p-6 text-center text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                    <h1 class="text-xl font-bold relative z-10 font-['Hanken_Grotesk']">Pembayaran Keranjang Sewa</h1>
                    <p class="text-primary-100 text-sm mt-1 relative z-10">Periksa rincian alat dan scan kode QRIS</p>
                </div>

                <div class="p-6 md:p-8">
                    
                    {{-- Empty State jika langsung akses URL --}}
                    <template x-if="!$store.rentalCart || $store.rentalCart.items.length === 0">
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-bold text-slate-800">Keranjang Anda Kosong</h2>
                            <p class="text-sm text-slate-500 mt-1 mb-6">Belum ada barang rental yang dipilih untuk dicheckout.</p>
                            <a href="{{ route('rental') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-xl text-sm font-bold shadow-sm hover:bg-primary/90 transition-all">
                                Kembali ke Katalog Rental
                            </a>
                        </div>
                    </template>

                    <template x-if="$store.rentalCart && $store.rentalCart.items.length > 0">
                        <div>
                            {{-- Detail Pesanan --}}
                            <div class="mb-8 pb-6 border-b border-dashed border-slate-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider font-['JetBrains_Mono']">Rincian Sewa (<span x-text="$store.rentalCart.itemCount"></span> Alat)</h2>
                                    <a href="{{ route('rental') }}" class="text-xs text-blue-600 font-bold hover:underline">Tambah Gear Lain</a>
                                </div>
                                
                                <div class="space-y-4 max-h-64 overflow-y-auto pr-1">
                                    <template x-for="item in $store.rentalCart.items" :key="item.slug">
                                        <div class="flex items-center justify-between gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <img :src="item.image" :alt="item.title" class="w-12 h-12 rounded-lg object-cover bg-white shrink-0 border border-slate-200">
                                                <div class="min-w-0">
                                                    <h3 class="font-bold text-slate-800 text-sm truncate" x-text="item.title"></h3>
                                                    <p class="text-xs text-slate-500">
                                                        <span x-text="item.price"></span> x <strong class="text-slate-700" x-text="item.days + ' Hari'"></strong>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right shrink-0">
                                                <span class="text-sm font-black text-secondary-600 font-['Hanken_Grotesk']" x-text="$store.rentalCart.formatPrice(item.priceNum * item.days)"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            {{-- QR Code Area --}}
                            @php
                                $qrisImage = \App\Models\Setting::get('qris_image');
                            @endphp
                            <div class="flex flex-col items-center justify-center mb-8">
                                <div class="w-48 h-48 bg-white border-2 border-slate-200 rounded-2xl p-4 flex items-center justify-center relative mb-4 shadow-sm shadow-slate-100">
                                    @if ($qrisImage)
                                        <img src="{{ asset($qrisImage) }}" alt="QRIS Barcode" class="w-full h-full object-contain">
                                    @else
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=MOCKUP_PAYMENT_CART_RENTAL" alt="QRIS Barcode" class="w-full h-full object-contain">
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
                            <div class="bg-slate-100 rounded-2xl p-5 flex items-center justify-between border border-slate-200/60">
                                <div>
                                    <span class="text-sm font-semibold text-slate-700 block">Total Pembayaran</span>
                                    <span class="text-xs text-slate-500">Durasi sesuai pilihan per item</span>
                                </div>
                                <span class="text-2xl font-black text-secondary-500 font-['Hanken_Grotesk']" x-text="$store.rentalCart.formatPrice($store.rentalCart.totalPrice)"></span>
                            </div>

                            <div class="mt-6 flex flex-col gap-4">
                                <div class="p-4 bg-blue-50 text-blue-800 rounded-xl border border-blue-100 flex items-start gap-3">
                                    <svg class="w-5 h-5 shrink-0 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-xs leading-relaxed">
                                        Setelah berhasil melakukan pembayaran, harap ambil tangkapan layar (screenshot) bukti transfer Anda. <strong>Kirimkan bukti tersebut ke WhatsApp admin</strong> untuk konfirmasi pesanan.
                                    </p>
                                </div>

                                <a :href="getWaUrl()" target="_blank" rel="noopener noreferrer"
                                   style="background-color: #25D366;"
                                   @click="$store.rentalCart.clear()"
                                   class="w-full py-3.5 text-white rounded-xl font-bold text-sm text-center transition-colors flex items-center justify-center gap-2 shadow-sm hover:opacity-90 cursor-pointer">
                                    <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    Konfirmasi Pembayaran via WhatsApp
                                </a>
                                <a href="{{ route('rental') }}" class="w-full py-3.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl font-bold text-sm text-center transition-colors">
                                    Kembali ke Katalog
                                </a>
                            </div>
                        </div>
                    </template>
                </div>

            </div>

        </div>
    </div>
</x-layouts.app>
