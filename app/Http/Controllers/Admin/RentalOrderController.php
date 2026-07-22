<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentalOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RentalOrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = RentalOrder::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nomor_wa', 'like', "%{$search}%")
                  ->orWhere('nik_ktp', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        $orders = $query->latest()->get();

        $totalOrders = RentalOrder::count();
        $pendingCount = RentalOrder::where('status', 'pending')->count();
        $confirmedCount = RentalOrder::where('status', 'confirmed')->count();
        $completedCount = RentalOrder::where('status', 'completed')->count();

        return view('admin.rental-orders.index', compact(
            'orders',
            'totalOrders',
            'pendingCount',
            'confirmedCount',
            'completedCount'
        ));
    }

    public function update(Request $request, RentalOrder $rental_order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'tanggal_kembali' => 'nullable|date_format:Y-m-d\TH:i',
            'catatan' => 'nullable|string|max:500',
        ]);

        if (!empty($validated['tanggal_kembali'])) {
            $validated['tanggal_kembali'] = date('Y-m-d H:i:s', strtotime($validated['tanggal_kembali']));
        }

        $oldStatus = $rental_order->status;
        $rental_order->update($validated);

        if ($oldStatus !== 'cancelled' && $validated['status'] === 'cancelled') {
            $items = is_string($rental_order->items) ? json_decode($rental_order->items, true) : $rental_order->items;
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (!empty($item['variant_id'])) {
                        $variant = \App\Models\RentalEquipmentVariant::find($item['variant_id']);
                        if ($variant) {
                            $variant->increment('stock', 1);
                        }
                    } else if (!empty($item['slug'])) {
                        $equipment = \App\Models\RentalEquipment::where('slug', $item['slug'])->first();
                        if ($equipment) {
                            $equipment->increment('stock', 1);
                        }
                    }
                }
            }
        }

        return redirect()->route('admin.rental-orders.index')->with('success', 'Status pesanan rental berhasil diperbarui!');
    }

    public function destroy(RentalOrder $rental_order): RedirectResponse
    {
        if ($rental_order->foto_ktp && str_starts_with($rental_order->foto_ktp, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $rental_order->foto_ktp));
        }
        $rental_order->delete();

        return redirect()->route('admin.rental-orders.index')->with('success', 'Pesanan rental berhasil dihapus!');
    }
}
