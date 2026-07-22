<x-app-layout>
    <x-slot name="header">
        Manajemen Pesanan Rental Alat
    </x-slot>

    <div class="space-y-8 max-w-7xl mx-auto"
         x-data="{
             photoModalOpen: false,
             currentPhotoUrl: '',
             currentPhotoTitle: '',
             
             statusModalOpen: false,
             currentOrder: null,
             
             openPhotoModal(url, title) {
                 this.currentPhotoUrl = url;
                 this.currentPhotoTitle = title;
                 this.photoModalOpen = true;
             },
             
             openStatusModal(order) {
                 this.currentOrder = order;
                 document.getElementById('statusForm').action = '/admin/rental-orders/' + order.id;
                 document.getElementById('edit_status').value = order.status;
                 document.getElementById('edit_catatan').value = order.catatan || '';
                 document.getElementById('edit_tanggal_kembali').value = order.tanggal_kembali ? this.toDateTimeLocal(order.tanggal_kembali) : '';
                 this.statusModalOpen = true;
             },
             
             formatPrice(amount) {
                 return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
             },

             toDateTimeLocal(value) {
                 if (!value) return '';
                 const date = new Date(value);
                 if (Number.isNaN(date.valueOf())) {
                     return '';
                 }
                 const pad = (num) => String(num).padStart(2, '0');
                 return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
             },

             formatDateTime(value) {
                 if (!value) return '-';
                 const date = new Date(value);
                 if (Number.isNaN(date.valueOf())) {
                     return value;
                 }
                 return new Intl.DateTimeFormat('id-ID', {
                     day: '2-digit',
                     month: '2-digit',
                     year: 'numeric',
                     hour: '2-digit',
                     minute: '2-digit'
                 }).format(date);
             }
         }">

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs" id="flash-message">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('flash-message').remove()" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block font-['JetBrains_Mono']">Total Pesanan</span>
                    <span class="text-2xl font-black text-slate-800 font-['Hanken_Grotesk']">{{ $totalOrders }}</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block font-['JetBrains_Mono']">Menunggu</span>
                    <span class="text-2xl font-black text-amber-600 font-['Hanken_Grotesk']">{{ $pendingCount }}</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block font-['JetBrains_Mono']">Terkonfirmasi</span>
                    <span class="text-2xl font-black text-indigo-600 font-['Hanken_Grotesk']">{{ $confirmedCount }}</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block font-['JetBrains_Mono']">Dicuci</span>
                    <span class="text-2xl font-black text-cyan-600 font-['Hanken_Grotesk']">{{ $washingCount }}</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block font-['JetBrains_Mono']">Selesai</span>
                    <span class="text-2xl font-black text-emerald-600 font-['Hanken_Grotesk']">{{ $completedCount }}</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block font-['JetBrains_Mono']">Dibatalkan</span>
                    <span class="text-2xl font-black text-rose-600 font-['Hanken_Grotesk']">{{ $cancelledCount }}</span>
                </div>
            </div>
        </div>

        {{-- Header Bar & Filters --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Pemesanan & Verifikasi Biodata</h1>
                <p class="text-sm text-slate-500 mt-1">Periksa bukti foto KTP, verifikasi pembayaran QRIS, dan perbarui status peminjaman alat.</p>
            </div>
        </div>

        {{-- Table Container --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row gap-4 justify-between items-center">
                
                {{-- Search Form --}}
                <form method="GET" action="{{ route('admin.rental-orders.index') }}" class="flex gap-3 w-full md:w-auto">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="relative w-full md:w-72">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode, nama, WA"
                               class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary w-full">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition">
                        Cari
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.rental-orders.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition flex items-center">
                            Reset
                        </a>
                    @endif
                </form>

                {{-- Status Filter Tabs --}}
                <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
                    <a href="{{ route('admin.rental-orders.index', ['search' => request('search')]) }}" 
                       class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition {{ !request('status') || request('status') == 'all' ? 'bg-primary text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.rental-orders.index', ['status' => 'pending', 'search' => request('search')]) }}" 
                       class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition {{ request('status') == 'pending' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        Menunggu
                    </a>
                    <a href="{{ route('admin.rental-orders.index', ['status' => 'confirmed', 'search' => request('search')]) }}" 
                       class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition {{ request('status') == 'confirmed' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        Barang Sewa
                    </a>
                    <a href="{{ route('admin.rental-orders.index', ['status' => 'washing', 'search' => request('search')]) }}" 
                       class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition {{ request('status') == 'washing' ? 'bg-cyan-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        Dicuci
                    </a>
                    <a href="{{ route('admin.rental-orders.index', ['status' => 'completed', 'search' => request('search')]) }}" 
                       class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition {{ request('status') == 'completed' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        Ready
                    </a>
                    <a href="{{ route('admin.rental-orders.index', ['status' => 'cancelled', 'search' => request('search')]) }}" 
                       class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition {{ request('status') == 'cancelled' ? 'bg-rose-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        Dibatalkan
                    </a>
                </div>

            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 text-xs uppercase font-['JetBrains_Mono'] border-b border-slate-100">
                        <tr>
                            <th class="py-4 px-6 font-semibold">Kode Pesanan</th>
                            <th class="py-4 px-4 font-semibold">Pemesan & WA</th>
                            <th class="py-4 px-4 font-semibold">Mulai Sewa</th>
                            <th class="py-4 px-4 font-semibold">Tanggal Kembali</th>
                            <th class="py-4 px-4 font-semibold">Aktivitas</th>
                            <th class="py-4 px-4 font-semibold">Total Tagihan</th>
                            <th class="py-4 px-4 font-semibold text-center">Status</th>
                            <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($orders as $order)
                            @php
                                $returnUrgent = false;
                                if ($order->tanggal_kembali) {
                                    $returnUrgent = $order->tanggal_kembali->lte(now()) || $order->tanggal_kembali->between(now(), now()->addHour());
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-4 px-6">
                                    <span class="font-bold text-primary font-['JetBrains_Mono'] block">{{ $order->order_code }}</span>
                                    {{-- <span class="text-[11px] text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</span> --}}
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-bold text-slate-800">{{ $order->nama_lengkap }}</p>
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $order->nomor_wa)) }}" target="_blank" 
                                       class="text-xs text-emerald-600 hover:underline font-semibold inline-flex items-center gap-1 mt-0.5">
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                        {{ $order->nomor_wa }}
                                    </a>
                                    <span class="text-[11px] text-slate-400 block mt-0.5">Jaminan: {{ $order->nik_ktp ?? '-' }}</span>
                                </td>
                                <td class="py-4 px-4 font-medium">
                                    <span class="text-slate-800 font-semibold block">{{ $order->tanggal_mulai->format('d/m/Y') }}</span>
                                    <span class="text-xs text-slate-400">{{ $order->tanggal_mulai->format('l') }}</span>
                                </td>
                                <td class="py-4 px-4 font-medium">
                                    <span class="block rounded-xl px-3 py-2 {{ $returnUrgent ? 'bg-rose-100 text-rose-700 border border-rose-200' : 'bg-slate-50 text-slate-800' }}">
                                        {{ $order->tanggal_kembali ? $order->tanggal_kembali->format('d/m/Y H:i') : '-' }}
                                    </span>
                                    <span class="text-xs {{ $returnUrgent ? 'text-rose-600' : 'text-slate-400' }}">
                                        {{ $order->tanggal_kembali ? $order->tanggal_kembali->format('l') : '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    @if($order->jenis_aktivitas)
                                        <span class="inline-flex items-center gap-1 text-xs font-bold px-2 py-1 rounded-lg {{ $order->jenis_aktivitas === 'pendakian' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }} mb-1">
                                            {{ $order->jenis_aktivitas === 'pendakian' ? '🏔️ Pendakian' : '🌿 Non Pendakian' }}
                                            @if($order->tipe_pendakian)
                                                · {{ ucfirst($order->tipe_pendakian) }}
                                            @endif
                                        </span>
                                        <span class="text-xs text-slate-600 block">{{ $order->tujuan_aktivitas ?? '-' }}</span>
                                    @else
                                        <span class="text-slate-300 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-black text-slate-800 font-['Hanken_Grotesk'] block">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[11px] text-slate-400">{{ is_array($order->items) ? count($order->items) : 0 }} Alat</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold border {{ $order->status_badge_class }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                                @click="openStatusModal({{ json_encode($order) }})"
                                                class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-primary hover:text-white text-slate-700 font-semibold text-xs transition flex items-center gap-1.5"
                                                title="Lihat Detail & Ubah Status">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>Detail / Ubah</span>
                                        </button>
                                        <form method="POST" action="{{ route('admin.rental-orders.destroy', $order) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pesanan rental ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                                    title="Hapus Pesanan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    Belum ada data pesanan sewa alat rental yang masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL PREVIEW FOTO KTP --}}
        <div x-show="photoModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="photoModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-950/80 backdrop-blur-xs" @click="photoModalOpen = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="photoModalOpen" x-transition.scale class="relative z-50 inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl sm:align-middle border border-slate-200">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-base font-bold text-slate-800" x-text="currentPhotoTitle"></h3>
                        <button type="button" @click="photoModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="mt-4 flex flex-col items-center justify-center bg-slate-100 rounded-2xl p-4 overflow-hidden">
                        <img :src="currentPhotoUrl" alt="Foto Identitas" class="max-h-[70vh] w-auto rounded-xl shadow-md object-contain">
                    </div>
                    <div class="mt-4 flex justify-end">
                        <a :href="currentPhotoUrl" target="_blank" class="px-4 py-2 bg-primary text-white rounded-xl text-xs font-bold hover:bg-primary/90 transition flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>Buka di Tab Baru / Unduh</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DETAIL & UBAH STATUS --}}
        <div x-show="statusModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="statusModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-950/80 backdrop-blur-xs" @click="statusModalOpen = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="statusModalOpen" x-transition.scale class="relative z-50 inline-block w-full max-w-xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl sm:align-middle border border-slate-200">
                    
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div>
                            <span class="text-[10px] font-bold text-primary uppercase tracking-wider block">Detail & Verifikasi Pesanan</span>
                            <h3 class="text-lg font-bold text-slate-800" x-text="currentOrder ? currentOrder.order_code : ''"></h3>
                        </div>
                        <button type="button" @click="statusModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <template x-if="currentOrder">
                        <div class="mt-4 space-y-5">
                            
                            {{-- Biodata Singkat --}}
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 space-y-2 text-xs">
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <span class="text-slate-400 block">Nama Pemesan:</span>
                                        <span class="font-bold text-slate-800 text-sm" x-text="currentOrder.nama_lengkap"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block">No. WhatsApp:</span>
                                        <span class="font-bold text-emerald-600 text-sm" x-text="currentOrder.nomor_wa"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block">Jaminan Barang:</span>
                                        <span class="font-bold text-slate-800" x-text="currentOrder.nik_ktp || '-'"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block">Mulai Sewa:</span>
                                        <span class="font-bold text-slate-800" x-text="currentOrder.tanggal_mulai || '-'"></span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <span class="text-slate-400 block">Jadwal Kembali:</span>
                                        <span class="font-bold text-slate-800" x-text="formatDateTime(currentOrder.tanggal_kembali)"></span>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Alamat Domisili:</span>
                                    <span class="text-slate-700 font-medium" x-text="currentOrder.alamat"></span>
                                </div>
                                <div class="pt-2 border-t border-slate-200 grid grid-cols-2 gap-2">
                                    <div>
                                        <span class="text-slate-400 block">Jenis Aktivitas:</span>
                                        <span class="font-bold text-slate-800 capitalize" x-text="currentOrder.jenis_aktivitas ? currentOrder.jenis_aktivitas.replace('_', ' ') : '-'"></span>
                                    </div>
                                    <div x-show="currentOrder.tipe_pendakian">
                                        <span class="text-slate-400 block">Tipe Pendakian:</span>
                                        <span class="font-bold text-slate-800 capitalize" x-text="currentOrder.tipe_pendakian || '-'"></span>
                                    </div>
                                    <div class="col-span-2">
                                        <span class="text-slate-400 block">Tujuan:</span>
                                        <span class="font-bold text-slate-800" x-text="currentOrder.tujuan_aktivitas || '-'"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Daftar Alat --}}
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Alat yang Disewa:</h4>
                                <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                                    <template x-for="item in currentOrder.items" :key="item.slug">
                                        <div class="flex items-center justify-between p-2.5 bg-white rounded-xl border border-slate-200 text-xs">
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <img :src="item.image" class="w-8 h-8 rounded object-cover bg-slate-100">
                                                <div class="min-w-0">
                                                    <span class="font-bold text-slate-800 truncate block" x-text="item.title"></span>
                                                    <template x-if="item.variant_name">
                                                        <span class="text-[10px] text-primary font-bold bg-primary/10 px-1.5 py-0.5 rounded uppercase tracking-wider inline-block mt-0.5" x-text="item.variant_name"></span>
                                                    </template>
                                                    <span class="text-[10px] text-slate-400 block mt-0.5" x-text="item.price + ' / hari'"></span>
                                                </div>
                                            </div>
                                            <span class="font-bold text-secondary-600 shrink-0 font-['Hanken_Grotesk']" x-text="formatPrice(item.priceNum * (item.days || 1))"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            {{-- Form Update Status --}}
                            <form id="statusForm" method="POST" action="" class="space-y-4 pt-3 border-t border-slate-100">
                                @csrf
                                @method('PUT')
                                
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Update Status Pesanan
                                    </label>
                                    <select name="status" id="edit_status" required
                                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                        <option value="pending">Menunggu Konfirmasi</option>
                                        <option value="confirmed">Barang Sewa</option>
                                        <option value="washing">Barang Sedang Dicuci</option>
                                        <option value="completed">Barang Ready</option>
                                        <option value="cancelled">Dibatalkan</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Tanggal & Jam Pengembalian
                                    </label>
                                    <input type="datetime-local" name="tanggal_kembali" id="edit_tanggal_kembali"
                                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Catatan Admin / Keterangan
                                    </label>
                                    <textarea name="catatan" id="edit_catatan" rows="2" placeholder="Tambahkan catatan jika diperlukan..."
                                              class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                                </div>

                                <div class="flex justify-end gap-3 pt-4">
                                    <button type="button" @click="statusModalOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-bold shadow-md shadow-primary/20 transition">Simpan Perubahan Status</button>
                                </div>
                            </form>

                        </div>
                    </template>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
