<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QrisSettingController extends Controller
{
    public function __construct(protected CloudinaryService $cloudinary) {}

    /**
     * Tampilkan halaman kelola foto QRIS.
     */
    public function index(): View
    {
        $qrisImage = Setting::get('qris_image');

        return view('admin.qris.index', compact('qrisImage'));
    }

    /**
     * Update foto QRIS - upload ke Cloudinary, simpan URL di database.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'qris_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'qris_image.required' => 'Silakan pilih foto QRIS terlebih dahulu.',
            'qris_image.image'    => 'File yang diunggah harus berupa gambar.',
            'qris_image.mimes'    => 'Format gambar harus berjenis jpeg, png, jpg, atau webp.',
            'qris_image.max'      => 'Ukuran foto maksimal adalah 2MB.',
        ]);

        if ($request->hasFile('qris_image')) {
            $oldImage = Setting::get('qris_image');

            // Hapus foto lama dari Cloudinary
            if ($oldImage && $this->cloudinary->isCloudinaryUrl($oldImage)) {
                $this->cloudinary->delete($oldImage);
            }

            // Upload ke Cloudinary, simpan URL
            $url = $this->cloudinary->upload($request->file('qris_image'), 'qris');
            Setting::set('qris_image', $url);
        }

        return redirect()->route('admin.qris.index')->with('success', 'Foto QRIS berhasil diperbarui! Foto baru otomatis tampil di semua halaman pembayaran.');
    }
}
