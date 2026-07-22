@php use Illuminate\Support\Str; @endphp

<x-app-layout>
    <x-slot name="header">
        Daftar Pengunjung
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
                <div class="bg-white rounded-2xl border p-4">
            <form method="GET" class="flex gap-2 items-end flex-wrap">
                <div>
                    <label class="text-xs text-slate-500">Dari</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="mt-1 p-2 border rounded" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Sampai</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="mt-1 p-2 border rounded" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Kota / Kecamatan</label>
                    <input type="text" name="city" value="{{ request('city') }}" class="mt-1 p-2 border rounded" placeholder="kota atau kecamatan" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">IP</label>
                    <input type="text" name="ip" value="{{ request('ip') }}" class="mt-1 p-2 border rounded" placeholder="127.0.0.1" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Path</label>
                    <input type="text" name="path" value="{{ request('path') }}" class="mt-1 p-2 border rounded" placeholder="/welcome" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">User ID</label>
                    <input type="text" name="user_id" value="{{ request('user_id') }}" class="mt-1 p-2 border rounded" placeholder="123" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Per Halaman</label>
                    <select name="per_page" class="mt-1 p-2 border rounded">
                        @foreach([10,15,25,50] as $n)
                            <option value="{{ $n }}" {{ request('per_page', 15) == $n ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="ml-auto">
                    <button class="px-4 py-2 bg-primary text-white rounded">Filter</button>
                    <a href="{{ route('admin.visits.index') }}" class="ml-2 px-4 py-2 border rounded">Reset</a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl border overflow-hidden">
            <div class="p-4 border-b flex items-center justify-between">
                <div>
                    <h3 class="font-bold">Daftar Pengunjung</h3>
                    <p class="text-xs text-slate-400">Hasil filter: {{ $visits->total() }} entri</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 text-xs uppercase font-['JetBrains_Mono']">
                        <tr>
                            <th class="py-3.5 px-6 font-semibold">Waktu</th>
                            <th class="py-3.5 px-4 font-semibold">IP</th>
                            <th class="py-3.5 px-4 font-semibold">Kecamatan</th>
                            <th class="py-3.5 px-4 font-semibold">Kota / Region</th>
                            <th class="py-3.5 px-4 font-semibold">Path</th>
                            <th class="py-3.5 px-4 font-semibold">User</th>
                            <th class="py-3.5 px-6 font-semibold">User Agent</th>
                            <th class="py-3.5 px-6 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs sm:text-sm">
                        @forelse($visits as $v)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-4 px-6 font-['JetBrains_Mono']">{{ $v->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-4 px-4">{{ $v->ip ?? '-' }}</td>
                                <td class="py-4 px-4">{{ $v->kecamatan ?? '-' }}</td>
                                <td class="py-4 px-4">{{ $v->city ? $v->city . ($v->region ? ' / '.$v->region : '') : '-' }}</td>
                                <td class="py-4 px-4">{{ $v->path }}</td>
                                <td class="py-4 px-4">{{ $v->user_id ? 'User #' . $v->user_id : '-' }}</td>
                                <td class="py-4 px-6 text-slate-400 truncate max-w-[400px]">{{ Str::limit($v->user_agent, 160) }}</td>
                                <td class="py-4 px-6">
                                    <form action="{{ route('admin.visits.destroy', $v) }}" method="POST" onsubmit="return confirm('Hapus entri pengunjung ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 rounded bg-red-50 text-red-700 text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">Tidak ada data.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t bg-slate-50 flex items-center justify-between">
                <div class="text-xs text-slate-500">Menampilkan {{ $visits->count() }} dari {{ $visits->total() }} entri</div>
                <div>
                    {{ $visits->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
