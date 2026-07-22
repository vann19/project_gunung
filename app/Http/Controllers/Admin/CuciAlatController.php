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
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['is_recommended'] = $request->has('is_recommended');

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cuci-alats', 'public');
            $validated['image'] = '/storage/' . $path;
        } else {
            $validated['image'] = '/img/Camping gear setup.png';
        }

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
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['is_recommended'] = $request->has('is_recommended');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($cuci_alat->image && str_starts_with($cuci_alat->image, '/storage/')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $cuci_alat->image));
            }
            $path = $request->file('image')->store('cuci-alats', 'public');
            $validated['image'] = '/storage/' . $path;
        } else {
            // Keep existing image if not updated
            unset($validated['image']);
        }

        $cuci_alat->update($validated);

        return redirect()->route('admin.cuci-alats.index')->with('success', 'Paket Cuci Alat berhasil diperbarui!');
    }

    public function destroy(CuciAlat $cuci_alat): RedirectResponse
    {
        // Delete image if exists
        if ($cuci_alat->image && str_starts_with($cuci_alat->image, '/storage/')) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $cuci_alat->image));
        }
        
        $cuci_alat->delete();

        return redirect()->route('admin.cuci-alats.index')->with('success', 'Paket Cuci Alat berhasil dihapus!');
    }
}
