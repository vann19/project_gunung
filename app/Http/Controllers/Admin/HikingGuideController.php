<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HikingGuide;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HikingGuideController extends Controller
{
    public function __construct(protected CloudinaryService $cloudinary) {}

    public function index(Request $request): View
    {
        $query = HikingGuide::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $guides = $query->latest()->get();
        $totalGuides = HikingGuide::count();

        return view('admin.hiking-guides.index', compact('guides', 'totalGuides'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'required|string|max:100',
            'price' => 'required|string|max:100',
            'unit'  => 'required|string|max:50',
            'slot'  => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['badge_class'] = $validated['is_featured'] ? 'bg-primary text-white' : 'bg-secondary-400 text-surface-dark';

        if ($request->hasFile('image')) {
            $validated['image'] = $this->cloudinary->upload($request->file('image'), 'guides');
        } else {
            $validated['image'] = '/img/Guide helping climber.png';
        }

        if ($request->filled('features_text')) {
            $lines    = array_filter(array_map('trim', explode("\n", $request->input('features_text'))));
            $features = [];
            foreach ($lines as $line) {
                $features[] = ['label' => $line, 'bold' => false];
            }
            if (count($features) > 0 && $validated['is_featured']) {
                $features[0]['bold'] = true;
            }
            $validated['features'] = $features;
        } else {
            $validated['features'] = [
                ['label' => 'Sertifikasi Resmi APGI & P3K', 'bold' => true],
                ['label' => 'Rasio pendampingan aman (1:4)', 'bold' => false],
                ['label' => 'Menguasai rute & navigasi darat', 'bold' => false],
            ];
        }

        HikingGuide::create($validated);

        return redirect()->route('admin.hiking-guides.index')->with('success', 'Paket Guide Pendakian baru berhasil ditambahkan!');
    }

    public function update(Request $request, HikingGuide $hiking_guide): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'required|string|max:100',
            'price' => 'required|string|max:100',
            'unit'  => 'required|string|max:50',
            'slot'  => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['badge_class'] = $validated['is_featured'] ? 'bg-primary text-white' : 'bg-secondary-400 text-surface-dark';

        if ($request->hasFile('image')) {
            // Hapus gambar lama dari Cloudinary
            if ($hiking_guide->image && $this->cloudinary->isCloudinaryUrl($hiking_guide->image)) {
                $this->cloudinary->delete($hiking_guide->image);
            }
            $validated['image'] = $this->cloudinary->upload($request->file('image'), 'guides');
        } else {
            unset($validated['image']);
        }

        if ($request->filled('features_text')) {
            $lines    = array_filter(array_map('trim', explode("\n", $request->input('features_text'))));
            $features = [];
            foreach ($lines as $line) {
                $features[] = ['label' => $line, 'bold' => false];
            }
            if (count($features) > 0 && $validated['is_featured']) {
                $features[0]['bold'] = true;
            }
            $validated['features'] = $features;
        }

        $hiking_guide->update($validated);

        return redirect()->route('admin.hiking-guides.index')->with('success', 'Paket Guide Pendakian berhasil diperbarui!');
    }

    public function destroy(HikingGuide $hiking_guide): RedirectResponse
    {
        if ($hiking_guide->image && $this->cloudinary->isCloudinaryUrl($hiking_guide->image)) {
            $this->cloudinary->delete($hiking_guide->image);
        }
        $hiking_guide->delete();

        return redirect()->route('admin.hiking-guides.index')->with('success', 'Paket Guide Pendakian berhasil dihapus!');
    }
}
