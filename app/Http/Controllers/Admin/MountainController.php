<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use App\Models\MountainRoute;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MountainController extends Controller
{
    public function __construct(protected CloudinaryService $cloudinary) {}

    public function index(Request $request)
    {
        $search    = $request->search;
        $mountains = Mountain::withCount('routes')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        $totalItems  = Mountain::count();
        $hiddenCount = Mountain::where('is_visible', false)->count();

        return view('admin.mountains.index', compact('mountains', 'totalItems', 'hiddenCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'location'    => 'nullable|string|max:255',
            'elevation'   => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data           = $request->except('image');
        $data['slug']   = Str::slug($request->name);

        // Ensure unique slug
        $count = Mountain::where('slug', 'like', $data['slug'].'%')->count();
        if ($count > 0) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        $data['is_visible'] = $request->has('is_visible');

        if ($request->hasFile('image')) {
            $data['image'] = $this->cloudinary->upload($request->file('image'), 'mountains');
        }

        $mountain = Mountain::create($data);

        // Handle routes
        if ($request->has('routes')) {
            foreach ($request->routes as $routeData) {
                if (!empty($routeData['name'])) {
                    $mountain->routes()->create([
                        'name'          => $routeData['name'],
                        'basecamp_info' => $routeData['basecamp_info'] ?? null,
                        'description'   => $routeData['description'] ?? null,
                        'posts'         => $routeData['posts'] ?? [],
                    ]);
                }
            }
        }

        return redirect()->route('admin.mountains.index')->with('success', 'Informasi Gunung berhasil ditambahkan.');
    }

    public function update(Request $request, Mountain $mountain)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'location'    => 'nullable|string|max:255',
            'elevation'   => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        if ($request->name !== $mountain->name) {
            $data['slug'] = Str::slug($request->name);
            $count        = Mountain::where('slug', 'like', $data['slug'].'%')->where('id', '!=', $mountain->id)->count();
            if ($count > 0) {
                $data['slug'] = $data['slug'] . '-' . time();
            }
        }

        $data['is_visible'] = $request->has('is_visible');

        if ($request->hasFile('image')) {
            // Hapus gambar lama dari Cloudinary
            if ($mountain->image && $this->cloudinary->isCloudinaryUrl($mountain->image)) {
                $this->cloudinary->delete($mountain->image);
            }
            $data['image'] = $this->cloudinary->upload($request->file('image'), 'mountains');
        }

        $mountain->update($data);

        // Sync routes
        $mountain->routes()->delete();
        if ($request->has('routes')) {
            foreach ($request->routes as $routeData) {
                if (!empty($routeData['name'])) {
                    $mountain->routes()->create([
                        'name'          => $routeData['name'],
                        'basecamp_info' => $routeData['basecamp_info'] ?? null,
                        'description'   => $routeData['description'] ?? null,
                        'posts'         => $routeData['posts'] ?? [],
                    ]);
                }
            }
        }

        return redirect()->route('admin.mountains.index')->with('success', 'Informasi Gunung berhasil diperbarui.');
    }

    public function destroy(Mountain $mountain)
    {
        if ($mountain->image && $this->cloudinary->isCloudinaryUrl($mountain->image)) {
            $this->cloudinary->delete($mountain->image);
        }
        $mountain->delete();

        return redirect()->route('admin.mountains.index')->with('success', 'Informasi Gunung berhasil dihapus.');
    }

    public function toggleVisible(Mountain $mountain)
    {
        $mountain->update(['is_visible' => !$mountain->is_visible]);

        return back()->with('success', 'Visibilitas Gunung berhasil diubah.');
    }
}
