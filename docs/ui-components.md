# Panduan UI Components (Shortcut Laravel)

Dokumentasi ini menjelaskan cara menggunakan komponen UI (Blade Components) yang telah dibuat agar proses coding tampilan dengan Tailwind CSS lebih cepat, bersih, dan konsisten.

---

## 1. Button (`<x-btn>`)

Komponen tombol standar yang sudah memiliki efek hover, active, dan transisi.

### Penggunaan Dasar:
```html
<x-btn>Simpan Data</x-btn>
```

### Variants (Warna/Gaya):
Gunakan atribut `variant` untuk mengubah gaya tombol.
```html
<!-- Primary (Hijau Solid - Default) -->
<x-btn variant="primary">Kirim</x-btn>

<!-- Outline (Garis pinggir hijau) -->
<x-btn variant="outline">Batal</x-btn>

<!-- Ghost (Tanpa background, cocok untuk aksi sekunder) -->
<x-btn variant="ghost">Kembali</x-btn>
```

### Atribut Tambahan:
Semua atribut HTML standar bisa langsung ditambahkan (seperti `type`, `id`, `class`, `disabled`, `onclick`, dsb).
```html
<x-btn type="submit" class="w-full mt-4" disabled>
    Proses Pembayaran
</x-btn>
```

---

## 2. Form Input (`<x-input>`)

Komponen input text yang sudah terintegrasi dengan label dan pesan error validasi bawaan Laravel.

### Penggunaan Dasar:
Hanya butuh parameter `name`.
```html
<x-input name="username" />
```

### Dengan Label & Placeholder:
```html
<x-input 
    label="Alamat Email" 
    name="email" 
    type="email" 
    placeholder="Masukkan email anda..." 
/>
```

### Penjelasan Fitur Validasi:
Jika pada Controller terdapat validasi yang gagal pada field `name="email"`, maka komponen ini akan **otomatis menampilkan teks error berwarna merah** di bawah input tersebut tanpa perlu kamu tulis manual kode `@error('email')`.

---

## 3. Card Container (`<x-card>`)

Bungkus putih dengan border tipis dan shadow halus. Cocok untuk membungkus form, widget, atau artikel.

### Penggunaan Dasar:
```html
<x-card>
    <h2 class="text-xl font-bold">Judul Konten</h2>
    <p class="text-gray-600 mt-2">Isi dari card ini ditulis di sini.</p>
</x-card>
```

### Efek Hover:
Jika ingin card sedikit "melayang" (naik ke atas dan shadow bertambah) saat kursor diarahkan, tambahkan `hover="true"`.
```html
<x-card hover="true">
    Isi card yang interaktif...
</x-card>
```

---

## 4. Main Layout (`<x-layouts.app>`)

Ini adalah kerangka dasar (skeleton) HTML untuk semua halaman web. Layout ini otomatis memanggil Tailwind CSS via Vite.

### Penggunaan pada File Blade:
Setiap kali kamu membuat halaman baru (misal: `about.blade.php`), selalu bungkus dengan layout ini:

```html
<x-layouts.app title="Tentang Kami - Project Gunung">
    
    <!-- Semua kodingan halamamu masuk ke sini -->
    <div class="p-8">
        <h1 class="text-2xl font-bold">Halaman Tentang Kami</h1>
        <p>Isi halaman...</p>
    </div>

</x-layouts.app>
```

### Menambahkan CSS/JS Khusus di Halaman Tertentu:
Jika kamu butuh custom script atau style khusus hanya di halaman tertentu, kamu bisa menggunakan `@push`:

```html
<x-layouts.app>
    <p>Halaman dengan script khusus</p>

    <!-- Script ini akan otomatis diletakkan di sebelum </body> -->
    @push('scripts')
        <script>
            console.log('Script khusus halaman ini jalan!');
        </script>
    @endpush
</x-layouts.app>
```

---

## Mengapa Menggunakan Ini?
1. **Bersih**: Halaman `.blade.php` utama tidak penuh dengan rentetan class Tailwind yang panjang.
2. **Konsisten**: Jika klien minta ubah warna *semua* tombol dari Hijau ke Biru, kita hanya perlu ubah 1 file (`resources/css/app.css`), tidak perlu cari tombol satu-satu.
3. **Cepat**: `<x-input label="Nama" name="nama">` jauh lebih cepat diketik daripada membuat div, label, input, dan span error secara manual.


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuciAlat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CuciAlatController extends Controller
{
    public function index(Request $request): View
    {
        $query = CuciAlat::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $packages = $query->latest()->get();
        $totalPackages = CuciAlat::count();

        return view('admin.cuci-alats.index', compact('packages', 'totalPackages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
        ]);

        $validated['is_recommended'] = $request->has('is_recommended');

        CuciAlat::create($validated);

        return redirect()->route('admin.cuci-alats.index')->with('success', 'Paket Cuci Alat baru berhasil ditambahkan!');
    }

    public function update(Request $request, CuciAlat $cuci_alat): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
        ]);

        $validated['is_recommended'] = $request->has('is_recommended');

        $cuci_alat->update($validated);

        return redirect()->route('admin.cuci-alats.index')->with('success', 'Paket Cuci Alat berhasil diperbarui!');
    }

    public function destroy(CuciAlat $cuci_alat): RedirectResponse
    {
        $cuci_alat->delete();

        return redirect()->route('admin.cuci-alats.index')->with('success', 'Paket Cuci Alat berhasil dihapus!');
    }
}
