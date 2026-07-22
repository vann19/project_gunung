<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpenTrip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class OpenTripController extends Controller
{
    public function index(Request $request): View
    {
        $query = OpenTrip::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $trips = $query->latest()->get();
        $totalTrips = OpenTrip::count();
        $featuredCount = OpenTrip::where('is_featured', true)->count();

        return view('admin.open-trips.index', compact('trips', 'totalTrips', 'featuredCount'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'required|string|max:100',
            'badge_class' => 'required|string|max:255',
            'slot' => 'required|integer|min:1',
            'price' => 'required|string|max:100',
            'image' => 'nullable|image|max:51200',
        ], [
            'image.max' => 'Ukuran gambar maksimal adalah 50MB.',
            'image.image' => 'File harus berupa gambar.',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = \Illuminate\Support\Str::random(40) . '.jpg';
            $path = 'open-trips/' . $filename;
            
            $img = Image::decode($file);
            $img->scaleDown(width: 1200, height: 1200);
            Storage::disk('public')->put($path, (string) $img->encodeUsingFileExtension('jpg', 75));
            
            $validated['image'] = '/storage/' . $path;
        }

        $validated['is_featured'] = $request->has('is_featured');

        // Handle features input (array or newline separated strings)
        if ($request->filled('features_text')) {
            $lines = array_filter(array_map('trim', explode("\n", $request->input('features_text'))));
            $features = [];
            foreach ($lines as $line) {
                // Determine icon based on text keyword or default
                $icon = 'tent';
                if (stripos($line, 'transport') !== false || stripos($line, 'jemput') !== false || stripos($line, 'bus') !== false) {
                    $icon = 'transport';
                } elseif (stripos($line, 'makan') !== false || stripos($line, 'logistik') !== false) {
                    $icon = 'food';
                } elseif (stripos($line, 'porter') !== false || stripos($line, 'guide') !== false) {
                    $icon = 'porter';
                }
                $features[] = ['icon' => $icon, 'label' => $line];
            }
            $validated['features'] = $features;
        } else {
            $validated['features'] = [
                ['icon' => 'transport', 'label' => 'Transport PP dari Meeting Point'],
                ['icon' => 'food', 'label' => 'Makan & Logistik Selama Pendakian'],
                ['icon' => 'porter', 'label' => 'Porter Tim & Guide Sertifikasi APGI'],
                ['icon' => 'tent', 'label' => 'Tenda & Perlengkapan Kelompok'],
            ];
        }

        OpenTrip::create($validated);

        return redirect()->route('admin.open-trips.index')->with('success', 'Jadwal Open Trip baru berhasil ditambahkan!');
    }

    public function update(Request $request, OpenTrip $open_trip): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'required|string|max:100',
            'badge_class' => 'required|string|max:255',
            'slot' => 'required|integer|min:1',
            'price' => 'required|string|max:100',
            'image' => 'nullable|image|max:51200',
        ], [
            'image.max' => 'Ukuran gambar maksimal adalah 50MB.',
            'image.image' => 'File harus berupa gambar.',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = \Illuminate\Support\Str::random(40) . '.jpg';
            $path = 'open-trips/' . $filename;
            
            $img = Image::decode($file);
            $img->scaleDown(width: 1200, height: 1200);
            Storage::disk('public')->put($path, (string) $img->encodeUsingFileExtension('jpg', 75));
            
            $validated['image'] = '/storage/' . $path;
            
            // Delete old image if it's not a default one
            if ($open_trip->image && str_starts_with($open_trip->image, '/storage/open-trips/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $open_trip->image));
            }
        }

        $validated['is_featured'] = $request->has('is_featured');

        if ($request->filled('features_text')) {
            $lines = array_filter(array_map('trim', explode("\n", $request->input('features_text'))));
            $features = [];
            foreach ($lines as $line) {
                $icon = 'tent';
                if (stripos($line, 'transport') !== false || stripos($line, 'jemput') !== false || stripos($line, 'bus') !== false) {
                    $icon = 'transport';
                } elseif (stripos($line, 'makan') !== false || stripos($line, 'logistik') !== false) {
                    $icon = 'food';
                } elseif (stripos($line, 'porter') !== false || stripos($line, 'guide') !== false) {
                    $icon = 'porter';
                }
                $features[] = ['icon' => $icon, 'label' => $line];
            }
            $validated['features'] = $features;
        }

        $open_trip->update($validated);

        return redirect()->route('admin.open-trips.index')->with('success', 'Jadwal Open Trip berhasil diperbarui!');
    }

    public function destroy(OpenTrip $open_trip): RedirectResponse
    {
        if ($open_trip->image && str_starts_with($open_trip->image, '/storage/open-trips/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $open_trip->image));
        }

        $open_trip->delete();

        return redirect()->route('admin.open-trips.index')->with('success', 'Jadwal Open Trip berhasil dihapus!');
    }
}
