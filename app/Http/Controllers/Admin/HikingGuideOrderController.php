<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HikingGuideOrder;
use Illuminate\Http\Request;

class HikingGuideOrderController extends Controller
{
    public function index()
    {
        $orders = HikingGuideOrder::with('guide')->latest()->paginate(15);
        return view('admin.hiking-guide-orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, HikingGuideOrder $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy(HikingGuideOrder $order)
    {
        // Hapus file
        if ($order->foto_ktp) {
            $path = str_replace('/storage/', '', $order->foto_ktp);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
        }
        if ($order->surat_sehat) {
            $path = str_replace('/storage/', '', $order->surat_sehat);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
        }

        $order->delete();
        return back()->with('success', 'Pesanan berhasil dihapus.');
    }
}
