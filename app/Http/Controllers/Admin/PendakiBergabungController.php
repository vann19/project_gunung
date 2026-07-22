<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendakiBergabung;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PendakiBergabungController extends Controller
{
    protected CloudinaryService $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }

    public function index(Request $request): View
    {
        $query = PendakiBergabung::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('trip', 'like', "%{$search}%");
        }

        $pendakis = $query->orderBy('urutan')->orderBy('id')->get();
        $total    = PendakiBergabung::count();

        return view('admin.pendaki-bergabung.index', compact('pendakis', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:100',
            'trip'       => 'required|string|max:100',
            'initial'    => 'nullable|string|max:5',
            'bg_class'   => 'required|string|max:200',
            'text_class' => 'required|string|max:100',
            'urutan'     => 'nullable|integer|min:0',
            'foto'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? 0;

        if ($request->hasFile('foto')) {
            try {
                $validated['foto'] = $this->cloudinaryService->upload($request->file('foto'), 'pendaki');
            } catch (\Throwable $e) {
                $path = $request->file('foto')->store('pendaki', 'public');
                $validated['foto'] = '/storage/' . $path;
            }
        }

        PendakiBergabung::create($validated);

        return redirect()->route('admin.pendaki-bergabung.index')
                         ->with('success', 'Pendaki berhasil ditambahkan!');
    }

    public function update(Request $request, PendakiBergabung $pendakiBergabung): RedirectResponse
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:100',
            'trip'       => 'required|string|max:100',
            'initial'    => 'nullable|string|max:5',
            'bg_class'   => 'required|string|max:200',
            'text_class' => 'required|string|max:100',
            'urutan'     => 'nullable|integer|min:0',
            'foto'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? 0;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pendakiBergabung->foto) {
                if ($this->cloudinaryService->isCloudinaryUrl($pendakiBergabung->foto)) {
                    $this->cloudinaryService->delete($pendakiBergabung->foto);
                } else {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $pendakiBergabung->foto));
                }
            }
            try {
                $validated['foto'] = $this->cloudinaryService->upload($request->file('foto'), 'pendaki');
            } catch (\Throwable $e) {
                $path = $request->file('foto')->store('pendaki', 'public');
                $validated['foto'] = '/storage/' . $path;
            }
        }

        // Hapus foto jika di-request
        if ($request->input('hapus_foto') === '1' && $pendakiBergabung->foto) {
            if ($this->cloudinaryService->isCloudinaryUrl($pendakiBergabung->foto)) {
                $this->cloudinaryService->delete($pendakiBergabung->foto);
            } else {
                Storage::disk('public')->delete(str_replace('/storage/', '', $pendakiBergabung->foto));
            }
            $validated['foto'] = null;
        }

        $pendakiBergabung->update($validated);

        return redirect()->route('admin.pendaki-bergabung.index')
                         ->with('success', 'Data pendaki berhasil diperbarui!');
    }

    public function destroy(PendakiBergabung $pendakiBergabung): RedirectResponse
    {
        // Hapus foto jika ada
        if ($pendakiBergabung->foto) {
            if ($this->cloudinaryService->isCloudinaryUrl($pendakiBergabung->foto)) {
                $this->cloudinaryService->delete($pendakiBergabung->foto);
            } else {
                Storage::disk('public')->delete(str_replace('/storage/', '', $pendakiBergabung->foto));
            }
        }

        $pendakiBergabung->delete();

        return redirect()->route('admin.pendaki-bergabung.index')
                         ->with('success', 'Pendaki berhasil dihapus!');
    }
}
