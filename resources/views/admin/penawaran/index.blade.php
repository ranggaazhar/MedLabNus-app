@extends('admin.layouts.app')

@section('title', 'List Penawaran')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Permintaan Penawaran Harga</h1>
    <p class="text-sm text-gray-500 font-medium italic">Audit Trail Logistik PT Medlab Nusantara</p>
</div>

{{-- FILTER & DATE PICKER SECTION --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
    <form action="{{ route('admin.penawaran.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
        {{-- Input Pencarian --}}
        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block ml-1">Pencarian</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode atau nama..." 
                class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-red-500 text-sm transition-all">
        </div>
        
        {{-- Date Picker: Dari Tanggal --}}
        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block ml-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $startDateInput }}" 
                class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-red-500 text-sm transition-all">
        </div>
        
        {{-- Date Picker: Sampai Tanggal --}}
        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block ml-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $endDateInput }}" 
                class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-red-500 text-sm transition-all">
        </div>
        
        {{-- Dropdown Status --}}
        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block ml-1">Status Dokumen</label>
            <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-red-500 text-sm transition-all">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui (+)</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan (-)</option>
            </select>
        </div>
        
        {{-- Tombol Aksi Filter --}}
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-red-600 text-white font-bold py-2.5 rounded-lg hover:bg-red-700 transition shadow-lg shadow-red-100">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
            <a href="{{ route('admin.penawaran.index') }}" class="p-2.5 bg-gray-100 text-gray-400 rounded-lg hover:bg-gray-200 transition" title="Reset">
                <i class="fas fa-sync-alt"></i>
            </a>
        </div>
    </form>
</div>

{{-- ALERT NOTIFIKASI --}}
@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-xl text-sm font-semibold flex items-center gap-2">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- TABEL DATA UTAMA --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-5 border-b border-gray-50 flex justify-between items-center bg-white">
        <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Daftar Dokumen Masuk</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left table-penawaran">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Waktu Masuk</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Kode Dokumen</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Data Instansi/Pelanggan</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-center">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-center">File Dokumen</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($penawarans as $penawaran)
                <tr class="hover:bg-gray-50/30 transition">
                    {{-- Waktu & Operator --}}
                    <td class="px-6 py-4" data-label="Waktu Masuk">
                        <div class="text-sm font-bold text-gray-700">{{ $penawaran->created_at->translatedFormat('d M Y, H:i') }}</div>
                        <div class="text-[10px] text-gray-400 flex items-center gap-1 mt-1 font-medium">
                            <i class="fas fa-user text-[8px]"></i> Akun: {{ $penawaran->user->name ?? 'Guest/Public' }}
                        </div>
                    </td>
                    
                    {{-- Kode Dokumen --}}
                    <td class="px-6 py-4" data-label="Kode">
                        <span class="font-mono font-black text-sm text-gray-800 bg-gray-100 px-2 py-1 rounded">
                            {{ $penawaran->kode_penawaran }}
                        </span>
                    </td>
                    
                    {{-- Data Instansi/Pelanggan --}}
                    <td class="px-6 py-4" data-label="Pelanggan">
                        <div class="text-sm font-black text-gray-800">{{ $penawaran->nama_pelanggan }}</div>
                        <div class="text-[10px] text-gray-500 font-bold flex items-center gap-1 mt-0.5">
                            <i class="fab fa-whatsapp text-emerald-500 text-xs"></i> {{ $penawaran->whatsapp_pelanggan }}
                        </div>
                    </td>
                    
                    {{-- Status Dokumen --}}
                    <td class="px-6 py-4 text-center" data-label="Status">
                        @if($penawaran->status == 'pending')
                            <span class="px-2 py-1 rounded text-[9px] font-black uppercase tracking-tighter bg-amber-50 text-amber-600 border border-amber-100">
                                Pending
                            </span>
                        @elseif($penawaran->status == 'disetujui')
                            <span class="px-2 py-1 rounded text-[9px] font-black uppercase tracking-tighter bg-emerald-50 text-emerald-600 border border-emerald-100">
                                Disetujui
                            </span>
                        @else
                            <span class="px-2 py-1 rounded text-[9px] font-black uppercase tracking-tighter bg-red-50 text-red-600 border border-red-100">
                                Dibatalkan
                            </span>
                        @endif
                    </td>
                    
                    {{-- File PDF --}}
                    <td class="px-6 py-4 text-center" data-label="File Dokumen">
                        @if($penawaran->file_pdf)
                            <a href="{{ asset('uploads/pdf_penawaran/' . $penawaran->file_pdf) }}" target="_blank" 
                               class="inline-flex items-center gap-1 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded-lg transition">
                                <i class="fas fa-file-pdf"></i> Lihat PDF
                            </a>
                        @else
                            <span class="text-xs text-gray-400 italic font-medium">File Terhapus</span>
                        @endif
                    </td>
                    
                    {{-- Tombol Manajemen Kontrol --}}
                    <td class="px-6 py-4 text-right" data-label="Aksi">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.penawaran.show', $penawaran->id) }}" 
                               class="px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                <i class="fas fa-eye text-[10px]"></i> Detail
                            </a>

                            <form action="{{ route('admin.penawaran.destroy', $penawaran->id) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penawaran ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Data">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic text-sm">Belum ada permintaan penawaran harga yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($penawarans->hasPages())
    <div class="p-5 border-t border-gray-50">
        {{ $penawarans->withQueryString()->links() }}
    </div>
    @endif
</div>

{{-- GRAFIK VISUALISASI DIBAWAH --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-3">
        <div>
            <h3 class="text-base sm:text-lg font-bold text-gray-800 italic">Inbound RFQ Analytics</h3>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-0.5">Visualisasi Tren Permintaan Penawaran Masuk</p>
        </div>
        <div class="flex items-center gap-3 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-100 self-start md:self-center">
            <div class="flex items-center gap-1.5">
                <div class="w-2.5 h-2.5 rounded-full bg-red-600 shadow-sm"></div>
                <span class="text-[9px] font-black text-gray-500 uppercase">Total Permintaan Masuk</span>
            </div>
        </div>
    </div>
    
    <div id="chart-penawaran" class="w-full"></div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var isMobile = window.innerWidth < 768;

        var options = {
            series: [{
                name: 'Dokumen Masuk',
                data: @json($totals)
            }],
            chart: {
                type: 'area',
                height: isMobile ? 220 : 320,
                fontFamily: 'Plus Jakarta Sans, sans-serif',
                toolbar: { show: false },
                zoom: { enabled: false },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 600
                }
            },
            colors: ['#DC2626'],
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
                },
                forceNiceScale: true,
                min: 0
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
                y: { formatter: function(val) { return val + " Berkas" } }
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

        var chart = new ApexCharts(document.querySelector("#chart-penawaran"), options);
        chart.render();
    });
</script>
@endpush
@endsection