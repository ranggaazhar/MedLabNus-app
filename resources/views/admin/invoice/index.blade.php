@extends('admin.layouts.app')

@section('title', 'Kelola Invoice')

@section('content')

    {{-- HEADER SECTION & TOMBOL TAMBAH --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Daftar Invoice Tagihan</h1>
            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mt-1">Audit Trail Logistik PT Medlab Nusantara</p>
        </div>
        <a href="{{ route('admin.invoice.create') }}"
            class="px-5 py-2.5 bg-red-700 text-white rounded-xl text-sm font-bold hover:bg-red-800 shadow-sm flex items-center gap-2 transition-all">
            <i class="fas fa-plus"></i> Buat Invoice Baru
        </a>
    </div>

    {{-- FILTER SECTION (CLEAN GRID) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
        <form action="{{ route('admin.invoice.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            
            {{-- Search --}}
            <div class="md:col-span-4">
                <label class="text-[9px] font-black text-gray-400 uppercase mb-1.5 block">Cari Data</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode atau nama instansi..." 
                        class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-red-500 focus:bg-white transition-all">
                </div>
            </div>
            
            {{-- Date Range: Start --}}
            <div class="md:col-span-2">
                <label class="text-[9px] font-black text-gray-400 uppercase mb-1.5 block">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                    class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-red-500 transition-all text-gray-600">
            </div>
            
            {{-- Date Range: End --}}
            <div class="md:col-span-2">
                <label class="text-[9px] font-black text-gray-400 uppercase mb-1.5 block">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                    class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-red-500 transition-all text-gray-600">
            </div>

            {{-- Status Dropdown --}}
            <div class="md:col-span-2">
                <label class="text-[9px] font-black text-gray-400 uppercase mb-1.5 block">Status</label>
                <select name="status" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-red-500 transition-all text-gray-600 appearance-none">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>

            {{-- Filter Actions --}}
            <div class="md:col-span-2 flex gap-2">
                <button type="submit" class="flex-grow bg-gray-800 text-white font-bold py-2 rounded-xl hover:bg-gray-900 transition text-sm">
                    Filter
                </button>
                <a href="{{ route('admin.invoice.index') }}" class="px-4 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition flex items-center justify-center" title="Reset Filter">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- TABLE SECTION (CLEAN WHITE) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-white border-b border-gray-50">
                    <tr>
                        <th class="py-4 px-6 text-[10px] font-black text-gray-300 uppercase tracking-wider">Info Dokumen</th>
                        <th class="py-4 px-6 text-[10px] font-black text-gray-300 uppercase tracking-wider">Instansi Pelanggan</th>
                        <th class="py-4 px-6 text-[10px] font-black text-gray-300 uppercase tracking-wider">Total Tagihan</th>
                        <th class="py-4 px-6 text-[10px] font-black text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-[10px] font-black text-gray-300 uppercase tracking-wider text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($invoices as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">

                            {{-- Kode & Tanggal Invoice --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center border border-red-100 text-red-600">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm font-mono">{{ $item->kode_invoice }}</p>
                                        <p class="text-xs text-gray-400">{{ $item->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Instansi Pelanggan --}}
                            <td class="py-4 px-6 text-gray-700" data-label="Pelanggan">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-800">{{ $item->nama_pelanggan }}</span>
                                    <span class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                        <i class="fab fa-whatsapp text-emerald-500"></i> {{ $item->whatsapp_pelanggan ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Total Tagihan Finansial --}}
                            <td class="py-4 px-6 font-bold text-gray-900 text-sm" data-label="Total">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>

                            {{-- Status Pembayaran --}}
                            <td class="py-4 px-6 text-sm" data-label="Status">
                                @if ($item->status_pembayaran == 'lunas')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        Lunas
                                    </span>
                                @elseif($item->status_pembayaran == 'batal')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter bg-rose-50 text-rose-700 border border-rose-100">
                                        Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter bg-amber-50 text-amber-700 border border-amber-100">
                                        Pending
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="py-4 px-6" data-label="Action">
                                <div class="flex items-center justify-end gap-4">
                                    
                                    {{-- Tombol Batal (Hanya muncul jika status pending) --}}
                                    @if ($item->status_pembayaran == 'pending')
                                        <form action="{{ route('admin.invoice.cancel', $item->id) }}" method="POST" class="inline cancel-form">
                                            @csrf @method('PATCH')
                                            <button type="button" class="text-rose-400 hover:text-rose-600 transition transform hover:scale-110 btn-cancel" title="Batalkan Invoice">
                                                <i class="fas fa-times-circle text-lg"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Download PDF & Detail --}}
                                    <div class="flex items-center gap-3 border-l border-gray-200 pl-4">
                                        <a href="{{ route('admin.invoice.download-pdf', $item->id) }}"
                                            class="text-blue-500 hover:text-blue-700 transition transform hover:scale-110"
                                            title="Download PDF Faktur">
                                            <i class="fas fa-file-pdf text-lg"></i>
                                        </a>
                                        <a href="{{ route('admin.invoice.show', $item->id) }}"
                                            class="text-gray-400 hover:text-gray-800 transition transform hover:scale-110"
                                            title="Lihat Detail">
                                            <i class="fas fa-chevron-right text-lg font-bold"></i>
                                        </a>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fas fa-file-invoice text-4xl text-gray-200"></i>
                                    <p class="text-gray-400 text-xs font-medium">Belum ada data invoice</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION SECTION --}}
        @if ($invoices->hasPages())
            <div class="flex flex-col md:flex-row justify-between items-center p-4 border-t border-gray-50 bg-gray-50/30">
                <div class="text-gray-400 text-xs font-medium mb-3 md:mb-0">
                    Showing <span class="font-bold text-gray-600">{{ $invoices->firstItem() }}</span> - <span class="font-bold text-gray-600">{{ $invoices->lastItem() }}</span> of <span class="font-bold text-gray-600">{{ $invoices->total() }}</span> invoices
                </div>
                <div class="flex items-center gap-1">
                    {{ $invoices->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>

    {{-- SWEETALERT LOGIC --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-cancel').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Batalkan Invoice?',
                        text: "Status invoice akan diubah menjadi Batal dan tidak dapat diedit kembali.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48', // Merah Rose
                        cancelButtonColor: '#9ca3af',  // Abu-abu
                        confirmButtonText: 'Ya, Batalkan!',
                        cancelButtonText: 'Tutup',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak',
                    text: "{{ session('error') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>

@endsection