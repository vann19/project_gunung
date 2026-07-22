<x-app-layout>
    <x-slot name="header">Dashboard Overview</x-slot>

    <div class="space-y-6 max-w-7xl mx-auto">

        {{-- Welcome Banner --}}
        <div class="relative overflow-hidden rounded-2xl bg-primary p-6 sm:p-8 text-white shadow-xl">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/5 rounded-full pointer-events-none"></div>
            <div class="absolute -left-8 -bottom-8 w-48 h-48 bg-white/5 rounded-full pointer-events-none"></div>
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-[11px] font-mono uppercase tracking-widest bg-white/10 border border-white/20 mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Administrator Panel
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-white/70 text-sm mt-1 max-w-lg">Pantau kunjungan website, pesanan rental, dan semua aktivitas layanan dalam satu dashboard.</p>
                </div>
                <a href="{{ route('admin.rentals.index') }}" class="shrink-0 px-5 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/20 text-white font-semibold text-sm transition inline-flex items-center gap-2">
                    Kelola Rental
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

        {{-- Metric Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Total Kunjungan --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(0,94,151,0.1)">
                        <svg class="w-5 h-5" style="color:#005E97" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-md bg-blue-50 text-blue-600 border border-blue-100">All-time</span>
                </div>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($totalVisitors) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Total Kunjungan Publik</p>
            </div>

            {{-- Hari Ini --}}
            @php $vsYesterday = $yesterdayVisitors > 0 ? round((($todayVisitors - $yesterdayVisitors) / $yesterdayVisitors) * 100, 1) : 0; @endphp
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(16,185,129,0.1)">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    @if($vsYesterday >= 0)
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 border border-emerald-100">+{{ $vsYesterday }}%</span>
                    @else
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-md bg-red-50 text-red-600 border border-red-100">{{ $vsYesterday }}%</span>
                    @endif
                </div>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($todayVisitors) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Kunjungan Hari Ini</p>
            </div>

            {{-- IP Unik --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-violet-50">
                        <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-md bg-violet-50 text-violet-600 border border-violet-100">Unik</span>
                </div>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($uniqueIpsToday) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">IP Unik Hari Ini</p>
            </div>

            {{-- Pesanan Rental --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-amber-50">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-md bg-amber-50 text-amber-600 border border-amber-100">Hari ini: {{ $todayOrders }}</span>
                </div>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($totalOrders) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Total Pesanan Rental</p>
            </div>

        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main Area Chart --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 pt-6 pb-4">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Tren Aktivitas Website</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Kunjungan publik vs pesanan rental — 7 hari terakhir</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-lg whitespace-nowrap">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>Live
                        </span>
                    </div>
                    {{-- Legend badges --}}
                    <div class="flex flex-wrap gap-2">
                        <div class="flex items-center gap-2 bg-slate-50 rounded-lg px-3 py-1.5 border border-slate-100">
                            <span class="w-2.5 h-2.5 rounded-full" style="background:#005E97"></span>
                            <span class="text-xs text-slate-500">Kunjungan</span>
                            <span class="text-xs font-bold text-slate-900">{{ number_format($totalVisitors) }}</span>
                        </div>
                        <div class="flex items-center gap-2 bg-slate-50 rounded-lg px-3 py-1.5 border border-slate-100">
                            <span class="w-2.5 h-2.5 rounded-full" style="background:#f59e0b"></span>
                            <span class="text-xs text-slate-500">Pesanan</span>
                            <span class="text-xs font-bold text-slate-900">{{ number_format(array_sum($orderChart['data'] ?? [])) }}</span>
                        </div>
                        <div class="flex items-center gap-2 bg-slate-50 rounded-lg px-3 py-1.5 border border-slate-100">
                            <span class="w-2.5 h-2.5 rounded-full" style="background:#10b981"></span>
                            <span class="text-xs text-slate-500">Barang</span>
                            <span class="text-xs font-bold text-slate-900">{{ number_format(array_sum($orderChart['item_data'] ?? [])) }}</span>
                        </div>
                    </div>
                </div>
                <div class="px-3 pb-5 h-[280px]">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>

            {{-- Bar Chart: Rental --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <div class="px-6 pt-6 pb-4 border-b border-slate-100">
                    <div class="flex items-start justify-between mb-1">
                        <div>
                            <p class="text-xs text-slate-400">Pesanan Minggu Ini</p>
                            <h3 class="text-2xl font-bold text-slate-900">{{ number_format(array_sum($orderChart['data'] ?? [])) }}</h3>
                        </div>
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold px-2 py-1 rounded-md">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                            Aktif
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-2 divide-x divide-slate-100 border-b border-slate-100">
                    <div class="px-5 py-3">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wide font-semibold">Barang</p>
                        <p class="text-base font-bold text-slate-900 mt-0.5">{{ number_format(array_sum($orderChart['item_data'] ?? [])) }}<span class="text-xs font-normal text-slate-400 ml-1">item</span></p>
                    </div>
                    <div class="px-5 py-3">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wide font-semibold">Rata-rata</p>
                        <p class="text-base font-bold text-slate-900 mt-0.5">{{ round(array_sum($orderChart['data'] ?? []) / 7, 1) }}<span class="text-xs font-normal text-slate-400 ml-1">/hari</span></p>
                    </div>
                </div>
                <div class="px-5 pt-3 pb-1 flex items-center gap-3">
                    <span class="flex items-center gap-1.5 text-[11px] text-slate-500"><span class="w-2.5 h-2.5 rounded-sm" style="background:#005E97"></span>Pesanan</span>
                    <span class="flex items-center gap-1.5 text-[11px] text-slate-500"><span class="w-2.5 h-2.5 rounded-sm" style="background:#10b981"></span>Barang</span>
                </div>
                <div class="flex-1 px-4 pb-2" style="height:150px">
                    <canvas id="rentalBarChart"></canvas>
                </div>
                <div class="px-6 py-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-400 font-medium">7 hari terakhir</span>
                    <a href="{{ route('admin.rental-orders.index') }}" class="text-xs font-bold px-3 py-1.5 rounded-lg transition" style="color:#005E97;background:rgba(0,94,151,0.08)">
                        Lihat Laporan →
                    </a>
                </div>
            </div>
        </div>

        {{-- Bottom Row: Top Pages + Recent Visits --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Top Pages --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Halaman Terpopuler</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Top 5 halaman minggu ini</p>
                    </div>
                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div class="divide-y divide-slate-50">
                    @php $maxHits = $topPages->max('hits') ?: 1; @endphp
                    @forelse($topPages as $i => $page)
                    <div class="px-6 py-3.5">
                        <div class="flex items-center justify-between mb-1.5">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="text-[11px] font-mono font-bold text-slate-400 w-4">{{ $i + 1 }}</span>
                                <span class="text-sm text-slate-700 font-medium truncate">{{ $page->path }}</span>
                            </div>
                            <span class="text-xs font-bold text-slate-900 ml-3 shrink-0">{{ number_format($page->hits) }}</span>
                        </div>
                        <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all" style="width:{{ round(($page->hits / $maxHits) * 100) }}%; background:#005E97"></div>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada data kunjungan minggu ini.</div>
                    @endforelse
                </div>
            </div>

            {{-- Recent Visitors --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Kunjungan Terbaru</h3>
                        <p class="text-xs text-slate-400 mt-0.5">8 aktivitas terakhir yang masuk</p>
                    </div>
                    <a href="{{ route('admin.visits.index') }}" class="text-xs font-bold" style="color:#005E97">Lihat semua →</a>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse($recentVisits as $visit)
                    <div class="px-6 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-700 font-mono">{{ $visit->ip ?? '-' }}</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 font-medium truncate max-w-[100px]">{{ $visit->path }}</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5 truncate">{{ $visit->created_at->diffForHumans() }}</p>
                        </div>
                        @if($visit->user_id)
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-primary/10 text-primary">Admin</span>
                        @endif
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada kunjungan tercatat.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    (function () {
        const COLORS = { primary: '#005E97', amber: '#f59e0b', emerald: '#10b981' };

        const payload = {
            labels: @json($visitorChart['labels'] ?? []),
            visits: @json($visitorChart['data'] ?? []),
            orders: @json($orderChart['data'] ?? []),
            items:  @json($orderChart['item_data'] ?? [])
        };

        // ── Area Chart ──────────────────────────────────────────────
        const mainCanvas = document.getElementById('mainChart');
        if (mainCanvas) {
            const ctx = mainCanvas.getContext('2d');

            const mkGradient = (r, g, b) => {
                const g1 = ctx.createLinearGradient(0, 0, 0, 280);
                g1.addColorStop(0, `rgba(${r},${g},${b},0.30)`);
                g1.addColorStop(1, `rgba(${r},${g},${b},0.00)`);
                return g1;
            };

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: payload.labels,
                    datasets: [
                        { label: 'Kunjungan',  data: payload.visits, borderColor: COLORS.primary,  backgroundColor: mkGradient(0,94,151),   borderWidth: 2.5, tension: 0.4, fill: true, pointRadius: 0, pointHoverRadius: 5 },
                        { label: 'Pesanan',    data: payload.orders, borderColor: COLORS.amber,    backgroundColor: mkGradient(245,158,11),  borderWidth: 2.5, tension: 0.4, fill: true, pointRadius: 0, pointHoverRadius: 5 },
                        { label: 'Barang',     data: payload.items,  borderColor: COLORS.emerald,  backgroundColor: mkGradient(16,185,129),  borderWidth: 2.5, tension: 0.4, fill: true, pointRadius: 0, pointHoverRadius: 5 }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15,23,42,0.92)', cornerRadius: 10,
                            padding: 12, displayColors: true,
                            titleFont: { size: 12, weight: 'bold' }, bodyFont: { size: 12 }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 11 } } },
                        y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { display: false } }
                    }
                }
            });
        }

        // ── Bar Chart ───────────────────────────────────────────────
        const barCanvas = document.getElementById('rentalBarChart');
        if (barCanvas) {
            new Chart(barCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: payload.labels,
                    datasets: [
                        { label: 'Pesanan', data: payload.orders, backgroundColor: COLORS.primary, borderRadius: 5, barThickness: 10 },
                        { label: 'Barang',  data: payload.items,  backgroundColor: COLORS.emerald, borderRadius: 5, barThickness: 10 }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: 'rgba(15,23,42,0.92)', cornerRadius: 8, padding: 10, displayColors: true, bodyFont: { size: 11 } }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 } } },
                        y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { display: false } }
                    }
                }
            });
        }
    })();
    </script>
    @endpush

</x-app-layout>
