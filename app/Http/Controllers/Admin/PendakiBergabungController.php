<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendakiBergabung;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PendakiBergabungController extends Controller
{
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
            'foto'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? 0;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('pendaki', 'public');
            $validated['foto'] = $path;
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
            'foto'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? 0;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pendakiBergabung->foto) {
                Storage::disk('public')->delete($pendakiBergabung->foto);
            }
            $path = $request->file('foto')->store('pendaki', 'public');
            $validated['foto'] = $path;
        }

        // Hapus foto jika di-request
        if ($request->input('hapus_foto') === '1' && $pendakiBergabung->foto) {
            Storage::disk('public')->delete($pendakiBergabung->foto);
            $validated['foto'] = null;
        }

        $pendakiBergabung->update($validated);

        return redirect()->route('admin.pendaki-bergabung.index')
                         ->with('success', 'Data pendaki berhasil diperbarui!');
    }

    public function destroy(PendakiBergabung $pendakiBergabung): RedirectResponse
    {
        // Hapus foto dari storage jika ada
        if ($pendakiBergabung->foto) {
            Storage::disk('public')->delete($pendakiBergabung->foto);
        }

        $pendakiBergabung->delete();

        return redirect()->route('admin.pendaki-bergabung.index')
                         ->with('success', 'Pendaki berhasil dihapus!');
    }
}
