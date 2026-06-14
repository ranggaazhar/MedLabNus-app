@extends('admin.layouts.app')

@section('title', 'Riwayat Mutasi Stok')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Riwayat Mutasi Stok</h1>
    <p class="text-sm text-gray-500 font-medium italic">Riwayat Stok PT Medlab Nusantara</p>
</div>

{{-- FILTER SECTION --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
    <form action="{{ route('stok-mutasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block ml-1">Pencarian</label>
            <input type="text" name="search" value="{{ $search }}" placeholder="Nama produk..." 
                class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-red-500 text-sm transition-all">
        </div>
        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block ml-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $start_date }}" 
                class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-red-500 text-sm transition-all">
        </div>
        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block ml-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $end_date }}" 
                class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-red-500 text-sm transition-all">
        </div>
        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block ml-1">Tipe Mutasi</label>
            <select name="tipe" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-red-500 text-sm transition-all">
                <option value="">Semua Data</option>
                <option value="masuk" {{ $tipe == 'masuk' ? 'selected' : '' }}>Stok Masuk (+)</option>
                <option value="keluar" {{ $tipe == 'keluar' ? 'selected' : '' }}>Stok Keluar (-)</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-red-600 text-white font-bold py-2.5 rounded-lg hover:bg-red-700 transition shadow-lg shadow-red-100">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
            <a href="{{ route('stok-mutasi.index') }}" class="p-2.5 bg-gray-100 text-gray-400 rounded-lg hover:bg-gray-200 transition" title="Reset">
                <i class="fas fa-sync-alt"></i>
            </a>
        </div>
    </form>
</div>

{{-- TABEL DATA (PAGINATION) --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-5 border-b border-gray-50 flex justify-between items-center bg-white">
        <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Detail Transaksi</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left table-mutasi">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Waktu & Admin</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Informasi Produk</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-center">Tipe</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-right">Qty</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Catatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($mutasis as $mutasi)
                <tr class="hover:bg-gray-50/30 transition">
                    <td class="px-6 py-4" data-label="Waktu & Admin">
                        <div class="text-sm font-bold text-gray-700">{{ $mutasi->created_at->translatedFormat('d M Y, H:i') }}</div>
                        <div class="text-[10px] text-gray-400 flex items-center gap-1 mt-1 font-medium">
                            <i class="fas fa-user-edit text-[8px]"></i> {{ $mutasi->user->name ?? 'System' }}
                        </div>
                    </td>
                    <td class="px-6 py-4" data-label="Produk">
                        <div class="text-sm font-black text-gray-800">{{ $mutasi->produk->nama_produk ?? 'N/A' }}</div>
                        <div class="text-[10px] text-red-500 font-bold uppercase">{{ $mutasi->produk->pabrikan->nama_pabrikan ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-center" data-label="Tipe">
                        <span class="px-2 py-1 rounded text-[9px] font-black uppercase tracking-tighter border
                            {{ $mutasi->tipe == 'masuk' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-red-50 text-red-600 border-red-100' }}">
                            {{ $mutasi->tipe }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right" data-label="Qty">
                        <span class="text-sm font-black {{ $mutasi->tipe == 'masuk' ? 'text-emerald-600' : 'text-red-600' }}">
                            {{ $mutasi->tipe == 'masuk' ? '+' : '-' }}{{ number_format($mutasi->jumlah) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-[11px] text-gray-500 italic max-w-[200px] truncate" data-label="Catatan">
                        {{ $mutasi->keterangan }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic text-sm">Data mutasi tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-2 border-t border-gray-100 bg-gray-50/30">
        {{ $mutasis->links('partials.pagination') }}
    </div>
</div>

{{-- GRAFIK VISUALISASI (DIBAWAH) --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-3">
        <div>
            <h3 class="text-base sm:text-lg font-bold text-gray-800">Grafik Stok Mutasi</h3>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-0.5">Visualisasi Stok Medlab Nusantara</p>
        </div>
        <div class="flex items-center gap-3 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-100 self-start md:self-center">
            <div class="flex items-center gap-1.5">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm"></div>
                <span class="text-[9px] font-black text-gray-500 uppercase">Masuk</span>
            </div>
            <div class="w-px h-3 bg-gray-200 mx-1"></div>
            <div class="flex items-center gap-1.5">
                <div class="w-2.5 h-2.5 rounded-full bg-red-600 shadow-sm"></div>
                <span class="text-[9px] font-black text-gray-500 uppercase">Keluar</span>
            </div>
        </div>
    </div>
    
    <div id="chart-mutasi" class="w-full"></div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var isMobile = window.innerWidth < 768;

        var options = {
            series: [{
                name: 'Barang Masuk',
                data: @json($stokMasuk)
            }, {
                name: 'Barang Keluar',
                data: @json($stokKeluar)
            }],
            chart: {
                type: 'area',
                height: isMobile ? 220 : 320,
                fontFamily: 'Plus Jakarta Sans, sans-serif',
                toolbar: { show: false },
                zoom: { enabled: false },
                animations: { enabled: true, easing: 'easeinout', speed: 600 }
            },
            colors: ['#10B981', '#DC2626'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.25,
                    opacityTo: 0.01,
                    stops: [0, 90, 100]
                }
            },
            stroke: { curve: 'smooth', width: isMobile ? 2.5 : 3.5 },
            dataLabels: { enabled: false },
            xaxis: {
                categories: @json($days),
                labels: {
                    rotate: isMobile ? -45 : 0,
                    rotateAlways: isMobile,
                    hideOverlappingLabels: true,
                    trim: true,
                    style: {
                        colors: '#94A3B8',
                        fontWeight: 700,
                        fontSize: isMobile ? '9px' : '10px'
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
                tickAmount: isMobile ? 5 : undefined
            },
            yaxis: {
                labels: {
                    style: { colors: '#94A3B8', fontWeight: 700, fontSize: '10px' },
                    offsetX: isMobile ? -8 : 0
                }
            },
            grid: {
                borderColor: '#F8FAFC',
                strokeDashArray: 6,
                padding: {
                    top: 0,
                    right: isMobile ? 4 : 8,
                    bottom: isMobile ? 10 : 0,
                    left: isMobile ? 0 : 10
                }
            },
            tooltip: {
                theme: 'light',
                style: { fontSize: '12px' },
                y: { formatter: function(val) { return val + " Unit" } }
            },
            legend: { show: false },
            responsive: [{
                breakpoint: 768,
                options: {
                    chart: { height: 220 },
                    xaxis: {
                        labels: {
                            rotate: -45,
                            rotateAlways: true,
                            hideOverlappingLabels: true,
                            trim: true,
                            style: { fontSize: '9px' }
                        },
                        tickAmount: 5
                    },
                    grid: {
                        padding: { right: 4, bottom: 10, left: 0 }
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart-mutasi"), options);
        chart.render();
    });
</script>
@endpush
@endsection