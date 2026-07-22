<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use App\Models\MountainRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MountainController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $mountains = Mountain::withCount('routes')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        $totalItems = Mountain::count();
        $hiddenCount = Mountain::where('is_visible', false)->count();

        return view('admin.mountains.index', compact('mountains', 'totalItems', 'hiddenCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'elevation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name);

        // Ensure unique slug
        $count = Mountain::where('slug', 'like', $data['slug'].'%')->count();
        if ($count > 0) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        $data['is_visible'] = $request->has('is_visible');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/mountains'), $filename);
            $data['image'] = 'uploads/mountains/' . $filename;
        }

        $mountain = Mountain::create($data);

        // Handle routes and posts
        if ($request->has('routes')) {
            foreach ($request->routes as $routeData) {
                if (!empty($routeData['name'])) {
                    $mountain->routes()->create([
                        'name' => $routeData['name'],
                        'basecamp_info' => $routeData['basecamp_info'] ?? null,
                        'description' => $routeData['description'] ?? null,
                        'posts' => $routeData['posts'] ?? [],
                    ]);
                }
            }
        }

        return redirect()->route('admin.mountains.index')->with('success', 'Informasi Gunung berhasil ditambahkan.');
    }

    public function update(Request $request, Mountain $mountain)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'elevation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        if ($request->name !== $mountain->name) {
            $data['slug'] = Str::slug($request->name);
            $count = Mountain::where('slug', 'like', $data['slug'].'%')->where('id', '!=', $mountain->id)->count();
            if ($count > 0) {
                $data['slug'] = $data['slug'] . '-' . time();
            }
        }

        $data['is_visible'] = $request->has('is_visible');

        if ($request->hasFile('image')) {
            if ($mountain->image && file_exists(public_path($mountain->image))) {
                unlink(public_path($mountain->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/mountains'), $filename);
            $data['image'] = 'uploads/mountains/' . $filename;
        }

        $mountain->update($data);

        // Sync routes: Delete all and recreate to keep it simple, or update based on ID
        $mountain->routes()->delete();
        if ($request->has('routes')) {
            foreach ($request->routes as $routeData) {
                if (!empty($routeData['name'])) {
                    $mountain->routes()->create([
                        'name' => $routeData['name'],
                        'basecamp_info' => $routeData['basecamp_info'] ?? null,
                        'description' => $routeData['description'] ?? null,
                        'posts' => $routeData['posts'] ?? [],
                    ]);
                }
            }
        }

        return redirect()->route('admin.mountains.index')->with('success', 'Informasi Gunung berhasil diperbarui.');
    }

    public function destroy(Mountain $mountain)
    {
        if ($mountain->image && file_exists(public_path($mountain->image))) {
            unlink(public_path($mountain->image));
        }
        $mountain->delete();
        return redirect()->route('admin.mountains.index')->with('success', 'Informasi Gunung berhasil dihapus.');
    }

    public function toggleVisible(Mountain $mountain)
    {
        $mountain->update([
            'is_visible' => !$mountain->is_visible
        ]);
        return back()->with('success', 'Visibilitas Gunung berhasil diubah.');
    }
}
