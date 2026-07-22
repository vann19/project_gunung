<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentalEquipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class RentalController extends Controller
{
    public function index(Request $request): View
    {
        $query = RentalEquipment::query()->with('variants');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('condition_badge') && $request->input('condition_badge') !== 'all') {
            $query->where('condition_badge', $request->input('condition_badge'));
        }

        $equipments = $query->latest()->get();

        $totalItems  = RentalEquipment::count();
        $baruCount   = RentalEquipment::where('condition_badge', 'Baru')->count();
        $secondCount = RentalEquipment::where('condition_badge', 'Second')->count();
        $hiddenCount = RentalEquipment::where('is_visible', false)->count();
        // Calculate low stock considering variants
        $lowStock = 0;
        foreach (RentalEquipment::with('variants')->get() as $eq) {
            if ($eq->variants->count() > 0) {
                foreach ($eq->variants as $variant) {
                    if ($variant->stock <= 2) $lowStock++;
                }
            } else {
                if ($eq->stock <= 2) $lowStock++;
            }
        }

        return view('admin.rentals.index', compact('equipments', 'totalItems', 'baruCount', 'secondCount', 'hiddenCount', 'lowStock'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category'         => 'required|string|max:100',
            'price'            => 'required|string|max:100',
            'stock'            => 'nullable|integer|min:0',
            'condition_badge'  => 'required|in:Baru,Second',
            'description'      => 'nullable|string',
            'variants.*.specifications'   => 'nullable|array',
            'variants.*.specifications.*.label' => 'nullable|string|max:255',
            'variants.*.specifications.*.value' => 'nullable|string|max:255',
            'variants'         => 'nullable|array',
            'variants.*.color' => 'nullable|string',
            'variants.*.size'  => 'nullable|string',
            'variants.*.sku'   => 'nullable|string',
            'variants.*.stock' => 'nullable|integer',
            'variants.*.image_file' => 'nullable|image|max:51200',
            'image'            => 'nullable|image|max:51200',
            'gallery_images.*' => 'nullable|image|max:51200',
        ]);

        $validated['is_popular'] = $request->has('is_popular');
        
        $validated['specifications'] = [];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = \Illuminate\Support\Str::random(40) . '.jpg';
            $path = 'rentals/' . $filename;
            
            $img = Image::decode($file);
            $img->scaleDown(width: 1200, height: 1200);
            Storage::disk('public')->put($path, (string) $img->encodeUsingFileExtension('jpg', 75));
            
            $validated['image'] = '/storage/' . $path;
        } else {
            $validated['image'] = '/img/camping.png';
        }

        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $file) {
                $filename = \Illuminate\Support\Str::random(40) . '.jpg';
                $path = 'rentals/gallery/' . $filename;
                
                $img = Image::decode($file);
                $img->scaleDown(width: 1200, height: 1200);
                Storage::disk('public')->put($path, (string) $img->encodeUsingFileExtension('jpg', 75));
                
                $gallery[] = '/storage/' . $path;
            }
            $validated['gallery_images'] = $gallery;
        } else {
            $validated['gallery_images'] = [];
        }

        $equipment = RentalEquipment::create($validated);

        // Process variants
        if ($request->has('variants') && is_array($request->input('variants'))) {
            foreach ($request->input('variants') as $index => $v) {
                if (!empty(trim($v['name'] ?? ''))) {
                    $variantImage = null;
                    if ($request->hasFile("variants.{$index}.image_file")) {
                        $file = $request->file("variants.{$index}.image_file");
                        $filename = \Illuminate\Support\Str::random(40) . '.jpg';
                        $path = 'rentals/variants/' . $filename;
                        
                        $image = Image::decode($file);
                        // Scale down to max 1200px width/height and encode as JPEG with 75% quality
                        $image->scaleDown(width: 1200, height: 1200);
                        Storage::disk('public')->put($path, (string) $image->encodeUsingFileExtension('jpg', 75));
                        
                        $variantImage = '/storage/' . $path;
                    }

                    $sku = trim($v['sku'] ?? '');
                    
                    $variantSpecs = [];
                    if (!empty($v['specifications']) && is_array($v['specifications'])) {
                        $filtered = array_filter($v['specifications'], function ($spec) {
                            return !empty(trim(data_get($spec, 'label', ''))) || !empty(trim(data_get($spec, 'value', '')));
                        });
                        $variantSpecs = array_values($filtered);
                    }

                    try {
                        $equipment->variants()->create([
                            'name' => trim($v['name'] ?? ''),
                            'sku' => $sku === '' ? null : $sku,
                            'stock' => intval($v['stock'] ?? 0),
                            'image' => $variantImage,
                            'price_override' => trim($v['price_override'] ?? ''),
                            'is_active' => true,
                            'specifications' => $variantSpecs,
                        ]);
                    } catch (\Illuminate\Database\QueryException $e) {
                        if ($e->errorInfo[1] == 1062) {
                            return back()->withErrors(['sku' => "SKU '{$sku}' sudah digunakan oleh produk lain. Harap gunakan SKU yang unik."])->withInput();
                        }
                        throw $e;
                    }
                }
            }
        }

        return redirect()->route('admin.rentals.index')->with('success', 'Alat rental baru berhasil ditambahkan!');
    }

    public function update(Request $request, RentalEquipment $rental): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category'         => 'required|string|max:100',
            'price'            => 'required|string|max:100',
            'stock'            => 'nullable|integer|min:0',
            'condition_badge'  => 'required|in:Baru,Second',
            'description'      => 'nullable|string',
            'variants.*.specifications'   => 'nullable|array',
            'variants.*.specifications.*.label' => 'nullable|string|max:255',
            'variants.*.specifications.*.value' => 'nullable|string|max:255',
            'variants'         => 'nullable|array',
            'variants.*.color' => 'nullable|string',
            'variants.*.size'  => 'nullable|string',
            'variants.*.sku'   => 'nullable|string',
            'variants.*.stock' => 'nullable|integer',
            'variants.*.image_file' => 'nullable|image|max:51200',
            'variants.*.existing_image' => 'nullable|string',
            'image'            => 'nullable|image|max:51200',
            'gallery_images.*' => 'nullable|image|max:51200',
        ]);

        $validated['is_popular'] = $request->has('is_popular');
        
        $validated['specifications'] = [];

        if ($request->hasFile('image')) {
            if ($rental->image && str_starts_with($rental->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $rental->image));
            }
            
            $file = $request->file('image');
            $filename = \Illuminate\Support\Str::random(40) . '.jpg';
            $path = 'rentals/' . $filename;
            
            $img = Image::decode($file);
            $img->scaleDown(width: 1200, height: 1200);
            Storage::disk('public')->put($path, (string) $img->encodeUsingFileExtension('jpg', 75));
            
            $validated['image'] = '/storage/' . $path;
        } else {
            unset($validated['image']);
        }

        if ($request->hasFile('gallery_images')) {
            $gallery = $rental->gallery_images ?? [];
            foreach ($request->file('gallery_images') as $file) {
                $filename = \Illuminate\Support\Str::random(40) . '.jpg';
                $path = 'rentals/gallery/' . $filename;
                
                $img = Image::decode($file);
                $img->scaleDown(width: 1200, height: 1200);
                Storage::disk('public')->put($path, (string) $img->encodeUsingFileExtension('jpg', 75));
                
                $gallery[] = '/storage/' . $path;
            }
            $validated['gallery_images'] = $gallery;
        }

        $rental->update($validated);

        // Process variants: Delete old and recreate to avoid complex sync, but preserve images if possible
        if ($request->has('variants') && is_array($request->input('variants'))) {
            $rental->variants()->delete();
            foreach ($request->input('variants') as $index => $v) {
                if (!empty(trim($v['name'] ?? ''))) {
                    $variantImage = $v['existing_image'] ?? null;
                    if ($request->hasFile("variants.{$index}.image_file")) {
                        $file = $request->file("variants.{$index}.image_file");
                        $filename = \Illuminate\Support\Str::random(40) . '.jpg';
                        $path = 'rentals/variants/' . $filename;
                        
                        $image = Image::decode($file);
                        // Scale down to max 1200px width/height and encode as JPEG with 75% quality
                        $image->scaleDown(width: 1200, height: 1200);
                        Storage::disk('public')->put($path, (string) $image->encodeUsingFileExtension('jpg', 75));
                        
                        $variantImage = '/storage/' . $path;
                    }

                    $sku = trim($v['sku'] ?? '');

                    $variantSpecs = [];
                    if (!empty($v['specifications']) && is_array($v['specifications'])) {
                        $filtered = array_filter($v['specifications'], function ($spec) {
                            return !empty(trim(data_get($spec, 'label', ''))) || !empty(trim(data_get($spec, 'value', '')));
                        });
                        $variantSpecs = array_values($filtered);
                    }

                    try {
                        $rental->variants()->create([
                            'name' => trim($v['name'] ?? ''),
                            'sku' => $sku === '' ? null : $sku,
                            'stock' => intval($v['stock'] ?? 0),
                            'image' => $variantImage,
                            'price_override' => trim($v['price_override'] ?? ''),
                            'is_active' => true,
                            'specifications' => $variantSpecs,
                        ]);
                    } catch (\Illuminate\Database\QueryException $e) {
                        if ($e->errorInfo[1] == 1062) {
                            return back()->withErrors(['sku' => "SKU '{$sku}' sudah digunakan. Harap gunakan SKU yang unik."])->withInput();
                        }
                        throw $e;
                    }
                }
            }
        }

        return redirect()->route('admin.rentals.index')->with('success', 'Alat rental berhasil diperbarui!');
    }

    public function destroy(RentalEquipment $rental): RedirectResponse
    {
        if ($rental->image && str_starts_with($rental->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $rental->image));
        }
        if (is_array($rental->gallery_images)) {
            foreach ($rental->gallery_images as $img) {
                if (str_starts_with($img, '/storage/')) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $img));
                }
            }
        }
        $rental->delete();

        return redirect()->route('admin.rentals.index')->with('success', 'Alat rental berhasil dihapus!');
    }

    public function toggleVisible(RentalEquipment $rental): RedirectResponse
    {
        $rental->update(['is_visible' => !$rental->is_visible]);
        $status = $rental->is_visible ? 'ditampilkan' : 'disembunyikan';
        
        return back()->with('success', "Alat rental '{$rental->title}' berhasil {$status} dari katalog publik.");
    }

    public function sellToMarketplace(Request $request, RentalEquipment $rental): RedirectResponse
    {
        $validated = $request->validate([
            'variant_id' => 'required|exists:rental_equipment_variants,id',
            'qty' => 'required|integer|min:1',
            'price' => 'required|string|max:100',
            'old_price' => 'nullable|string|max:100',
            'marketplace_category' => 'required|string|max:100',
        ]);

        $variant = $rental->variants()->where('id', $validated['variant_id'])->firstOrFail();

        if ($variant->stock < $validated['qty']) {
            return back()->withErrors(['qty' => 'Stok varian tidak mencukupi untuk dijual.'])->withInput();
        }

        // Kurangi stok di rental
        $variant->decrement('stock', $validated['qty']);

        // Tambahkan ke Marketplace
        \App\Models\MarketplaceItem::create([
            'title' => $rental->title . ($variant->color ? " - {$variant->color}" : '') . ($variant->size ? " ({$variant->size})" : ''),
            'category' => $validated['marketplace_category'],
            'condition_badge' => 'Ex-Rental',
            'badge_class' => 'bg-amber-400 text-amber-900',
            'spec' => 'Barang Bekas Rental',
            'description' => "Barang ex-rental (pernah disewakan).\n\n" . $rental->description,
            'whatsapp_number' => null,
            'price' => $validated['price'],
            'old_price' => $validated['old_price'] ?? null,
            'stock' => $validated['qty'],
            'image' => $variant->image ?: $rental->main_image,
        ]);

        return back()->with('success', "Berhasil memindahkan {$validated['qty']} stok '{$rental->title}' ke Marketplace!");
    }
}
