<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pesanan Open Trip') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Pesanan Open Trip</h3>
                    @if(count($orders) > 0)
                        <form action="{{ route('admin.open-trip-orders.delete-all') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGHAPUS SEMUA pesanan Open Trip? Tindakan ini tidak dapat dibatalkan!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-2 rounded shadow transition">
                                🗑️ Hapus Semua Pesanan
                            </button>
                        </form>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trip</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penanggung Jawab</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak & NIK</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peserta & Tagihan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $order->order_code }}<br>
                                        <span class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $order->trip->title ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-bold">
                                        {{ $order->penanggung_jawab }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        WA: {{ $order->whatsapp }}<br>
                                        NIK: {{ $order->nik }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <div class="mb-2">
                                            <strong class="text-xs text-gray-900 block mb-1">P. Jawab:</strong>
                                            @if($order->foto_ktp)
                                                <a href="{{ asset($order->foto_ktp) }}" target="_blank" class="text-blue-600 hover:underline block text-xs">&bull; KTP</a>
                                            @endif
                                            @if($order->surat_sehat)
                                                <a href="{{ asset($order->surat_sehat) }}" target="_blank" class="text-blue-600 hover:underline block text-xs">&bull; S. Sehat</a>
                                            @endif
                                        </div>

                                        @if($order->anggota && count($order->anggota) > 0)
                                            <div>
                                                <strong class="text-xs text-gray-900 block mb-1">Anggota:</strong>
                                                <ul class="space-y-1">
                                                    @foreach($order->anggota as $idx => $a)
                                                        <li class="text-xs border-l-2 border-gray-200 pl-2">
                                                            <span class="font-semibold">{{ $a['nama'] ?? 'Anggota '.($idx+1) }}</span><br>
                                                            @if(!empty($a['foto_ktp']))
                                                                <a href="{{ asset($a['foto_ktp']) }}" target="_blank" class="text-blue-600 hover:underline inline-block mt-0.5 mr-2">KTP</a>
                                                            @endif
                                                            @if(!empty($a['surat_sehat']))
                                                                <a href="{{ asset($a['surat_sehat']) }}" target="_blank" class="text-blue-600 hover:underline inline-block mt-0.5">S. Sehat</a>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $order->total_peserta }} Orang<br>
                                        <span class="font-bold text-green-600">Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.open-trip-orders.status', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('admin.open-trip-orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
