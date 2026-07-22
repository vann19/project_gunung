<x-app-layout>
    <x-slot name="header">
        Manajemen Guide Pendakian
    </x-slot>

    <div class="space-y-8 max-w-7xl mx-auto">

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

        {{-- Header Bar & Tombol Tambah --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Layanan Guide & Porter Profesional</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola paket pendampingan gunung, tarif harian, sertifikasi, dan keunggulan guide.</p>
            </div>
            <button onclick="openCreateModal()"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white font-semibold text-sm shadow-md shadow-primary/20 transition active:scale-95 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Paket Guide</span>
            </button>
        </div>

        {{-- Table Container --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row gap-4 justify-between items-center">
                <form method="GET" action="{{ route('admin.hiking-guides.index') }}" class="flex gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-64">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama paket guide..."
                               class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary w-full">
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 text-xs uppercase font-['JetBrains_Mono'] border-b border-slate-100">
                        <tr>
                            <th class="py-4 px-6 font-semibold">Paket Guide</th>
                            <th class="py-4 px-4 font-semibold">Badge Sertifikasi</th>
                            <th class="py-4 px-4 font-semibold">Tarif Layanan</th>
                            <th class="py-4 px-4 font-semibold text-center">Sisa Slot</th>
                            <th class="py-4 px-4 font-semibold text-center">Populer</th>
                            <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($guides as $item)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200 flex items-center justify-center">
                                            @if($item->image)
                                                <img src="{{ img_url($item->image) }}" alt="" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-xs text-slate-400">No img</span>
                                            @endif
                                        </div>
                                        <p class="font-bold text-slate-800">{{ $item->title }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold uppercase {{ $item->badge_class }}">
                                        {{ $item->badge }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-800 font-['JetBrains_Mono']">
                                    {{ $item->price }} <span class="text-xs font-normal text-slate-400">{{ $item->unit }}</span>
                                </td>
                                <td class="py-4 px-4 text-center font-bold text-slate-800 font-['JetBrains_Mono']">
                                    {{ $item->slot ?? 10 }} Slot
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if($item->is_featured)
                                        <span class="inline-block px-2.5 py-0.5 rounded bg-amber-100 text-amber-800 text-[10px] font-bold">★ Unggulan</span>
                                    @else
                                        <span class="text-slate-300 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                                onclick='openEditModal(@json($item))'
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-primary hover:bg-primary/10 transition"
                                                title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <form method="POST" action="{{ route('admin.hiking-guides.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket guide ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition"
                                                    title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400">
                                    Belum ada data paket Guide Pendakian. Klik tombol "+ Tambah Paket Guide" untuk memulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL TAMBAH GUIDE --}}
        <div id="createModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-950/60 backdrop-blur-xs" onclick="closeCreateModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative z-50 inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl sm:align-middle border border-slate-200">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Tambah Paket Guide Pendakian</h3>
                        <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.hiking-guides.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Judul Paket Guide <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" required placeholder="cth: Professional Certified Guide"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Badge Sertifikasi <span class="text-rose-500">*</span></label>
                                <input type="text" name="badge" required value="SERTIFIKASI APGI"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Tarif Layanan <span class="text-rose-500">*</span></label>
                                <input type="text" name="price" required placeholder="cth: Rp 450.000"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Satuan <span class="text-rose-500">*</span></label>
                                <input type="text" name="unit" required value="/ hari"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Sisa Slot <span class="text-rose-500">*</span></label>
                                <input type="number" name="slot" required min="1" value="10"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Unggah Gambar</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Fasilitas & Keahlian (1 baris per poin)</label>
                            <textarea name="features_text" rows="3" placeholder="Sertifikasi Resmi APGI & P3K&#10;Rasio pendampingan aman (1:4)&#10;Menguasai rute & navigasi darat"
                                      class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" name="is_featured" id="create_featured" class="rounded border-slate-300 text-primary focus:ring-primary">
                            <label for="create_featured" class="text-sm text-slate-700 font-medium">Tandai sebagai Paket Paling Populer (Featured)</label>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeCreateModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">Simpan Guide</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT GUIDE --}}
        <div id="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-950/60 backdrop-blur-xs" onclick="closeEditModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative z-50 inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl sm:align-middle border border-slate-200">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Edit Paket Guide Pendakian</h3>
                        <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form id="editForm" method="POST" action="" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Judul Paket Guide <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" id="edit_title" required
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Badge Sertifikasi <span class="text-rose-500">*</span></label>
                                <input type="text" name="badge" id="edit_badge" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Tarif Layanan <span class="text-rose-500">*</span></label>
                                <input type="text" name="price" id="edit_price" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Satuan <span class="text-rose-500">*</span></label>
                                <input type="text" name="unit" id="edit_unit" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Sisa Slot <span class="text-rose-500">*</span></label>
                                <input type="number" name="slot" id="edit_slot" required min="1"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Update Gambar (Opsional)</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Fasilitas & Keahlian</label>
                            <textarea name="features_text" id="edit_features_text" rows="3"
                                      class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" name="is_featured" id="edit_featured" class="rounded border-slate-300 text-primary focus:ring-primary">
                            <label for="edit_featured" class="text-sm text-slate-700 font-medium">Tandai sebagai Paket Paling Populer (Featured)</label>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">Perbarui Guide</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        function openCreateModal() { document.getElementById('createModal').style.display = 'block'; }
        function closeCreateModal() { document.getElementById('createModal').style.display = 'none'; }
        function openEditModal(item) {
            document.getElementById('editForm').action = '/admin/hiking-guides/' + item.id;
            document.getElementById('edit_title').value = item.title;
            document.getElementById('edit_badge').value = item.badge;
            document.getElementById('edit_price').value = item.price;
            document.getElementById('edit_unit').value = item.unit || '/ hari';
            document.getElementById('edit_slot').value = item.slot || 10;
            document.getElementById('edit_featured').checked = (item.is_featured == 1 || item.is_featured === true);
            
            let featuresStr = '';
            if (item.features && Array.isArray(item.features)) {
                featuresStr = item.features.map(f => f.label || f).join('\n');
            }
            document.getElementById('edit_features_text').value = featuresStr;
            
            document.getElementById('editModal').style.display = 'block';
        }
        function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }
    </script>
</x-app-layout>
