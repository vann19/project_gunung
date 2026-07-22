<x-app-layout>
    <x-slot name="header">
        Manajemen Paket Cuci Alat
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

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Paket Cuci & Perawatan Alat</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola paket layanan yang ditampilkan di halaman publik.</p>
            </div>
            <button onclick="openCreateModal()"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white font-semibold text-sm shadow-md shadow-primary/20 transition active:scale-95 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Paket
            </button>
        </div>

        {{-- Cards Grid --}}
        @if($packages->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($packages as $item)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col hover:shadow-md transition-shadow">

                        {{-- Gambar --}}
                        <div class="relative h-44 bg-slate-100 overflow-hidden">
                            <img src="{{ $item->image ? asset($item->image) : asset('img/Camping gear setup.png') }}"
                                 alt="{{ $item->name }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            @if($item->is_recommended)
                                <span class="absolute top-3 left-3 bg-yellow-400 text-gray-900 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">★ Rekomendasi</span>
                            @endif
                            <span class="absolute bottom-3 left-3 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-2.5 py-1 rounded-full border border-white/30">{{ $item->duration }}</span>
                        </div>

                        {{-- Info --}}
                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="text-base font-bold text-slate-800 mb-1">{{ $item->name }}</h3>
                            <p class="text-slate-500 text-sm leading-relaxed flex-1 mb-4">{{ $item->description }}</p>

                            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                                <div>
                                    <span class="text-primary font-bold text-lg font-['JetBrains_Mono']">{{ $item->price }}</span>
                                    <span class="text-slate-400 text-xs ml-1">{{ $item->unit }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <button type="button"
                                            onclick='openEditModal(@json($item))'
                                            class="p-2 rounded-lg text-slate-400 hover:text-primary hover:bg-primary/10 transition"
                                            title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form method="POST" action="{{ route('admin.cuci-alats.destroy', $item) }}" onsubmit="return confirm('Hapus paket ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200 py-20 text-center text-slate-400 shadow-xs">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                <p class="text-sm font-medium">Belum ada paket. Klik "Tambah Paket" untuk memulai.</p>
            </div>
        @endif

        {{-- MODAL TAMBAH --}}
        <div id="createModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs" onclick="closeCreateModal()"></div>
                <div class="relative z-50 inline-block w-full max-w-lg p-6 my-8 text-left align-middle bg-white shadow-2xl rounded-2xl border border-slate-200">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Tambah Paket Cuci Alat</h3>
                        <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('admin.cuci-alats.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Paket <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" required placeholder="cth: Deep Clean"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Durasi <span class="text-rose-500">*</span></label>
                                <input type="text" name="duration" required placeholder="cth: 3-4 Hari"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Harga <span class="text-rose-500">*</span></label>
                                <input type="text" name="price" required placeholder="cth: Rp 75.000"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Satuan <span class="text-rose-500">*</span></label>
                                <input type="text" name="unit" required value="/ item"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi <span class="text-rose-500">*</span></label>
                            <textarea name="description" rows="3" required placeholder="Jelaskan detail tindakan perawatan..."
                                      class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_recommended" id="create_recommended" class="rounded border-slate-300 text-primary focus:ring-primary">
                            <label for="create_recommended" class="text-sm text-slate-700 font-medium">Tandai sebagai Paket Rekomendasi</label>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Upload Gambar (Opsional)</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary">
                            <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, maksimal 2MB. Jika tidak diupload, akan menggunakan gambar default.</p>
                        </div>
                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeCreateModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">Simpan Paket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT --}}
        <div id="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs" onclick="closeEditModal()"></div>
                <div class="relative z-50 inline-block w-full max-w-lg p-6 my-8 text-left align-middle bg-white shadow-2xl rounded-2xl border border-slate-200">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Edit Paket Cuci Alat</h3>
                        <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form id="editForm" method="POST" action="" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Paket <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" id="edit_name" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Durasi <span class="text-rose-500">*</span></label>
                                <input type="text" name="duration" id="edit_duration" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Harga <span class="text-rose-500">*</span></label>
                                <input type="text" name="price" id="edit_price" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Satuan <span class="text-rose-500">*</span></label>
                                <input type="text" name="unit" id="edit_unit" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi <span class="text-rose-500">*</span></label>
                            <textarea name="description" id="edit_description" rows="3" required
                                      class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_recommended" id="edit_recommended" class="rounded border-slate-300 text-primary focus:ring-primary">
                            <label for="edit_recommended" class="text-sm text-slate-700 font-medium">Tandai sebagai Paket Rekomendasi</label>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Update Gambar (Opsional)</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary">
                            <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG, maksimal 2MB.</p>
                        </div>
                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">Perbarui Paket</button>
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
            document.getElementById('editForm').action = '/admin/cuci-alats/' + item.id;
            document.getElementById('edit_name').value = item.name;
            document.getElementById('edit_duration').value = item.duration;
            document.getElementById('edit_price').value = item.price;
            document.getElementById('edit_unit').value = item.unit || '/ item';
            document.getElementById('edit_description').value = item.description || '';
            document.getElementById('edit_recommended').checked = (item.is_recommended == 1 || item.is_recommended === true);
            document.getElementById('editModal').style.display = 'block';
        }
        function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }
    </script>
</x-app-layout>
