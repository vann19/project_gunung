<x-app-layout>
    <x-slot name="header">
        Pendaki Bergabung
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

        {{-- Header Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Pendaki yang Bergabung</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola daftar foto & card pendaki yang tampil di halaman Open Trip.</p>
            </div>
            <button onclick="openCreateModal()"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white font-semibold text-sm shadow-md shadow-primary/20 transition active:scale-95 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Pendaki</span>
            </button>
        </div>

        {{-- Stats --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider font-['JetBrains_Mono']">Total Pendaki Terdaftar</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800">{{ $total }}</span>
                <span class="text-xs text-slate-500 font-medium">Pendaki</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row gap-4 justify-between items-center">
                <form method="GET" action="{{ route('admin.pendaki-bergabung.index') }}" class="flex gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-64">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / trip..."
                               class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary w-full">
                    </div>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-primary/10 text-primary text-sm font-semibold hover:bg-primary/20 transition">Cari</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 text-xs uppercase font-['JetBrains_Mono'] border-b border-slate-100">
                        <tr>
                            <th class="py-4 px-6 font-semibold">Pendaki</th>
                            <th class="py-4 px-4 font-semibold">Trip</th>
                            <th class="py-4 px-4 font-semibold">Foto</th>
                            <th class="py-4 px-4 font-semibold">Warna</th>
                            <th class="py-4 px-4 font-semibold text-center">Urutan</th>
                            <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pendakis as $item)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-base shrink-0 overflow-hidden {{ $item->bg_class }} {{ $item->text_class }}">
                                            @if($item->foto_url)
                                                <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}" class="w-10 h-10 object-cover rounded-full">
                                            @else
                                                {{ $item->initial_display }}
                                            @endif
                                        </div>
                                        <span class="font-semibold text-slate-800">{{ $item->nama }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-primary font-bold text-xs uppercase tracking-wide">{{ $item->trip }}</td>
                                <td class="py-4 px-4">
                                    @if($item->foto_url)
                                        <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded-full">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            Ada Foto
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">— Inisial</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full {{ $item->bg_class }} {{ $item->text_class }} flex items-center justify-center text-xs font-bold shrink-0">
                                            {{ $item->initial_display }}
                                        </div>
                                        <span class="text-[10px] text-slate-400 font-['JetBrains_Mono'] truncate max-w-[120px]">{{ $item->bg_class }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center font-['JetBrains_Mono'] font-bold text-slate-700">{{ $item->urutan }}</td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                                onclick='openEditModal(@json($item))'
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-primary hover:bg-primary/10 transition"
                                                title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <form method="POST" action="{{ route('admin.pendaki-bergabung.destroy', $item) }}" onsubmit="return confirm('Hapus pendaki ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    Belum ada pendaki. Klik tombol "+ Tambah Pendaki" untuk memulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL TAMBAH --}}
        <div id="createModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-950/60 backdrop-blur-xs" onclick="closeCreateModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative z-50 inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl sm:align-middle border border-slate-200">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Tambah Pendaki</h3>
                        <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.pendaki-bergabung.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Pendaki <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama" required placeholder="cth: Andi Wijaya"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Trip <span class="text-rose-500">*</span></label>
                                <input type="text" name="trip" required placeholder="cth: Semeru"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Inisial (opsional)</label>
                                <input type="text" name="initial" maxlength="5" placeholder="cth: A (auto dari nama)"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                <p class="text-[10px] text-slate-400 mt-1">Kosongkan = otomatis dari nama</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Urutan Tampil</label>
                                <input type="number" name="urutan" min="0" value="0"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Foto Pendaki (opsional)</label>
                            <input type="file" name="foto" accept="image/jpeg,image/jpg,image/png,image/webp"
                                   class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary/10 file:text-primary file:font-semibold hover:file:bg-primary/20 file:cursor-pointer">
                            <p class="text-[10px] text-slate-400 mt-1">JPG/PNG/WEBP, maks 2MB. Jika kosong, tampil inisial.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Warna Background Avatar <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-2 gap-2" id="create_bg_options">
                                @foreach([
                                    ['bg' => 'bg-primary', 'text' => 'text-white', 'label' => 'Hijau (Primary)'],
                                    ['bg' => 'bg-secondary-400', 'text' => 'text-surface-dark', 'label' => 'Kuning'],
                                    ['bg' => 'bg-gray-500', 'text' => 'text-white', 'label' => 'Abu Tua'],
                                    ['bg' => 'bg-gray-100 border border-gray-200', 'text' => 'text-gray-500', 'label' => 'Abu Muda'],
                                    ['bg' => 'bg-surface-dark', 'text' => 'text-white', 'label' => 'Hitam'],
                                    ['bg' => 'bg-secondary-600', 'text' => 'text-white', 'label' => 'Kuning Tua'],
                                ] as $opt)
                                    <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg border border-slate-200 hover:border-primary/40 transition has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                        <input type="radio" name="bg_class" value="{{ $opt['bg'] }}" class="sr-only" {{ $loop->first ? 'checked' : '' }}>
                                        <div class="w-7 h-7 rounded-full {{ $opt['bg'] }} {{ $opt['text'] }} flex items-center justify-center text-xs font-bold shrink-0">A</div>
                                        <div>
                                            <span class="text-xs font-medium text-slate-700 block">{{ $opt['label'] }}</span>
                                            <input type="hidden" name="_text_for_{{ $opt['bg'] }}" value="{{ $opt['text'] }}">
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            {{-- hidden field for text_class, updated by JS --}}
                            <input type="hidden" name="text_class" id="create_text_class" value="text-white">
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeCreateModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT --}}
        <div id="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-950/60 backdrop-blur-xs" onclick="closeEditModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative z-50 inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl sm:align-middle border border-slate-200">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Edit Pendaki</h3>
                        <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form id="editForm" method="POST" action="" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Pendaki <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama" id="edit_nama" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Trip <span class="text-rose-500">*</span></label>
                                <input type="text" name="trip" id="edit_trip" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Inisial (opsional)</label>
                                <input type="text" name="initial" id="edit_initial" maxlength="5"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Urutan Tampil</label>
                                <input type="number" name="urutan" id="edit_urutan" min="0"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>

                        {{-- Preview foto saat ini --}}
                        <div id="edit_foto_preview_wrap" style="display:none;">
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Foto Saat Ini</label>
                            <div class="flex items-center gap-3">
                                <img id="edit_foto_preview" src="" alt="preview" class="w-14 h-14 rounded-full object-cover border border-slate-200">
                                <label class="flex items-center gap-1.5 cursor-pointer text-xs text-rose-600 font-medium">
                                    <input type="checkbox" name="hapus_foto" value="1" id="edit_hapus_foto" class="rounded border-slate-300 text-rose-500 focus:ring-rose-400">
                                    Hapus foto ini
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Ganti Foto (opsional)</label>
                            <input type="file" name="foto" accept="image/jpeg,image/jpg,image/png,image/webp"
                                   class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary/10 file:text-primary file:font-semibold hover:file:bg-primary/20 file:cursor-pointer">
                            <p class="text-[10px] text-slate-400 mt-1">Kosongkan jika tidak ingin mengganti foto.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Warna Background Avatar <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-2 gap-2" id="edit_bg_options">
                                @foreach([
                                    ['bg' => 'bg-primary', 'text' => 'text-white', 'label' => 'Hijau (Primary)'],
                                    ['bg' => 'bg-secondary-400', 'text' => 'text-surface-dark', 'label' => 'Kuning'],
                                    ['bg' => 'bg-gray-500', 'text' => 'text-white', 'label' => 'Abu Tua'],
                                    ['bg' => 'bg-gray-100 border border-gray-200', 'text' => 'text-gray-500', 'label' => 'Abu Muda'],
                                    ['bg' => 'bg-surface-dark', 'text' => 'text-white', 'label' => 'Hitam'],
                                    ['bg' => 'bg-secondary-600', 'text' => 'text-white', 'label' => 'Kuning Tua'],
                                ] as $opt)
                                    <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg border border-slate-200 hover:border-primary/40 transition has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                        <input type="radio" name="bg_class" value="{{ $opt['bg'] }}" data-text="{{ $opt['text'] }}" class="edit-bg-radio sr-only">
                                        <div class="w-7 h-7 rounded-full {{ $opt['bg'] }} {{ $opt['text'] }} flex items-center justify-center text-xs font-bold shrink-0">A</div>
                                        <span class="text-xs font-medium text-slate-700">{{ $opt['label'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <input type="hidden" name="text_class" id="edit_text_class" value="text-white">
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>{{-- end max-w container --}}

    <script>
        // ===== BG-TEXT MAPPING =====
        const bgTextMap = {
            'bg-primary': 'text-white',
            'bg-secondary-400': 'text-surface-dark',
            'bg-gray-500': 'text-white',
            'bg-gray-100 border border-gray-200': 'text-gray-500',
            'bg-surface-dark': 'text-white',
            'bg-secondary-600': 'text-white',
        };

        // ===== CREATE MODAL =====
        function openCreateModal() {
            document.getElementById('createModal').style.display = 'block';
        }
        function closeCreateModal() {
            document.getElementById('createModal').style.display = 'none';
        }

        // Sync text_class saat pilih warna di form tambah
        document.querySelectorAll('#create_bg_options input[type=radio]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.getElementById('create_text_class').value = bgTextMap[this.value] || 'text-white';
            });
        });

        // ===== EDIT MODAL =====
        function openEditModal(item) {
            document.getElementById('editForm').action = '/admin/pendaki-bergabung/' + item.id;
            document.getElementById('edit_nama').value    = item.nama;
            document.getElementById('edit_trip').value    = item.trip;
            document.getElementById('edit_initial').value = item.initial || '';
            document.getElementById('edit_urutan').value  = item.urutan || 0;

            // Preview foto
            const previewWrap = document.getElementById('edit_foto_preview_wrap');
            const previewImg  = document.getElementById('edit_foto_preview');
            const hapusFoto   = document.getElementById('edit_hapus_foto');
            hapusFoto.checked = false;

            if (item.foto) {
                let fotoUrl = item.foto.startsWith('http') || item.foto.startsWith('/')
                    ? item.foto
                    : '/storage/' + item.foto;
                previewImg.src = fotoUrl;
                previewWrap.style.display = '';
            } else {
                previewWrap.style.display = 'none';
            }

            // Set warna yang aktif
            const currentBg = item.bg_class || 'bg-primary';
            document.querySelectorAll('.edit-bg-radio').forEach(function(r) {
                r.checked = (r.value === currentBg);
            });
            document.getElementById('edit_text_class').value = bgTextMap[currentBg] || 'text-white';

            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Sync text_class saat pilih warna di form edit
        document.querySelectorAll('.edit-bg-radio').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.getElementById('edit_text_class').value = bgTextMap[this.value] || 'text-white';
            });
        });
    </script>
</x-app-layout>
