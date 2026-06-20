@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- TOP NAVBAR OVERVIEW / HEADER --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mt-1">Sistem Analitik PT Medlab Nusantara</p>
        </div>
        
        {{-- Date Filter Dropdown --}}
        <div>
            <form id="filterRentang" action="{{ url()->current() }}" method="GET">
                <select name="rentang" onchange="document.getElementById('filterRentang').submit()" class="bg-white border border-gray-100 text-sm font-semibold text-gray-600 px-6 py-2.5 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500/20">
                    <option value="12_bulan" {{ (request('rentang') ?? '12_bulan') == '12_bulan' ? 'selected' : '' }}>12 Bulan Terakhir</option>
                    <option value="30_hari" {{ request('rentang') == '30_hari' ? 'selected' : '' }}>30 Hari Terakhir</option>
                    <option value="7_hari" {{ request('rentang') == '7_hari' ? 'selected' : '' }}>7 Hari Terakhir</option>
                </select>
            </form>
        </div>
    </div>

    {{-- 1. FOUR TOP METRIC CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        
        <div class="relative">
            <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
            <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Total Penawaran</p>
                    <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $totalPenawaran }}</h3>
                </div>
                <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                    <i class="fa-solid fa-file-invoice text-white text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
            <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Total Invoice</p>
                    <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $invoiceBulanIni }}</h3>
                </div>
                <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                    <i class="fa-solid fa-wallet text-white text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
            <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Penawaran Masuk</p>
                    <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $penawaranMasuk }}</h3>
                </div>
                <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                    <i class="fa-solid fa-envelope-open-text text-white text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
            <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Pelanggan Aktif</p>
                    <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $pelangganAktif }}</h3>
                </div>
                <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                    <i class="fa-solid fa-users text-white text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. MIDDLE GRAPH & TOP PRODUCTS ROW --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-gray-800">Grafik Penawaran</h2>
                <span class="text-[10px] bg-red-50 text-red-700 font-bold px-2 py-0.5 rounded-md uppercase tracking-wide">Real-time</span>
            </div>
            <div class="h-[280px] w-full">
                <canvas id="chartPenawaran"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="mb-4">
                <h2 class="text-sm font-bold text-gray-800">Top Produk Terlaris</h2>
                <p class="text-[10px] text-gray-400 mt-0.5">Berdasarkan invoice berstatus lunas</p>
            </div>
            <div class="space-y-3.5">
                @forelse ($topProduk as $index => $prod)
                    <div class="flex items-center justify-between border-b border-gray-50 pb-2.5 last:border-0 last:pb-0 gap-2">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="w-7 h-7 rounded-lg font-bold text-xs flex items-center justify-center flex-shrink-0
                                {{ $index == 0 ? 'bg-red-700 text-white shadow-sm' : 'bg-gray-50 border border-gray-100 text-gray-500' }}">
                                {{ $index + 1 }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold text-gray-700 truncate" title="{{ $prod->nama_produk }}">{{ $prod->nama_produk }}</p>
                                <p class="text-[10px] text-gray-400 truncate" title="{{ $prod->pabrikan ? $prod->pabrikan->nama_pabrikan : 'Tanpa Pabrikan' }}">{{ $prod->pabrikan ? $prod->pabrikan->nama_pabrikan : 'Tanpa Pabrikan' }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black uppercase bg-red-50 border border-red-100 text-red-600 px-2 py-1 rounded-md flex-shrink-0" title="Kategori: {{ $prod->kategori }}">
                            {{ $prod->total_terjual ?? 0 }} Terjual
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-8">Belum ada data produk.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- 3. BOTTOM TABLES ROW (PENAWARAN TERBARU & AUDIT TRAIL LOG) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-800">Penawaran Terbaru</h2>
                    <a href="{{ route('admin.penawaran.index') }}" class="text-xs font-bold text-red-700 hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[10px] font-black text-gray-300 uppercase tracking-wider bg-gray-50/50">
                                <th class="py-3 px-4 font-semibold">Nama Pelanggan</th>
                                <th class="py-3 px-4 font-semibold">Tanggal</th>
                                <th class="py-3 px-4 font-semibold text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs text-gray-600 divide-y divide-gray-50">
                            @forelse ($penawaranTerbaru as $pnw)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 px-4 font-bold text-gray-700">
                                        {{ $pnw->user ? $pnw->user->name : 'Guest' }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-400">
                                        {{ $pnw->created_at->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        @if($pnw->status == 'pending')
                                            <span class="px-2 py-1 rounded text-[9px] font-black uppercase tracking-tighter bg-amber-50 text-amber-600 border border-amber-100">
                                                Pending
                                            </span>
                                        @elseif($pnw->status == 'disetujui')
                                            <span class="px-2 py-1 rounded text-[9px] font-black uppercase tracking-tighter bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                Disetujui
                                            </span>
                                        @else
                                            <span class="px-2 py-1 rounded text-[9px] font-black uppercase tracking-tighter bg-red-50 text-red-600 border border-red-100">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-400">Belum ada penawaran masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-800">Aktivitas Sistem Terbaru</h2>
                    <a href="{{ route('log.index') }}" class="text-xs font-bold text-red-700 hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[10px] font-black text-gray-300 uppercase tracking-wider bg-gray-50/50">
                                <th class="py-3 px-4 font-semibold">User</th>
                                <th class="py-3 px-4 font-semibold">Aktivitas</th>
                                <th class="py-3 px-4 font-semibold text-right">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs text-gray-600 divide-y divide-gray-50">
                            @forelse ($aktivitasSistem as $log)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 px-4 font-bold text-gray-700">
                                        {{ $log->causer ? $log->causer->name : 'Sistem' }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-500 max-w-[180px] truncate" title="{{ $log->description }}">
                                        {{ $log->description }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-400 text-right font-medium">
                                        {{ $log->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-400">Belum ada log aktivitas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- CHART.JS INTEGRATION SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('chartPenawaran').getContext('2d');
            
            const gradient = ctx.createLinearGradient(0, 0, 0, 260);
            gradient.addColorStop(0, 'rgba(185, 28, 28, 0.25)');
            gradient.addColorStop(1, 'rgba(185, 28, 28, 0.0)');

            const labelsHari = @json($grafikTanggal);
            const dataJumlah = @json($grafikData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelsHari,
                    datasets: [{
                        label: 'Penawaran Masuk',
                        data: dataJumlah,
                        borderColor: '#b91c1c',
                        borderWidth: 3,
                        fill: true,
                        backgroundColor: gradient,
                        tension: 0.35,
                        pointBackgroundColor: '#b91c1c',
                        pointHoverBackgroundColor: '#ffffff',
                        pointHoverBorderColor: '#b91c1c',
                        pointHoverBorderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            grid: { color: '#f9fafb' },
                            ticks: { font: { size: 10, weight: '500' }, color: '#9ca3af' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '500' }, color: '#9ca3af' }
                        }
                    }
                }
            });
        });
    </script>

@endsection