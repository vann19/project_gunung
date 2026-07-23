<?php

use App\Http\Controllers\Admin\CuciAlatController;
use App\Http\Controllers\Admin\HikingGuideController;
use App\Http\Controllers\Admin\MarketplaceController;
use App\Http\Controllers\Admin\OpenTripController;
use App\Http\Controllers\Admin\PendakiBergabungController;
use App\Http\Controllers\Admin\QrisSettingController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Admin\RentalOrderController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Models\CuciAlat;
use App\Models\HikingGuide;
use App\Models\MarketplaceItem;
use App\Models\OpenTrip;
use App\Models\RentalEquipment;
use App\Models\RentalOrder;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/', function () {
    $rentalCategories = [
        'camping', 'kelompok', 'masak', 'makan', 
        'piknik', 'grill', 'pribadi', 'hydropack'
    ];
    return view('welcome', compact('rentalCategories'));
});

Route::get('/rental', function () {
    $products = RentalEquipment::with('variants')->where('is_visible', true)->latest()->get();
    return view('rental', compact('products'));
})->name('rental');

Route::get('/rental/checkout-cart', function () {
    return view('qris-cart-checkout');
})->name('rental.cart-checkout');

Route::get('/info-gunung', function () {
    $mountains = \App\Models\Mountain::where('is_visible', true)->latest()->get();
    return view('info-gunung.index', compact('mountains'));
})->name('info-gunung.index');

Route::get('/info-gunung/{slug}', function ($slug) {
    $mountain = \App\Models\Mountain::with('routes')->where('slug', $slug)->where('is_visible', true)->firstOrFail();
    return view('info-gunung.show', compact('mountain'));
})->name('info-gunung.show');

Route::get('/checkout/qris/{slug}', function ($slug) {
    $product = RentalEquipment::where('slug', $slug)->where('is_visible', true)->firstOrFail();
    return view('qris-checkout', compact('product'));
})->name('rental.checkout');

Route::get('/rental/biodata', function (\Illuminate\Http\Request $request) {
    $slug = $request->query('slug');
    $qty = intval($request->query('qty', 1));
    $variantId = $request->query('variant_id');
    $days = intval($request->query('days', 1)); // Default duration 1 hari
    
    $singleItem = null;
    $variant = null;

    if ($slug) {
        $singleItem = RentalEquipment::where('slug', $slug)->where('is_visible', true)->first();
        if ($singleItem && $variantId) {
            $variant = $singleItem->variants()->where('id', $variantId)->first();
        }
    }

    return view('rental-biodata', compact('singleItem', 'variant', 'qty', 'days'));
})->name('rental.biodata');

Route::post('/rental/process-biodata', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'nama_lengkap'      => 'required|string|max:100',
        'nomor_wa'          => 'required|string|max:30',
        'nik_ktp'           => 'required|string|max:50',
        'alamat'            => 'required|string|max:500',
        'jenis_aktivitas'   => 'required|string|in:pendakian,non_pendakian',
        'tipe_pendakian'    => 'nullable|string|in:tektok,camping',
        'tujuan_aktivitas'  => 'required|string|max:200',
        'tanggal_mulai'     => 'required|date',
        'foto_ktp'          => 'nullable|image|max:5120',
        'items_json'        => 'required|string',
        'total_price'       => 'required|integer',
        'catatan'           => 'nullable|string|max:500',
    ]);

    $items = json_decode($validated['items_json'], true);
    if (!is_array($items) || count($items) === 0) {
        return back()->withErrors(['items_json' => 'Daftar alat rental tidak boleh kosong.']);
    }

    $fotoPath = null;
    if ($request->hasFile('foto_ktp')) {
        $path = $request->file('foto_ktp')->store('ktp_photos', 'public');
        $fotoPath = '/storage/' . $path;
    }

    $dateStr = date('Ymd');
    $lastOrder = RentalOrder::where('order_code', 'like', "RNT-{$dateStr}-%")->orderBy('id', 'desc')->first();
    $sequence = 1;
    if ($lastOrder && preg_match('/-(\d+)$/', $lastOrder->order_code, $matches)) {
        $sequence = intval($matches[1]) + 1;
    }
    $orderCode = sprintf("RNT-%s-%04d", $dateStr, $sequence);

    $order = RentalOrder::create([
        'order_code'        => $orderCode,
        'nama_lengkap'      => $validated['nama_lengkap'],
        'nomor_wa'          => $validated['nomor_wa'],
        'nik_ktp'           => $validated['nik_ktp'],
        'alamat'            => $validated['alamat'],
        'jenis_aktivitas'   => $validated['jenis_aktivitas'],
        'tipe_pendakian'    => $request->input('tipe_pendakian') ?: null,
        'tujuan_aktivitas'  => $validated['tujuan_aktivitas'],
        'tanggal_mulai'     => $validated['tanggal_mulai'],
        'tanggal_selesai'   => date('Y-m-d', strtotime($validated['tanggal_mulai'] . ' +' . ($request->input('total_days') ?: 1) . ' days')),
        'tanggal_kembali'   => null,
        'foto_ktp'          => $fotoPath,
        'items'             => $items,
        'total_price'       => $validated['total_price'],
        'status'            => 'pending',
        'catatan'           => $validated['catatan'] ?? null,
    ]);

    // Decrement stock
    foreach ($items as $item) {
        $qty = $item['quantity'] ?? $item['days'] ?? 1;
        
        if (!empty($item['variant_id'])) {
            $variant = \App\Models\RentalEquipmentVariant::find($item['variant_id']);
            if ($variant && $variant->stock >= $qty) {
                $variant->decrement('stock', $qty);
            }
        } else if (!empty($item['slug'])) {
            $equipment = \App\Models\RentalEquipment::where('slug', $item['slug'])->first();
            if ($equipment && $equipment->stock >= $qty) {
                $equipment->decrement('stock', $qty);
            }
        }
    }

    return redirect()->route('rental.order-confirmation', ['order_code' => $orderCode]);
})->name('rental.process-biodata');

Route::get('/rental/order-confirmation/{order_code}', function ($order_code) {
    $order = RentalOrder::where('order_code', $order_code)->firstOrFail();
    return view('rental-order-confirmation', compact('order'));
})->name('rental.order-confirmation');

Route::get('/rental/{category}/{slug}', function ($category, $slug) {
    $product = RentalEquipment::with('variants')->where('slug', $slug)->where('is_visible', true)->firstOrFail();
    return view('rental-detail', compact('product', 'category'));
})->name('rental.show');

Route::get('/service', function () {
    return view('service');
});

Route::get('/service/cuci-alat', function () {
    $packages = CuciAlat::latest()->get();
    return view('cuci-alat', compact('packages'));
});

Route::post('/service/cuci-alat', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'nama'                    => 'required|string|max:100',
        'items'                   => 'required|array|min:1',
        'items.*.jenis_alat'      => 'required|string',
        'items.*.jumlah'          => 'required|integer|min:1',
        'items.*.catatan'         => 'nullable|string|max:500',
        'paket'                   => 'required',
    ]);

    $paket = CuciAlat::findOrFail($validated['paket']);

    $items = collect($validated['items'])->map(function ($item) {
        return [
            'jenis_alat' => $item['jenis_alat'],
            'jumlah'     => $item['jumlah'],
            'catatan'    => $item['catatan'] ?? '-',
        ];
    })->toArray();

    session([
        'cuci_alat_order' => [
            'nama'        => $validated['nama'],
            'items'       => $items,
            'paket_id'    => $paket->id,
            'paket_name'  => $paket->name,
            'paket_price' => $paket->price,
            'paket_unit'  => $paket->unit,
        ]
    ]);

    return redirect('/service/cuci-alat/checkout');
});

Route::get('/service/cuci-alat/checkout', function () {
    $order = session('cuci_alat_order');
    if (!$order) {
        return redirect('/service/cuci-alat');
    }
    return view('qris-cuci-alat', compact('order'));
});

Route::get('/service/open-trip', function () {
    $trips = OpenTrip::latest()->get();
    $guides = HikingGuide::latest()->get();
    return view('open-trip', compact('trips', 'guides'));
});

Route::get('/konfirmasi-pendaftaran/{id?}', function ($id = null) {
    $selectedTrip = $id ? OpenTrip::find($id) : OpenTrip::latest()->first();
    $allTrips = OpenTrip::latest()->get();
    return view('konfirmasi-pendaftaran', compact('selectedTrip', 'allTrips'));
})->name('opentrip.book');

Route::post('/service/open-trip/process-booking', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'trip_id'          => 'required',
        'penanggung_jawab' => 'required|string|max:100',
        'whatsapp'         => 'required|string|max:30',
        'jaminan_type'     => 'required|string|in:KTP,BPJS,SIM,PASPOR',
        'has_surat_sehat'  => 'required|in:Sudah,Belum',
        'anggota'          => 'nullable|array',
        'anggota.*.nama'   => 'required_with:anggota|string|max:100',
        'anggota.*.nik'    => 'required_with:anggota|string|max:50',
        'anggota.*.jaminan_type' => 'required_with:anggota|string|in:KTP,BPJS,SIM,PASPOR',
        'anggota.*.has_surat_sehat' => 'required_with:anggota|in:Sudah,Belum',
    ]);

    $trip = \App\Models\OpenTrip::findOrFail($validated['trip_id']);
    
    // Parse price string (e.g. "Rp 3.500.000" or "Rp 750k")
    $priceStr = preg_replace('/[^0-9]/', '', $trip->price);
    $priceNum = intval($priceStr);
    if (stripos($trip->price, 'k') !== false && $priceNum < 100000) {
        $priceNum *= 1000;
    }

    $anggotaList = [];
    if (!empty($validated['anggota'])) {
        foreach ($validated['anggota'] as $index => $a) {
            if (empty(trim($a['nama'] ?? ''))) continue;

            // Store pilihan jaminan and surat sehat status for anggota
            $anggotaList[] = [
                'nama' => $a['nama'],
                'nik' => $a['nik'],
                'foto_ktp' => $a['jaminan_type'] ?? null,
                'surat_sehat' => $a['has_surat_sehat'] ?? null,
            ];
        }
    }

    $totalPeserta = 1 + count($anggotaList);
    $totalTagihan = $priceNum * $totalPeserta;

    // For backward compatibility we reuse foto_ktp and surat_sehat columns to store the selected options
    $fotoKtpPath = $validated['jaminan_type'];
    $suratSehatPath = $validated['has_surat_sehat'];

    $dateStr = date('Ymd');
    $lastOrder = \App\Models\OpenTripOrder::where('order_code', 'like', "OT-{$dateStr}-%")->orderBy('id', 'desc')->first();
    $sequence = 1;
    if ($lastOrder && preg_match('/-(\d+)$/', $lastOrder->order_code, $matches)) {
        $sequence = intval($matches[1]) + 1;
    }
    $orderCode = sprintf("OT-%s-%04d", $dateStr, $sequence);

    $order = \App\Models\OpenTripOrder::create([
        'order_code'       => $orderCode,
        'trip_id'          => $trip->id,
        'penanggung_jawab' => $validated['penanggung_jawab'],
        'whatsapp'         => $validated['whatsapp'],
        'nik'              => '-',
        'foto_ktp'         => $fotoKtpPath,
        'surat_sehat'      => $suratSehatPath,
        'anggota'          => $anggotaList,
        'total_peserta'    => $totalPeserta,
        'total_tagihan'    => $totalTagihan,
        'status'           => 'pending',
    ]);

    return redirect()->route('opentrip.checkout', ['order_code' => $orderCode]);
})->name('opentrip.process');

Route::get('/service/open-trip/checkout/{order_code}', function ($order_code) {
    $orderModel = \App\Models\OpenTripOrder::with('trip')->where('order_code', $order_code)->firstOrFail();
    
    // Convert to structure expected by qris-open-trip view
    $order = [
        'trip_id'          => $orderModel->trip_id,
        'trip_title'       => $orderModel->trip->title,
        'trip_price'       => $orderModel->trip->price,
        'penanggung_jawab' => $orderModel->penanggung_jawab,
        'whatsapp'         => $orderModel->whatsapp,
        'nik'              => $orderModel->nik,
        'anggota'          => $orderModel->anggota,
        'total_peserta'    => $orderModel->total_peserta,
        'total_tagihan'    => $orderModel->total_tagihan,
    ];

    return view('qris-open-trip', compact('order'));
})->name('opentrip.checkout');

Route::get('/konfirmasi-booking-guide/{id?}', function ($id = null) {
    $selectedGuide = $id ? HikingGuide::find($id) : HikingGuide::latest()->first();
    $allGuides = HikingGuide::latest()->get();
    return view('konfirmasi-booking-guide', compact('selectedGuide', 'allGuides'));
})->name('guide.book');

Route::post('/service/guide/process-booking', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'guide_id'          => 'required',
        'ketua_tim'         => 'required|string|max:100',
        'whatsapp'          => 'required|string|max:30',
        'tanggal_pendakian' => 'required|date',
        'durasi_hari'       => 'required|integer|min:1',
        'jaminan_type'      => 'required|string|in:KTP,BPJS,SIM,PASPOR',
        'has_surat_sehat'   => 'required|in:Sudah,Belum',
        'anggota'           => 'nullable|array',
        'anggota.*.nama'    => 'required_with:anggota|string|max:100',
        'anggota.*.nik'     => 'required_with:anggota|string|max:50',
        'anggota.*.jaminan_type' => 'required_with:anggota|string|in:KTP,BPJS,SIM,PASPOR',
        'anggota.*.has_surat_sehat' => 'required_with:anggota|in:Sudah,Belum',
    ]);

    $guide = \App\Models\HikingGuide::findOrFail($validated['guide_id']);
    
    $priceStr = preg_replace('/[^0-9]/', '', $guide->price);
    $priceNum = intval($priceStr);
    if (stripos($guide->price, 'k') !== false && $priceNum < 100000) {
        $priceNum *= 1000;
    }

    $anggotaList = [];
    if (!empty($validated['anggota'])) {
        foreach ($validated['anggota'] as $index => $a) {
            if (empty(trim($a['nama'] ?? ''))) continue;

            $anggotaList[] = [
                'nama' => $a['nama'],
                'nik' => $a['nik'],
                'foto_ktp' => $a['jaminan_type'] ?? null,
                'surat_sehat' => $a['has_surat_sehat'] ?? null,
            ];
        }
    }

    $durasiHari = intval($validated['durasi_hari']);
    $totalTagihan = $priceNum * $durasiHari;

    $fotoKtpPath = $validated['jaminan_type'];
    $suratSehatPath = $validated['has_surat_sehat'];

    $dateStr = date('Ymd');
    $lastOrder = \App\Models\HikingGuideOrder::where('order_code', 'like', "GD-{$dateStr}-%")->orderBy('id', 'desc')->first();
    $sequence = 1;
    if ($lastOrder && preg_match('/-(\d+)$/', $lastOrder->order_code, $matches)) {
        $sequence = intval($matches[1]) + 1;
    }
    $orderCode = sprintf("GD-%s-%04d", $dateStr, $sequence);

    $order = \App\Models\HikingGuideOrder::create([
        'order_code'        => $orderCode,
        'guide_id'          => $guide->id,
        'ketua_tim'         => $validated['ketua_tim'],
        'whatsapp'          => $validated['whatsapp'],
        'tanggal_pendakian' => $validated['tanggal_pendakian'],
        'durasi_hari'       => $durasiHari,
        'foto_ktp'          => $fotoKtpPath,
        'surat_sehat'       => $suratSehatPath,
        'anggota'           => $anggotaList,
        'total_peserta'     => 1 + count($anggotaList),
        'total_tagihan'     => $totalTagihan,
        'status'            => 'pending',
    ]);

    return redirect()->route('guide.checkout', ['order_code' => $orderCode]);
})->name('guide.process');

Route::get('/service/guide/checkout/{order_code}', function ($order_code) {
    $orderModel = \App\Models\HikingGuideOrder::with('guide')->where('order_code', $order_code)->firstOrFail();
    
    // Convert to structure expected by qris-booking-guide view
    $order = [
        'guide_id'          => $orderModel->guide_id,
        'guide_title'       => $orderModel->guide->title,
        'guide_price'       => $orderModel->guide->price,
        'guide_unit'        => $orderModel->guide->unit ?? 'Hari',
        'ketua_tim'         => $orderModel->ketua_tim,
        'whatsapp'          => $orderModel->whatsapp,
        'tanggal_pendakian' => $orderModel->tanggal_pendakian->format('Y-m-d'),
        'durasi_hari'       => $orderModel->durasi_hari,
        'anggota'           => $orderModel->anggota,
        'total_peserta'     => $orderModel->total_peserta,
        'total_tagihan'     => $orderModel->total_tagihan,
    ];

    return view('qris-booking-guide', compact('order'));
})->name('guide.checkout');

Route::get('/service/marketplace', function (\Illuminate\Http\Request $request) {
    $items = MarketplaceItem::all();

    // 1. Filter Kategori
    if ($request->filled('category') && $request->category !== 'all') {
        $items = $items->where('category', $request->category);
    }

    // 2. Filter Kondisi (Bekas/Baru)
    if ($request->filled('kondisi')) {
        $kondisi = (array) $request->kondisi;
        $items = $items->filter(function($item) use ($kondisi) {
            $badge = strtolower($item->condition_badge ?? '');
            foreach ($kondisi as $k) {
                if (str_contains($badge, strtolower($k))) return true;
            }
            return false;
        });
    }

    // 3. Sorting
    $sort = $request->input('sort', 'terbaru');
    if ($sort === 'terendah') {
        $items = $items->sortBy(function($item) {
            return (int) preg_replace('/[^0-9]/', '', $item->price);
        });
    } elseif ($sort === 'tertinggi') {
        $items = $items->sortByDesc(function($item) {
            return (int) preg_replace('/[^0-9]/', '', $item->price);
        });
    } else {
        $items = $items->sortByDesc('created_at');
    }

    return view('marketplace', compact('items'));
});

Route::get('/service/marketplace/{id}', function ($id) {
    $item = MarketplaceItem::findOrFail($id);
    return view('marketplace-detail', compact('item'));
})->name('marketplace.detail');

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

use App\Models\Visit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

Route::get('/dashboard', function () {

    $start = Carbon::today()->subDays(6)->startOfDay();
    $end   = Carbon::today()->endOfDay();

    // ── 7-day visitor chart (public pages only, exclude admin/dashboard)
    $rows = Visit::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
        ->where('path', 'not like', '/dashboard%')
        ->where('path', 'not like', '/admin%')
        ->whereBetween('created_at', [$start, $end])
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->keyBy('date');

    $labels = [];
    $data   = [];
    for ($i = 6; $i >= 0; $i--) {
        $d       = Carbon::today()->subDays($i)->format('Y-m-d');
        $labels[] = Carbon::createFromFormat('Y-m-d', $d)->translatedFormat('d M');
        $data[]  = $rows->has($d) ? (int) $rows->get($d)->total : 0;
    }
    $visitorChart = ['labels' => $labels, 'data' => $data];

    // ── Summary stats
    $totalVisitors  = Visit::where('path', 'not like', '/dashboard%')
                           ->where('path', 'not like', '/admin%')->count();
    $todayVisitors  = Visit::where('path', 'not like', '/dashboard%')
                           ->whereDate('created_at', Carbon::today())->count();
    $yesterdayVisitors = Visit::where('path', 'not like', '/dashboard%')
                              ->whereDate('created_at', Carbon::yesterday())->count();
    $uniqueIpsToday = Visit::where('path', 'not like', '/dashboard%')
                           ->whereDate('created_at', Carbon::today())
                           ->distinct('ip')->count('ip');

    // ── Top 5 pages this week
    $topPages = Visit::select('path', DB::raw('count(*) as hits'))
        ->where('path', 'not like', '/dashboard%')
        ->where('path', 'not like', '/admin%')
        ->whereBetween('created_at', [$start, $end])
        ->groupBy('path')
        ->orderByDesc('hits')
        ->limit(5)
        ->get();

    // ── Recent visitors
    $recentVisits = Visit::latest()->limit(8)->get();

    // ── Rental orders & items per day
    $orders = \App\Models\RentalOrder::select('created_at', 'items')
        ->whereBetween('created_at', [$start, $end])
        ->get();

    $orderData = [];
    $itemData  = [];
    for ($i = 6; $i >= 0; $i--) {
        $d = Carbon::today()->subDays($i)->format('Y-m-d');
        $orderData[$d] = 0;
        $itemData[$d]  = 0;
    }
    foreach ($orders as $order) {
        $date = $order->created_at->format('Y-m-d');
        if (isset($orderData[$date])) {
            $orderData[$date]++;
            $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
            if (is_array($items)) $itemData[$date] += count($items);
        }
    }
    $orderChart = [
        'labels'    => $labels,
        'data'      => array_values($orderData),
        'item_data' => array_values($itemData),
    ];

    $totalOrders = \App\Models\RentalOrder::count();
    $todayOrders = \App\Models\RentalOrder::whereDate('created_at', Carbon::today())->count();

    return view('dashboard', compact(
        'recentVisits', 'visitorChart', 'orderChart',
        'totalVisitors', 'todayVisitors', 'yesterdayVisitors',
        'uniqueIpsToday', 'topPages', 'totalOrders', 'todayOrders'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('admin/rentals', RentalController::class)->except(['create', 'show', 'edit'])->names('admin.rentals');
    Route::patch('admin/rentals/{rental}/toggle-visible', [RentalController::class, 'toggleVisible'])->name('admin.rentals.toggle-visible');
    Route::post('admin/rentals/{rental}/sell', [RentalController::class, 'sellToMarketplace'])->name('admin.rentals.sell');
    Route::resource('admin/mountains', \App\Http\Controllers\Admin\MountainController::class)->except(['create', 'show', 'edit'])->names('admin.mountains');
    Route::patch('admin/mountains/{mountain}/toggle-visible', [\App\Http\Controllers\Admin\MountainController::class, 'toggleVisible'])->name('admin.mountains.toggle-visible');
    Route::resource('admin/open-trips', OpenTripController::class)->except(['create', 'show', 'edit'])->names('admin.open-trips');
    Route::resource('admin/cuci-alats', CuciAlatController::class)->except(['create', 'show', 'edit'])->names('admin.cuci-alats');
    Route::resource('admin/marketplaces', MarketplaceController::class)->except(['create', 'show', 'edit'])->names('admin.marketplaces');
    Route::resource('admin/hiking-guides', HikingGuideController::class)->except(['create', 'show', 'edit'])->names('admin.hiking-guides');
    Route::resource('admin/rental-orders', RentalOrderController::class)->names('admin.rental-orders');
    Route::resource('admin/testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->except(['create', 'show', 'edit'])->names('admin.testimonials');

    // Admin visits listing
    Route::get('admin/visits', [\App\Http\Controllers\Admin\VisitController::class, 'index'])->name('admin.visits.index');
    Route::delete('admin/visits/{visit}', [\App\Http\Controllers\Admin\VisitController::class, 'destroy'])->name('admin.visits.destroy');

    Route::get('admin/qris-setting', [QrisSettingController::class, 'index'])->name('admin.qris.index');
    Route::post('admin/qris-setting', [QrisSettingController::class, 'update'])->name('admin.qris.update');

    Route::resource('admin/pendaki-bergabung', PendakiBergabungController::class)
        ->except(['create', 'show', 'edit'])
        ->names('admin.pendaki-bergabung');

    Route::resource('admin/open-trip-orders', \App\Http\Controllers\Admin\OpenTripOrderController::class)->only(['index', 'destroy'])->names('admin.open-trip-orders');
    Route::patch('admin/open-trip-orders/{order}/status', [\App\Http\Controllers\Admin\OpenTripOrderController::class, 'updateStatus'])->name('admin.open-trip-orders.status');
    Route::delete('admin/open-trip-orders-delete-all', [\App\Http\Controllers\Admin\OpenTripOrderController::class, 'deleteAll'])->name('admin.open-trip-orders.delete-all');

    Route::resource('admin/hiking-guide-orders', \App\Http\Controllers\Admin\HikingGuideOrderController::class)->only(['index', 'destroy'])->names('admin.hiking-guide-orders');
    Route::patch('admin/hiking-guide-orders/{order}/status', [\App\Http\Controllers\Admin\HikingGuideOrderController::class, 'updateStatus'])->name('admin.hiking-guide-orders.status');
    Route::delete('admin/hiking-guide-orders-delete-all', [\App\Http\Controllers\Admin\HikingGuideOrderController::class, 'deleteAll'])->name('admin.hiking-guide-orders.delete-all');
});

Route::get('/admin-login', function () {
    return redirect()->route('login');
});

Route::get('/login-admin', function () {
    return redirect()->route('login');
});

Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);
    if (!file_exists($file)) {
        abort(404);
    }
    return response()->file($file);
})->where('path', '.*');

Route::get('/sitemap.xml', function () {
    $mountains = \App\Models\Mountain::where('is_visible', true)->get();
    $equipments = \App\Models\RentalEquipment::where('is_visible', true)->get();

    $content = view('sitemap', compact('mountains', 'equipments'));
    return response($content, 200)->header('Content-Type', 'text/xml');
});

require __DIR__.'/auth.php';