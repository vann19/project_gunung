<x-app-layout>
    <x-slot name="header">
        Manajemen Info Gunung
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
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Info Gunung</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data gunung, jalur, serta pos-pos pendakian.</p>
            </div>
            <button onclick="openCreateModal()"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white font-semibold text-sm shadow-md shadow-primary/20 transition active:scale-95 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Info Gunung</span>
            </button>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider font-['JetBrains_Mono']">Total Gunung</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800">{{ $totalItems }}</span>
                    <span class="text-xs text-slate-500 font-medium">Gunung</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider font-['JetBrains_Mono'] flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg> Tersembunyi
                </span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800">{{ $hiddenCount }}</span>
                    <span class="text-xs text-slate-500 font-medium">Gunung</span>
                </div>
            </div>
        </div>

        {{-- Filter & Table Container --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            
            {{-- Filter Bar --}}
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row gap-4 justify-between items-center">
                <form method="GET" action="{{ route('admin.mountains.index') }}" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <div class="relative">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari gunung..."
                               class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary w-full sm:w-64">
                    </div>
                </form>

                @if(request('search'))
                    <a href="{{ route('admin.mountains.index') }}" class="text-xs font-semibold text-rose-500 hover:underline">Reset Filter</a>
                @endif
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 text-xs uppercase font-['JetBrains_Mono'] border-b border-slate-100">
                        <tr>
                            <th class="py-4 px-6 font-semibold">Nama Gunung</th>
                            <th class="py-4 px-4 font-semibold">Lokasi</th>
                            <th class="py-4 px-4 font-semibold">Ketinggian</th>
                            <th class="py-4 px-4 font-semibold text-center">Jalur Terdaftar</th>
                            <th class="py-4 px-4 font-semibold text-center">Visibilitas</th>
                            <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($mountains as $item)
                            <tr class="hover:bg-slate-50/70 transition {{ !$item->is_visible ? 'opacity-70 bg-slate-50/50 grayscale-[30%]' : '' }}">
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
                                            <p class="font-bold text-slate-800">{{ $item->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">{{ $item->location ?? '-' }}</td>
                                <td class="py-4 px-4 font-bold text-slate-800 font-['JetBrains_Mono']">
                                    {{ $item->elevation ?? '-' }}
                                </td>
                                <td class="py-4 px-4 text-center font-bold text-slate-800">
                                    {{ $item->routes_count }}
                                </td>
                                <td class="py-4 px-4 text-center space-y-1.5">
                                    @if($item->is_visible)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-[10px] font-bold border border-blue-200">
                                            Publik
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-bold border border-slate-200">
                                            Hidden
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Tombol Toggle Visibility --}}
                                        <form method="POST" action="{{ route('admin.mountains.toggle-visible', $item) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition"
                                                    title="{{ $item->is_visible ? 'Sembunyikan' : 'Tampilkan' }}">
                                                @if($item->is_visible)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                @endif
                                            </button>
                                        </form>

                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                                onclick='openEditModal(@json($item->load("routes")))'
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-primary hover:bg-primary/10 transition"
                                                title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>

                                        {{-- Form Hapus --}}
                                        <form method="POST" action="{{ route('admin.mountains.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data gunung ini beserta semua jalur?');">
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
                                    Belum ada data gunung.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL TAMBAH GUNUNG --}}
        <div id="createModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-950/60 backdrop-blur-xs" onclick="closeCreateModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative z-50 inline-block w-full max-w-4xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl sm:align-middle border border-slate-200">
                    
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Tambah Data Gunung</h3>
                        <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.mountains.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Gunung <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" required placeholder="cth: Gunung Merbabu" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Ketinggian <span class="text-rose-500">*</span></label>
                                <input type="text" name="elevation" required placeholder="cth: 3142 mdpl" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Lokasi (Provinsi/Kota)</label>
                                <input type="text" name="location" placeholder="cth: Jawa Tengah" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Unggah Foto Gunung</label>
                                <input type="file" name="image" accept="image/*" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi / Info Singkat</label>
                            <textarea name="description" rows="3" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" name="is_visible" id="create_visible" checked class="rounded border-slate-300 text-primary focus:ring-primary">
                            <label for="create_visible" class="text-sm text-slate-700 font-medium">Tampilkan ke Publik</label>
                        </div>

                        {{-- Section Jalur & Pos Alpine.js --}}
                        <div x-data="mountainRoutesData()" class="mt-6 border-t border-slate-200 pt-4">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h4 class="font-bold text-slate-800">Daftar Jalur & Pos Pendakian</h4>
                                    <p class="text-[10px] text-slate-500">Kelola info rute seperti Basecamp dan Pos-pos yang akan dilalui pendaki.</p>
                                </div>
                                <button type="button" @click="addRoute()" class="px-3 py-1.5 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-lg text-xs font-bold transition">
                                    + Tambah Jalur
                                </button>
                            </div>

                            <div class="space-y-6 max-h-[50vh] overflow-y-auto pr-2">
                                <template x-for="(route, rIndex) in routes" :key="rIndex">
                                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                        <div class="flex justify-between items-start gap-4 mb-3">
                                            <div class="flex-1 grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Nama Jalur (via)</label>
                                                    <input type="text" :name="`routes[${rIndex}][name]`" x-model="route.name" placeholder="cth: Via Selo" class="w-full px-3 py-1.5 text-sm rounded border border-slate-200">
                                                </div>
                                                <div>
                                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Info Basecamp</label>
                                                    <input type="text" :name="`routes[${rIndex}][basecamp_info]`" x-model="route.basecamp_info" placeholder="Alamat / Kontak" class="w-full px-3 py-1.5 text-sm rounded border border-slate-200">
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Deskripsi Jalur</label>
                                                    <input type="text" :name="`routes[${rIndex}][description]`" x-model="route.description" placeholder="Info singkat jalur..." class="w-full px-3 py-1.5 text-sm rounded border border-slate-200">
                                                </div>
                                            </div>
                                            <button type="button" @click="removeRoute(rIndex)" class="p-1.5 text-slate-400 hover:text-rose-500 rounded bg-white border border-slate-200 shadow-2xs">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>

                                        {{-- Pos-pos di Jalur --}}
                                        <div class="mt-3 pl-3 border-l-2 border-slate-200">
                                            <div class="flex items-center justify-between mb-2">
                                                <h5 class="text-xs font-bold text-slate-700">Daftar Pos</h5>
                                                <button type="button" @click="addPost(rIndex)" class="text-[10px] font-bold text-primary hover:underline">
                                                    + Tambah Pos
                                                </button>
                                            </div>
                                            <div class="space-y-2">
                                                <template x-for="(post, pIndex) in route.posts" :key="pIndex">
                                                    <div class="flex items-center gap-2">
                                                        <input type="text" :name="`routes[${rIndex}][posts][${pIndex}][name]`" x-model="post.name" placeholder="Nama Pos" class="w-1/3 px-2 py-1 text-xs rounded border border-slate-200">
                                                        <input type="text" :name="`routes[${rIndex}][posts][${pIndex}][estimasi]`" x-model="post.estimasi" placeholder="Estimasi Waktu" class="w-1/4 px-2 py-1 text-xs rounded border border-slate-200">
                                                        <input type="text" :name="`routes[${rIndex}][posts][${pIndex}][keterangan]`" x-model="post.keterangan" placeholder="Keterangan (Air/Camp)" class="flex-1 px-2 py-1 text-xs rounded border border-slate-200">
                                                        <button type="button" @click="removePost(rIndex, pIndex)" class="text-rose-400 hover:text-rose-600">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeCreateModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{-- MODAL EDIT GUNUNG --}}
        <div id="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-950/60 backdrop-blur-xs" onclick="closeEditModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative z-50 inline-block w-full max-w-4xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl sm:align-middle border border-slate-200">
                    
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Edit Data Gunung</h3>
                        <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form id="editForm" method="POST" action="" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Gunung <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" id="edit_name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Ketinggian <span class="text-rose-500">*</span></label>
                                <input type="text" name="elevation" id="edit_elevation" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Lokasi (Provinsi/Kota)</label>
                                <input type="text" name="location" id="edit_location" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Update Foto (Opsional)</label>
                                <input type="file" name="image" accept="image/*" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi / Info Singkat</label>
                            <textarea name="description" id="edit_description" rows="3" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" name="is_visible" id="edit_visible" class="rounded border-slate-300 text-primary focus:ring-primary">
                            <label for="edit_visible" class="text-sm text-slate-700 font-medium">Tampilkan ke Publik</label>
                        </div>

                        {{-- Section Jalur & Pos Alpine.js --}}
                        <div x-data="mountainRoutesDataEdit()" @load-mountain-routes.window="loadRoutes($event.detail)" class="mt-6 border-t border-slate-200 pt-4">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h4 class="font-bold text-slate-800">Daftar Jalur & Pos Pendakian</h4>
                                </div>
                                <button type="button" @click="addRoute()" class="px-3 py-1.5 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-lg text-xs font-bold transition">
                                    + Tambah Jalur
                                </button>
                            </div>

                            <div class="space-y-6 max-h-[50vh] overflow-y-auto pr-2">
                                <template x-for="(route, rIndex) in routes" :key="rIndex">
                                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                        <div class="flex justify-between items-start gap-4 mb-3">
                                            <div class="flex-1 grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Nama Jalur (via)</label>
                                                    <input type="text" :name="`routes[${rIndex}][name]`" x-model="route.name" class="w-full px-3 py-1.5 text-sm rounded border border-slate-200">
                                                </div>
                                                <div>
                                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Info Basecamp</label>
                                                    <input type="text" :name="`routes[${rIndex}][basecamp_info]`" x-model="route.basecamp_info" class="w-full px-3 py-1.5 text-sm rounded border border-slate-200">
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Deskripsi Jalur</label>
                                                    <input type="text" :name="`routes[${rIndex}][description]`" x-model="route.description" class="w-full px-3 py-1.5 text-sm rounded border border-slate-200">
                                                </div>
                                            </div>
                                            <button type="button" @click="removeRoute(rIndex)" class="p-1.5 text-slate-400 hover:text-rose-500 rounded bg-white border border-slate-200 shadow-2xs">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>

                                        {{-- Pos-pos di Jalur --}}
                                        <div class="mt-3 pl-3 border-l-2 border-slate-200">
                                            <div class="flex items-center justify-between mb-2">
                                                <h5 class="text-xs font-bold text-slate-700">Daftar Pos</h5>
                                                <button type="button" @click="addPost(rIndex)" class="text-[10px] font-bold text-primary hover:underline">
                                                    + Tambah Pos
                                                </button>
                                            </div>
                                            <div class="space-y-2">
                                                <template x-for="(post, pIndex) in route.posts" :key="pIndex">
                                                    <div class="flex items-center gap-2">
                                                        <input type="text" :name="`routes[${rIndex}][posts][${pIndex}][name]`" x-model="post.name" placeholder="Nama Pos" class="w-1/3 px-2 py-1 text-xs rounded border border-slate-200">
                                                        <input type="text" :name="`routes[${rIndex}][posts][${pIndex}][estimasi]`" x-model="post.estimasi" placeholder="Estimasi Waktu" class="w-1/4 px-2 py-1 text-xs rounded border border-slate-200">
                                                        <input type="text" :name="`routes[${rIndex}][posts][${pIndex}][keterangan]`" x-model="post.keterangan" placeholder="Keterangan (Air/Camp)" class="flex-1 px-2 py-1 text-xs rounded border border-slate-200">
                                                        <button type="button" @click="removePost(rIndex, pIndex)" class="text-rose-400 hover:text-rose-600">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">Perbarui Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('mountainRoutesData', () => ({
                routes: [],
                addRoute() {
                    this.routes.push({
                        name: '', basecamp_info: '', description: '', posts: []
                    });
                },
                removeRoute(index) {
                    this.routes.splice(index, 1);
                },
                addPost(routeIndex) {
                    this.routes[routeIndex].posts.push({
                        name: '', estimasi: '', keterangan: ''
                    });
                },
                removePost(routeIndex, postIndex) {
                    this.routes[routeIndex].posts.splice(postIndex, 1);
                }
            }));

            Alpine.data('mountainRoutesDataEdit', () => ({
                routes: [],
                loadRoutes(data) {
                    this.routes = data || [];
                },
                addRoute() {
                    this.routes.push({
                        name: '', basecamp_info: '', description: '', posts: []
                    });
                },
                removeRoute(index) {
                    this.routes.splice(index, 1);
                },
                addPost(routeIndex) {
                    if(!this.routes[routeIndex].posts) {
                        this.routes[routeIndex].posts = [];
                    }
                    this.routes[routeIndex].posts.push({
                        name: '', estimasi: '', keterangan: ''
                    });
                },
                removePost(routeIndex, postIndex) {
                    this.routes[routeIndex].posts.splice(postIndex, 1);
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
            document.getElementById('editForm').action = '/admin/mountains/' + item.id;
            document.getElementById('edit_name').value = item.name;
            document.getElementById('edit_elevation').value = item.elevation || '';
            document.getElementById('edit_location').value = item.location || '';
            document.getElementById('edit_description').value = item.description || '';
            document.getElementById('edit_visible').checked = (item.is_visible == 1 || item.is_visible === true);
            
            let loadedRoutes = [];
            if(item.routes && item.routes.length > 0) {
                loadedRoutes = item.routes.map(r => {
                    let posts = r.posts || [];
                    if (typeof posts === 'string') {
                        try { posts = JSON.parse(posts); } catch(e) { posts = []; }
                    }
                    return {
                        name: r.name,
                        basecamp_info: r.basecamp_info,
                        description: r.description,
                        posts: posts
                    };
                });
            }

            window.dispatchEvent(new CustomEvent('load-mountain-routes', { detail: loadedRoutes }));

            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</x-app-layout>
