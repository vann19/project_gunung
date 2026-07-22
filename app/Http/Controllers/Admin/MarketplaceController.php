<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketplaceItem;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function __construct(protected CloudinaryService $cloudinary) {}

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

        $items      = $query->latest()->get();
        $totalItems = MarketplaceItem::count();
        $categories = MarketplaceItem::distinct()->orderBy('category')->pluck('category');

        return view('admin.marketplaces.index', compact('items', 'totalItems', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category'         => 'required|string|max:100',
            'condition_badge'  => 'required|string|max:100',
            'spec'             => 'nullable|string|max:255',
            'description'      => 'nullable|string|max:2000',
            'whatsapp_number'  => 'nullable|string|max:20',
            'price'            => 'required|string|max:100',
            'old_price'        => 'nullable|string|max:100',
            'stock'            => 'required|integer|min:0',
            'image'            => 'nullable|image|max:51200',
        ], [
            'image.max'   => 'Ukuran gambar maksimal adalah 50MB.',
            'image.image' => 'File harus berupa gambar.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->cloudinary->upload($request->file('image'), 'marketplaces');
        } else {
            $validated['image'] = '/img/camping.png';
        }

        // Assign badge_class berdasarkan condition_badge
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
            'title'            => 'required|string|max:255',
            'category'         => 'required|string|max:100',
            'condition_badge'  => 'required|string|max:100',
            'spec'             => 'nullable|string|max:255',
            'description'      => 'nullable|string|max:2000',
            'whatsapp_number'  => 'nullable|string|max:20',
            'price'            => 'required|string|max:100',
            'old_price'        => 'nullable|string|max:100',
            'stock'            => 'required|integer|min:0',
            'image'            => 'nullable|image|max:51200',
        ], [
            'image.max'   => 'Ukuran gambar maksimal adalah 50MB.',
            'image.image' => 'File harus berupa gambar.',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama dari Cloudinary
            if ($marketplace->image && $this->cloudinary->isCloudinaryUrl($marketplace->image)) {
                $this->cloudinary->delete($marketplace->image);
            }
            $validated['image'] = $this->cloudinary->upload($request->file('image'), 'marketplaces');
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
        if ($marketplace->image && $this->cloudinary->isCloudinaryUrl($marketplace->image)) {
            $this->cloudinary->delete($marketplace->image);
        }
        $marketplace->delete();

        return redirect()->route('admin.marketplaces.index')->with('success', 'Barang Marketplace berhasil dihapus!');
    }
}
