<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.blogs.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 hover:bg-slate-50 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Artikel Blog</h1>
                <p class="text-sm text-slate-500 mt-1">Tulis artikel baru untuk dibaca oleh pengunjung.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto pb-12">
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            @csrf

            <div class="p-6 sm:p-8 space-y-6">
                {{-- Judul --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Artikel <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                           placeholder="Contoh: Tips Mendaki Gunung untuk Pemula">
                    @error('title') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Gambar --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar Sampul</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                    <p class="text-xs text-slate-500 mt-1.5">Format yang didukung: JPG, PNG, WEBP. Maksimal 5MB.</p>
                    @error('image') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Konten --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Isi Artikel <span class="text-rose-500">*</span></label>
                    <textarea name="content" rows="12" required
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                              placeholder="Tulis isi artikel di sini...">{{ old('content') }}</textarea>
                    @error('content') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Status --}}
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                           class="w-5 h-5 rounded text-primary focus:ring-primary border-slate-300">
                    <label for="is_published" class="text-sm font-medium text-slate-700 cursor-pointer">Langsung Publikasikan (Tampil di Website)</label>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.blogs.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white text-sm font-semibold shadow-md shadow-primary/20 transition active:scale-95">
                    Simpan Artikel
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
