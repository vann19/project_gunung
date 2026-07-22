<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class QrisSettingController extends Controller
{
    /**
     * Tampilkan halaman kelola foto QRIS.
     */
    public function index(): View
    {
        $qrisImage = Setting::get('qris_image');

        return view('admin.qris.index', compact('qrisImage'));
    }

    /**
     * Update foto QRIS di database dan storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'qris_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Maksimal 2MB
        ], [
            'qris_image.required' => 'Silakan pilih foto QRIS terlebih dahulu.',
            'qris_image.image' => 'File yang diunggah harus berupa gambar.',
            'qris_image.mimes' => 'Format gambar harus berjenis jpeg, png, jpg, atau webp.',
            'qris_image.max' => 'Ukuran foto maksimal adalah 2MB.',
        ]);

        if ($request->hasFile('qris_image')) {
            $oldImage = Setting::get('qris_image');

            // Hapus foto lama jika tersimpan di public disk
            if ($oldImage && str_starts_with($oldImage, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldImage));
            }

            // Simpan foto baru
            $path = $request->file('qris_image')->store('qris', 'public');
            Setting::set('qris_image', '/storage/' . $path);
        }

        return redirect()->route('admin.qris.index')->with('success', 'Foto QRIS berhasil diperbarui! Foto baru otomatis tampil di semua halaman pembayaran.');
    }
}
