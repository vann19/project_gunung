<x-app-layout>
    <x-slot name="header">
        Manajemen Katalog Rental Alat
    </x-slot>

    <div class="space-y-8 max-w-7xl mx-auto" x-data="rentalAdminData()">

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

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs mb-4">
                <ul class="list-disc list-inside text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header Bar & Tombol Tambah --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Peralatan Rental</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola inventaris, harga sewa, kategori, dan kondisi barang (Baru / Second).</p>
            </div>
            <button onclick="openCreateModal()"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white font-semibold text-sm shadow-md shadow-primary/20 transition active:scale-95 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Alat Rental</span>
            </button>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider font-['JetBrains_Mono']">Total Inventaris</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800">{{ $totalItems }}</span>
                    <span class="text-xs text-slate-500 font-medium">Unit</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider font-['JetBrains_Mono'] flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Kondisi Baru
                </span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800">{{ $baruCount }}</span>
                    <span class="text-xs text-slate-500 font-medium">Alat</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-semibold text-amber-600 uppercase tracking-wider font-['JetBrains_Mono'] flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span> Kondisi Second
                </span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800">{{ $secondCount }}</span>
                    <span class="text-xs text-slate-500 font-medium">Alat</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider font-['JetBrains_Mono'] flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg> Tersembunyi
                </span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800">{{ $hiddenCount }}</span>
                    <span class="text-xs text-slate-500 font-medium">Alat</span>
                </div>
            </div>
           
        </div>


        {{-- Filter & Table Container --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            
            {{-- Filter Bar --}}
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row gap-4 justify-between items-center">
                <form method="GET" action="{{ route('admin.rentals.index') }}" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <div class="relative">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau deskripsi..."
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
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select name="condition_badge" onchange="this.form.submit()" class="appearance-none py-2 pl-4 pr-10 bg-white border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-700 w-full sm:w-auto">
                            <option value="all" {{ request('condition_badge') == 'all' || !request('condition_badge') ? 'selected' : '' }}>Semua Kondisi</option>
                            <option value="Baru" {{ request('condition_badge') == 'Baru' ? 'selected' : '' }}>Kondisi Baru</option>
                            <option value="Second" {{ request('condition_badge') == 'Second' ? 'selected' : '' }}>Kondisi Second</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </form>

                @if(request('search') || (request('category') && request('category') != 'all') || (request('condition_badge') && request('condition_badge') != 'all'))
                    <a href="{{ route('admin.rentals.index') }}" class="text-xs font-semibold text-rose-500 hover:underline">Reset Filter</a>
                @endif
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 text-xs uppercase font-['JetBrains_Mono'] border-b border-slate-100">
                        <tr>
                            <th class="py-4 px-6 font-semibold">Peralatan</th>
                            <th class="py-4 px-4 font-semibold">Kategori</th>
                            <th class="py-4 px-4 font-semibold">Kondisi</th>
                            <th class="py-4 px-4 font-semibold">Harga / Hari</th>
                            <th class="py-4 px-4 font-semibold text-center">Stok</th>
                            <th class="py-4 px-4 font-semibold text-center">Visibilitas</th>
                            <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($equipments as $item)
                            <tr class="hover:bg-slate-50/70 transition {{ !$item->is_visible ? 'opacity-70 bg-slate-50/50 grayscale-[30%]' : '' }}">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                            @if($item->main_image)
                                                <img src="{{ $item->main_image }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-xs text-slate-400">No img</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800">{{ $item->title }}</p>
                                            <p class="text-xs text-slate-400 max-w-xs truncate">{{ $item->description }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-['JetBrains_Mono'] font-medium bg-slate-100 text-slate-700 capitalize">
                                        {{ $item->category }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    @if($item->condition_badge === 'Baru')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Baru
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/80 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Second
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-800 font-['JetBrains_Mono']">
                                    {{ $item->price }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if($item->total_stock <= 0)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Habis
                                        </span>
                                    @elseif($item->total_stock <= 2)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> {{ $item->total_stock }} unit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $item->total_stock }} unit
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center space-y-1.5">
                                    @if($item->is_visible)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-[10px] font-bold border border-blue-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> Publik
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-bold border border-slate-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg> Hidden
                                        </span>
                                    @endif
                                    
                                    @if($item->is_popular)
                                        <span class="inline-block px-2 py-0.5 rounded bg-amber-100 text-amber-800 text-[10px] font-bold">★ Populer</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Tombol Toggle Visibility --}}
                                        <form method="POST" action="{{ route('admin.rentals.toggle-visible', $item) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition"
                                                    title="{{ $item->is_visible ? 'Sembunyikan dari Publik' : 'Tampilkan ke Publik' }}">
                                                @if($item->is_visible)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                @endif
                                            </button>
                                        </form>

                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                                onclick='openEditModal(@json($item))'
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-primary hover:bg-primary/10 transition"
                                                title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>

                                        {{-- Form Hapus --}}
                                        <form method="POST" action="{{ route('admin.rentals.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat rental ini?');">
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
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    Belum ada data peralatan rental yang sesuai. Klik tombol "+ Tambah Alat Rental" untuk memulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL TAMBAH ALAT RENTAL --}}
        <div id="createModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-950/60 backdrop-blur-xs" onclick="closeCreateModal()"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative z-50 inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl sm:align-middle border border-slate-200">
                    
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Tambah Peralatan Rental</h3>
                        <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.rentals.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Judul Peralatan <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" required placeholder="cth: Tenda Dome 4P Eiger"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </div>

                        <!-- Removed Foto Utama and Galeri Foto Tambahan from Create Form -->

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
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Harga / Hari <span class="text-rose-500">*</span></label>
                                <input type="text" name="price" required placeholder="cth: Rp 45k"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <!-- Removed Jumlah Stok from Create -->

                        {{-- Varian Produk --}}
                        <div x-data="{ variants: [] }">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Kombinasi Varian Produk</label>
                                <button type="button" @click="variants.push({name:'', sku:'', stock:1, price_override:'', specifications: [{label: 'Merek', value: ''}, {label: 'Berat', value: ''}]})" class="text-xs px-2.5 py-1 bg-white border border-slate-200 rounded-lg font-semibold text-primary hover:bg-primary hover:text-white transition">+ Tambah Varian</button>
                            </div>
                            <p class="text-[10px] text-slate-400 mb-2">Isi warna, ukuran, foto varian (opsional). Kombinasi ini memiliki stok sendiri.</p>
                            <div class="space-y-2 max-h-60 overflow-y-auto">
                                <template x-for="(v, i) in variants" :key="i">
                                    <div class="flex items-start gap-2 bg-slate-50 rounded-xl border border-slate-200 px-3 py-2 flex-wrap relative">
                                        <div class="flex items-center gap-2 w-full">
                                            <span class="text-xs text-slate-400 font-mono w-4 mt-2" x-text="i+1+'.'"></span>
                                            
                                            <div class="col-span-5">
                                                <input type="text" :name="`variants[${i}][name]`" x-model="v.name" placeholder="Cth: Tenda Arai 4P" class="w-full px-3 py-2 bg-white rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary focus:outline-hidden transition-all">
                                            </div>
                                            <div class="col-span-4">
                                                <input type="text" :name="`variants[${i}][sku]`" x-model="v.sku" placeholder="SKU Varian (Opsional)" class="w-full px-3 py-2 bg-white rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary focus:outline-hidden transition-all">
                                            </div>
                                            
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs text-slate-400">Stok:</span>
                                                <input type="number" :name="`variants[${i}][stock]`" x-model="v.stock" min="0" class="w-16 px-2 py-1.5 bg-white rounded-lg border border-slate-200 text-xs text-center focus:ring-1 focus:ring-primary focus:outline-hidden">
                                            </div>
                                            
                                            <button type="button" @click="variants.splice(i,1)" class="text-slate-300 hover:text-rose-500 transition ml-2">&times;</button>
                                        </div>
                                        <div class="w-full pl-6 mt-2 flex items-center gap-2">
                                            <label class="text-[10px] text-slate-400 font-semibold uppercase">Foto Varian (Opsional):</label>
                                            <input type="file" :name="`variants[${i}][image_file]`" accept="image/*" class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                                        </div>
                                        
                                        <div class="w-full mt-3 pl-6">
                                            <div class="p-3 bg-white rounded-xl border border-slate-200/60">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                                        <label class="text-[11px] font-bold text-slate-600">Spesifikasi Khusus Varian</label>
                                                    </div>
                                                    <button type="button" @click="v.specifications.push({label: '', value: ''})" class="text-[10px] px-2 py-1 bg-white border border-slate-200 rounded-lg font-semibold text-slate-600 hover:text-primary hover:border-primary transition">+ Tambah Baris</button>
                                                </div>
                                                <div class="space-y-1.5">
                                                    <template x-for="(spec, sIndex) in v.specifications" :key="sIndex">
                                                        <div class="flex gap-2 items-center">
                                                            <input type="text" :name="`variants[${i}][specifications][${sIndex}][label]`" x-model="spec.label" placeholder="Cth: Merek" class="w-1/3 px-2.5 py-1.5 bg-slate-50 rounded-lg border border-slate-200 text-[11px] focus:ring-1 focus:ring-primary focus:outline-hidden">
                                                            <input type="text" :name="`variants[${i}][specifications][${sIndex}][value]`" x-model="spec.value" placeholder="Cth: Arai" class="flex-1 px-2.5 py-1.5 bg-slate-50 rounded-lg border border-slate-200 text-[11px] focus:ring-1 focus:ring-primary focus:outline-hidden">
                                                            <button type="button" @click="v.specifications.splice(sIndex, 1)" class="text-slate-300 hover:text-rose-500">&times;</button>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <p x-show="variants.length === 0" class="text-xs text-slate-300 italic py-2 text-center">Belum ada varian ditambahkan. Produk akan menggunakan stok utama.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Badge Kondisi <span class="text-rose-500">*</span></label>
                                <select name="condition_badge" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary font-semibold">
                                    <option value="Baru" class="text-emerald-600">Baru (Kondisi Baru)</option>
                                    <option value="Second" class="text-amber-600">Second (Terawat)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap / Detail Produk</label>
                            <textarea name="description" rows="4" placeholder="Jelaskan kapasitas, bahan, atau deskripsi mendetail produk rental ini..."
                                      class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                        </div>

                        

                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" name="is_popular" id="create_popular" class="rounded border-slate-300 text-primary focus:ring-primary">
                            <label for="create_popular" class="text-sm text-slate-700 font-medium">Tandai sebagai Barang Populer / Rekomendasi</label>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeCreateModal()"
                                    class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">
                                Simpan Alat Rental
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- MODAL EDIT ALAT RENTAL --}}
        <div id="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-950/60 backdrop-blur-xs" onclick="closeEditModal()"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative z-50 inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl sm:align-middle border border-slate-200">
                    
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Edit Peralatan Rental</h3>
                        <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form id="editForm" method="POST" action="" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Judul Peralatan <span class="text-rose-500">*</span></label>
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
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Harga / Hari <span class="text-rose-500">*</span></label>
                                <input type="text" name="price" id="edit_price" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <!-- Removed Jumlah Stok from Edit -->

                        {{-- Varian Produk (Edit) --}}
                        <div x-data="{ variants: [] }" @load-variants.window="variants = $event.detail">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Kombinasi Varian Produk</label>
                                <button type="button" @click="variants.push({name:'', sku:'', stock:1, image:'', specifications: [{label: 'Merek', value: ''}, {label: 'Berat', value: ''}]})" class="text-xs px-2.5 py-1 bg-white border border-slate-200 rounded-lg font-semibold text-primary hover:bg-primary hover:text-white transition">+ Tambah Varian</button>
                            </div>
                            <p class="text-[10px] text-slate-400 mb-2">Edit atau tambahkan varian beserta stok spesifiknya. Foto varian bersifat opsional.</p>
                            <div class="space-y-2 max-h-60 overflow-y-auto">
                                <template x-for="(v, i) in variants" :key="i">
                                    <div class="flex items-start gap-2 bg-slate-50 rounded-xl border border-slate-200 px-3 py-2 flex-wrap relative">
                                        <div class="flex items-center gap-2 w-full">
                                            <span class="text-xs text-slate-400 font-mono w-4 mt-2" x-text="i+1+'.'"></span>
                                            
                                            <input type="hidden" :name="`variants[${i}][id]`" :value="v.id || ''">
                                            
                                            <input type="text" :name="`variants[${i}][name]`" x-model="v.name" placeholder="Nama Varian" class="flex-grow px-2.5 py-1.5 bg-white rounded-lg border border-slate-200 text-xs focus:ring-1 focus:ring-primary focus:outline-hidden">
                                            
                                            <input type="text" :name="`variants[${i}][sku]`" x-model="v.sku" placeholder="SKU" class="w-20 px-2.5 py-1.5 bg-white rounded-lg border border-slate-200 text-xs focus:ring-1 focus:ring-primary focus:outline-hidden">
                                            
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs text-slate-400">Stok:</span>
                                                <input type="number" :name="`variants[${i}][stock]`" x-model="v.stock" min="0" class="w-16 px-2 py-1.5 bg-white rounded-lg border border-slate-200 text-xs text-center focus:ring-1 focus:ring-primary focus:outline-hidden">
                                            </div>
                                            
                                            <button type="button" @click="variants.splice(i,1)" class="text-slate-300 hover:text-rose-500 transition ml-2">&times;</button>
                                        </div>
                                        <div class="w-full pl-6 mt-2 flex items-center gap-2">
                                            <template x-if="v.image">
                                                <img :src="v.image.startsWith('/') ? v.image : '/'+v.image" class="w-8 h-8 rounded border object-cover">
                                            </template>
                                            <input type="hidden" :name="`variants[${i}][existing_image]`" :value="v.image">
                                            <label class="text-[10px] text-slate-400 font-semibold uppercase ml-2">Foto Varian:</label>
                                            <input type="file" :name="`variants[${i}][image_file]`" accept="image/*" class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                                        </div>

                                        <div class="w-full mt-3 pl-6">
                                            <div class="p-3 bg-white rounded-xl border border-slate-200/60">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                                        <label class="text-[11px] font-bold text-slate-600">Spesifikasi Khusus Varian</label>
                                                    </div>
                                                    <button type="button" @click="v.specifications.push({label: '', value: ''})" class="text-[10px] px-2 py-1 bg-white border border-slate-200 rounded-lg font-semibold text-slate-600 hover:text-primary hover:border-primary transition">+ Tambah Baris</button>
                                                </div>
                                                <div class="space-y-1.5">
                                                    <template x-for="(spec, sIndex) in v.specifications" :key="sIndex">
                                                        <div class="flex gap-2 items-center">
                                                            <input type="text" :name="`variants[${i}][specifications][${sIndex}][label]`" x-model="spec.label" placeholder="Cth: Merek" class="w-1/3 px-2.5 py-1.5 bg-slate-50 rounded-lg border border-slate-200 text-[11px] focus:ring-1 focus:ring-primary focus:outline-hidden">
                                                            <input type="text" :name="`variants[${i}][specifications][${sIndex}][value]`" x-model="spec.value" placeholder="Cth: Arai" class="flex-1 px-2.5 py-1.5 bg-slate-50 rounded-lg border border-slate-200 text-[11px] focus:ring-1 focus:ring-primary focus:outline-hidden">
                                                            <button type="button" @click="v.specifications.splice(sIndex, 1)" class="text-slate-300 hover:text-rose-500">&times;</button>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <p x-show="variants.length === 0" class="text-xs text-slate-300 italic py-2 text-center">Belum ada varian ditambahkan.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Badge Kondisi <span class="text-rose-500">*</span></label>
                                <select name="condition_badge" id="edit_condition_badge" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary font-semibold">
                                    <option value="Baru" class="text-emerald-600">Baru (Kondisi Baru)</option>
                                    <option value="Second" class="text-amber-600">Second (Terawat)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap / Detail Produk</label>
                            <textarea name="description" id="edit_description" rows="4"
                                      class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                        </div>



                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" name="is_popular" id="edit_popular" class="rounded border-slate-300 text-primary focus:ring-primary">
                            <label for="edit_popular" class="text-sm text-slate-700 font-medium">Tandai sebagai Barang Populer / Rekomendasi</label>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeEditModal()"
                                    class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">
                                Perbarui Alat
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

    {{-- MODAL JUAL KE MARKETPLACE --}}
    <div x-show="sellModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="sellModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-950/80 backdrop-blur-xs" @click="sellModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="sellModalOpen" x-transition.scale class="relative z-50 inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl sm:align-middle border border-slate-200">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider block">Pindah ke Marketplace</span>
                        <h3 class="text-lg font-bold text-slate-800 font-['Hanken_Grotesk']">Jual <span x-text="sellItem ? sellItem.title : ''"></span></h3>
                    </div>
                    <button type="button" @click="sellModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="sellItem ? `/admin/rentals/${sellItem.id}/sell` : ''" method="POST" class="mt-4 space-y-4">
                    @csrf
                    
                    {{-- Alert Info --}}
                    <div class="p-3 bg-amber-50 text-amber-800 rounded-xl text-xs border border-amber-200/60 leading-relaxed">
                        <span class="font-bold">Info:</span> Stok yang dijual akan dikurangi otomatis dari jumlah persediaan di sistem rental dan dipindahkan ke Marketplace.
                    </div>

                    {{-- Varian --}}
                    <div x-show="sellItem && sellItem.variants && sellItem.variants.length > 0">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">Pilih Varian Produk</label>
                        <select name="variant_id" x-model="sellVariantId" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            <option value="" disabled>-- Pilih Kombinasi Varian --</option>
                            <template x-for="v in (sellItem ? sellItem.variants : [])" :key="v.id">
                                <option :value="v.id" x-text="v.name + ' (Stok: ' + v.stock + ')'" :disabled="v.stock <= 0"></option>
                            </template>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Jumlah --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">Jumlah Jual (Stok)</label>
                            <input type="number" name="qty" required min="1" :max="getMaxStock()" value="1"
                                   class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            <span class="text-[10px] text-slate-400 mt-1 block">Max stok: <span x-text="getMaxStock()"></span></span>
                        </div>
                        {{-- Harga Jual --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">Harga Jual (Rp)</label>
                            <input type="text" name="price" required placeholder="Contoh: 150.000"
                                   class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </div>
                    </div>

                    {{-- Kategori & Kondisi --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">Kategori Marketplace</label>
                            <select name="marketplace_category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
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
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 font-['JetBrains_Mono']">Kondisi Barang</label>
                            <select name="condition_badge" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                <option value="Baru">Baru</option>
                                <option value="Bekas" selected>Bekas</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                        <button type="button" @click="sellModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold shadow-md shadow-amber-500/20 transition">Proses Jual</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        window.rentalItems = @json($equipments);

        document.addEventListener('alpine:init', () => {
            Alpine.data('rentalAdminData', () => ({
                sellModalOpen: false,
                sellItem: null,
                sellVariantId: '',
                
                openSellModal(itemId) {
                    this.sellItem = window.rentalItems.find(i => i.id === itemId);
                    this.sellVariantId = '';
                    this.sellModalOpen = true;
                },
                getMaxStock() {
                    if (!this.sellItem) return 0;
                    if (this.sellItem.variants && this.sellItem.variants.length > 0) {
                        if (!this.sellVariantId) return 0;
                        const v = this.sellItem.variants.find(v => v.id == this.sellVariantId);
                        return v ? v.stock : 0;
                    }
                    return this.sellItem.stock || 0;
                }
            }));
        });
        function openCreateModal() {
            document.getElementById('createModal').style.display = 'block';
        }

        function closeCreateModal() {
            document.getElementById('createModal').style.display = 'none';
        }

        function openEditModal(item) {
            document.getElementById('editForm').action = `/admin/rentals/${item.id}`;
            document.getElementById('edit_title').value = item.title;
            document.getElementById('edit_category').value = item.category;
            document.getElementById('edit_price').value = item.price;
            document.getElementById('edit_condition_badge').value = item.condition_badge || 'Baru';
            document.getElementById('edit_description').value = item.description || '';
            document.getElementById('edit_popular').checked = (item.is_popular == 1 || item.is_popular === true);
            
            // Load variants
            let variants = item.variants || [];
            
            // Dispatch event to load variants for Alpine component
            window.dispatchEvent(new CustomEvent('load-variants', { 
                detail: variants.map(v => ({
                    ...v,
                    specifications: v.specifications || [{label: 'Merek', value: ''}, {label: 'Berat', value: ''}]
                })) 
            }));


            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</x-app-layout>
