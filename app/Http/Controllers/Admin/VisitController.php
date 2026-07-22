<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 15);

        $query = Visit::query();

        if ($request->filled('ip')) {
            $query->where('ip', 'like', '%'.$request->ip.'%');
        }

        if ($request->filled('path')) {
            $query->where('path', 'like', '%'.$request->path.'%');
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $visits = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.visits.index', compact('visits'));
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return back()->with('success', 'Entri pengunjung dihapus.');
    }
}
