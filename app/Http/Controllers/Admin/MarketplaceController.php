<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketplaceItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class MarketplaceController extends Controller
{
    public function index(Request $request): View
    {
        $query = MarketplaceItem::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        $items = $query->latest()->get();
        $totalItems = MarketplaceItem::count();
        $categories = MarketplaceItem::distinct()->orderBy('category')->pluck('category');

        return view('admin.marketplaces.index', compact('items', 'totalItems', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'condition_badge' => 'required|string|max:100',
            'spec' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'whatsapp_number' => 'nullable|string|max:20',
            'price' => 'required|string|max:100',
            'old_price' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:51200',
        ], [
            'image.max' => 'Ukuran gambar maksimal adalah 50MB.',
            'image.image' => 'File harus berupa gambar.',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = \Illuminate\Support\Str::random(40) . '.jpg';
            $path = 'marketplaces/' . $filename;
            
            $img = Image::decode($file);
            $img->scaleDown(width: 1200, height: 1200);
            Storage::disk('public')->put($path, (string) $img->encodeUsingFileExtension('jpg', 75));
            
            $validated['image'] = '/storage/' . $path;
        } else {
            $validated['image'] = '/img/camping.png';
        }

        // Assign badge_class based on condition_badge
        if ($validated['condition_badge'] === 'Baru') {
            $validated['badge_class'] = 'bg-secondary-400 text-surface-dark';
        } elseif ($validated['condition_badge'] === 'Bekas') {
            $validated['badge_class'] = 'bg-white text-gray-700 border border-gray-200';
        } else {
            $validated['badge_class'] = 'bg-red-50 text-red-600';
        }

        MarketplaceItem::create($validated);

        return redirect()->route('admin.marketplaces.index')->with('success', 'Barang Marketplace berhasil ditambahkan!');
    }

    public function update(Request $request, MarketplaceItem $marketplace): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'condition_badge' => 'required|string|max:100',
            'spec' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'whatsapp_number' => 'nullable|string|max:20',
            'price' => 'required|string|max:100',
            'old_price' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:51200',
        ], [
            'image.max' => 'Ukuran gambar maksimal adalah 50MB.',
            'image.image' => 'File harus berupa gambar.',
        ]);

        if ($request->hasFile('image')) {
            if ($marketplace->image && str_starts_with($marketplace->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $marketplace->image));
            }
            $file = $request->file('image');
            $filename = \Illuminate\Support\Str::random(40) . '.jpg';
            $path = 'marketplaces/' . $filename;
            
            $img = Image::decode($file);
            $img->scaleDown(width: 1200, height: 1200);
            Storage::disk('public')->put($path, (string) $img->encodeUsingFileExtension('jpg', 75));
            
            $validated['image'] = '/storage/' . $path;
        } else {
            unset($validated['image']);
        }

        if ($validated['condition_badge'] === 'Baru') {
            $validated['badge_class'] = 'bg-secondary-400 text-surface-dark';
        } elseif ($validated['condition_badge'] === 'Bekas') {
            $validated['badge_class'] = 'bg-white text-gray-700 border border-gray-200';
        } else {
            $validated['badge_class'] = 'bg-red-50 text-red-600';
        }

        $marketplace->update($validated);

        return redirect()->route('admin.marketplaces.index')->with('success', 'Barang Marketplace berhasil diperbarui!');
    }

    public function destroy(MarketplaceItem $marketplace): RedirectResponse
    {
        if ($marketplace->image && str_starts_with($marketplace->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $marketplace->image));
        }
        $marketplace->delete();

        return redirect()->route('admin.marketplaces.index')->with('success', 'Barang Marketplace berhasil dihapus!');
    }
}
