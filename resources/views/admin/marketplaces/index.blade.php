<x-app-layout>
    <x-slot name="header">
        Manajemen Marketplace Barang Bekas
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

        {{-- Error Validation Message --}}
        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs" id="error-message">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span class="text-sm font-bold">Terjadi kesalahan validasi:</span>
                    </div>
                    <button onclick="document.getElementById('error-message').remove()" class="text-rose-500 hover:text-rose-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <ul class="list-disc list-inside text-sm ml-8 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header Bar & Tombol Tambah --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Barang Marketplace Bekas</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola barang outdoor second, kategori, kondisi barang, spesifikasi teknis, dan harga jual.</p>
            </div>
            <button onclick="openCreateModal()"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white font-semibold text-sm shadow-md shadow-primary/20 transition active:scale-95 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Barang Bekas</span>
            </button>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider font-['JetBrains_Mono']">Total Barang Dijual</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800">{{ $totalItems }}</span>
                    <span class="text-xs text-slate-500 font-medium">Item Terdaftar</span>
                </div>
            </div>
        </div>

        {{-- Filter & Table Container --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row gap-4 justify-between items-center">
                <form method="GET" action="{{ route('admin.marketplaces.index') }}" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <div class="relative">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..."
                               class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary w-full sm:w-64">
                    </div>

                    <div class="relative">
                        <select name="category" onchange="this.form.submit()" class="appearance-none py-2 pl-4 pr-10 bg-white border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-700 w-full sm:w-auto">
                            <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>Semua Kategori</option>
                            <option value="camping" {{ request('category') == 'camping' ? 'selected' : '' }}>Camping</option>
                            <option value="kelompok" {{ request('category') == 'kelompok' ? 'selected' : '' }}>Kelompok</option>
                            <option value="masak" {{ request('category') == 'masak' ? 'selected' : '' }}>Masak</option>
                            <option value="makan" {{ request('category') == 'makan' ? 'selected' : '' }}>Makan</option>
                            <option value="piknik" {{ request('category') == 'piknik' ? 'selected' : '' }}>Piknik Santai</option>
                            <option value="grill" {{ request('category') == 'grill' ? 'selected' : '' }}>Grill</option>
                            <option value="pribadi" {{ request('category') == 'pribadi' ? 'selected' : '' }}>Pribadi</option>
                            <option value="hydropack" {{ request('category') == 'hydropack' ? 'selected' : '' }}>Hydropack</option>
                            <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lain-lain</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </form>

                @if(request('search') || (request('category') && request('category') != 'all'))
                    <a href="{{ route('admin.marketplaces.index') }}" class="text-xs font-semibold text-rose-500 hover:underline">Reset Filter</a>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 text-xs uppercase font-['JetBrains_Mono'] border-b border-slate-100">
                        <tr>
                            <th class="py-4 px-6 font-semibold">Barang</th>
                            <th class="py-4 px-4 font-semibold">Kategori</th>
                            <th class="py-4 px-4 font-semibold">Kondisi</th>
                            <th class="py-4 px-4 font-semibold">Spesifikasi</th>
                            <th class="py-4 px-4 font-semibold">Stok</th>
                            <th class="py-4 px-4 font-semibold">Harga Jual</th>
                            <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($items as $item)
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
                                        <div>
                                            <p class="font-bold text-slate-800">{{ $item->title }}</p>
                                            @if($item->old_price)
                                                <p class="text-[11px] text-slate-400 line-through">{{ $item->old_price }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-['JetBrains_Mono'] font-medium bg-slate-100 text-slate-700 capitalize">
                                        {{ $item->category }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[11px] font-bold uppercase {{ $item->badge_class }}">
                                        {{ $item->condition_badge }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-['JetBrains_Mono'] text-xs text-slate-500">
                                    {{ $item->spec }}
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-800 font-['JetBrains_Mono']">
                                    {{ $item->stock }}
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-800 font-['JetBrains_Mono']">
                                    {{ $item->price }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                                onclick='openEditModal(@json($item))'
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-primary hover:bg-primary/10 transition"
                                                title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <form method="POST" action="{{ route('admin.marketplaces.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
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
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    Belum ada data barang bekas di Marketplace. Klik tombol "+ Tambah Barang Bekas" untuk memulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL TAMBAH MARKETPLACE --}}
        <div id="createModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-950/60 backdrop-blur-xs" onclick="closeCreateModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative z-50 inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl sm:align-middle border border-slate-200">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Tambah Barang Bekas Marketplace</h3>
                        <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.marketplaces.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Judul Barang <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" required placeholder="cth: Arc'teryx Alpha SV (Bekas)"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kategori <span class="text-rose-500">*</span></label>
                                <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <option value="camping">Camping</option>
                                    <option value="kelompok">Kelompok</option>
                                    <option value="masak">Masak</option>
                                    <option value="makan">Makan</option>
                                    <option value="piknik">Piknik Santai</option>
                                    <option value="grill">Grill</option>
                                    <option value="pribadi">Pribadi</option>
                                    <option value="hydropack">Hydropack</option>
                                    <option value="lainnya">Lain-lain</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kondisi Barang <span class="text-rose-500">*</span></label>
                                <select name="condition_badge" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <option value="Baru">Baru</option>
                                    <option value="Bekas">Bekas</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Harga Jual Baru <span class="text-rose-500">*</span></label>
                                <input type="text" name="price" required placeholder="cth: Rp 7.850.000"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Harga Asli Lama (Opsional)</label>
                                <input type="text" name="old_price" placeholder="cth: Rp 12.500.000"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Stok <span class="text-rose-500">*</span></label>
                                <input type="number" name="stock" required min="0" value="1"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Spesifikasi Singkat</label>
                                <input type="text" name="spec" placeholder="cth: ALT: 5000m Performance"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap</label>
                            <textarea name="description" rows="3" placeholder="Jelaskan kondisi detail barang..."
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Unggah Gambar</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary">
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeCreateModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">Simpan Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT MARKETPLACE --}}
        <div id="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-950/60 backdrop-blur-xs" onclick="closeEditModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative z-50 inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl sm:align-middle border border-slate-200">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Edit Barang Bekas Marketplace</h3>
                        <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form id="editForm" method="POST" action="" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Judul Barang <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" id="edit_title" required
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kategori <span class="text-rose-500">*</span></label>
                                <select name="category" id="edit_category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <option value="camping">Camping</option>
                                    <option value="kelompok">Kelompok</option>
                                    <option value="masak">Masak</option>
                                    <option value="makan">Makan</option>
                                    <option value="piknik">Piknik Santai</option>
                                    <option value="grill">Grill</option>
                                    <option value="pribadi">Pribadi</option>
                                    <option value="hydropack">Hydropack</option>
                                    <option value="lainnya">Lain-lain</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kondisi Barang <span class="text-rose-500">*</span></label>
                                <select name="condition_badge" id="edit_condition_badge" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <option value="Baru">Baru</option>
                                    <option value="Bekas">Bekas</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Harga Jual Baru <span class="text-rose-500">*</span></label>
                                <input type="text" name="price" id="edit_price" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Harga Asli Lama (Opsional)</label>
                                <input type="text" name="old_price" id="edit_old_price"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Stok <span class="text-rose-500">*</span></label>
                                <input type="number" name="stock" id="edit_stock" required min="0"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Spesifikasi Singkat</label>
                                <input type="text" name="spec" id="edit_spec"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap</label>
                            <textarea name="description" id="edit_description" rows="3"
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Update Gambar (Opsional)</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary">
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">Perbarui Barang</button>
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
            document.getElementById('editForm').action = '/admin/marketplaces/' + item.id;
            document.getElementById('edit_title').value = item.title;
            document.getElementById('edit_category').value = item.category;
            document.getElementById('edit_condition_badge').value = item.condition_badge;
            document.getElementById('edit_price').value = item.price;
            document.getElementById('edit_old_price').value = item.old_price || '';
            document.getElementById('edit_stock').value = item.stock || 0;
            document.getElementById('edit_spec').value = item.spec || '';
            document.getElementById('edit_description').value = item.description || '';
            
            document.getElementById('editModal').style.display = 'block';
        }
        function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }
    </script>
</x-app-layout>
