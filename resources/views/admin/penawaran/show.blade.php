@extends('admin.layouts.app')

@section('title', 'Detail Dokumen Penawaran Harga')

@section('content')
{{-- BACK BUTTON & TITLE --}}
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <a href="{{ route('admin.penawaran.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-red-600 transition mb-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Penawaran
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Dokumen #{{ $penawaran->kode_penawaran }}</h1>
        <p class="text-sm text-gray-500 font-medium italic">Audit Trail Logistik PT Medlab Nusantara</p>
    </div>

    {{-- TOP ACTION ACTION --}}
    <div class="flex items-center gap-3">
        @if($penawaran->file_pdf)
            <a href="{{ asset('uploads/pdf_penawaran/' . $penawaran->file_pdf) }}" target="_blank" 
               class="bg-red-600 text-white font-bold px-4 py-2.5 rounded-lg hover:bg-red-700 transition shadow-lg shadow-red-100 text-sm flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Cetak / Unduh PDF Resmi
            </a>
        @endif
    </div>
</div>

{{-- ALERT NOTIFIKASI --}}
@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-xl text-sm font-semibold flex items-center gap-2">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    {{-- LEFT COLUMN: DATA PELANGGAN & INSTANSI (2 SPAN) --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest border-b border-gray-50 pb-4 mb-4">
                Informasi Pemohon Penawaran
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase block mb-1">Nama Instansi / Pelanggan</label>
                    <div class="text-base font-black text-gray-800">{{ $penawaran->nama_pelanggan }}</div>
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase block mb-1">Kontak WhatsApp</label>
                    <div class="text-base font-bold text-gray-800 flex items-center gap-2">
                        <i class="fab fa-whatsapp text-emerald-500 text-lg"></i>
                        <a href="https://wa.me/{{ $penawaran->whatsapp_pelanggan }}" target="_blank" class="hover:underline text-gray-700">
                            {{ $penawaran->whatsapp_pelanggan }}
                        </a>
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase block mb-1">Waktu Dokumen Masuk</label>
                    <div class="text-sm font-bold text-gray-700">
                        {{ $penawaran->created_at->translatedFormat('d F Y - H:i:s') }}
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase block mb-1">Akun Operator Pembuat</label>
                    <div class="text-sm font-bold text-gray-700 flex items-center gap-1.5">
                        <i class="fas fa-user-circle text-gray-400"></i>
                        {{ $penawaran->user->name ?? 'Guest / Public Session' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN: STATUS MANAGEMENT & ACTION (1 SPAN) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
        <div>
            <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest border-b border-gray-50 pb-4 mb-4">
                Status Validasi Dokumen
            </h3>
            
            <div class="mb-4">
                <label class="text-[10px] font-black text-gray-400 uppercase block mb-2">Status Saat Ini</label>
                @if($penawaran->status == 'pending')
                    <span class="inline-block px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-100">
                        Pending 
                    </span>
                @elseif($penawaran->status == 'disetujui')
                    <span class="inline-block px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">
                        Disetujui 
                    </span>
                @else
                    <span class="inline-block px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-wider bg-red-50 text-red-600 border border-red-100">
                        Dibatalkan 
                    </span>
                @endif
            </div>
        </div>

        {{-- UPDATE STATUS FORM --}}
        <form action="{{ route('admin.penawaran.updateStatus', $penawaran->id) }}" method="POST" class="mt-6 pt-4 border-t border-gray-50">
            @csrf
            @method('PATCH')
            <label class="text-[10px] font-black text-gray-400 uppercase block mb-2 ml-1">Perbarui Status Log</label>
            <div class="flex gap-2">
                <select name="status" class="flex-1 px-3 py-2 bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-red-500 text-xs font-bold text-gray-700 transition-all">
                    <option value="disetujui" {{ $penawaran->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="dibatalkan" {{ $penawaran->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="bg-gray-800 text-white font-bold px-4 py-2 rounded-lg hover:bg-gray-900 transition text-xs shadow-md">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- BOTTOM TABLE: ITEM BARANG YANG DIMINTA --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-5 border-b border-gray-50 bg-white">
        <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Daftar Item Produk Alkes Yang Diminta</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase w-16 text-center">No</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Detail Alat Kesehatan</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Pabrikan / Vendor</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-center w-32">Jumlah Permintaan (Qty)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($penawaran->items as $index => $item)
                <tr class="hover:bg-gray-50/30 transition">
                    {{-- NOMOR --}}
                    <td class="px-6 py-4 text-sm font-bold text-gray-400 text-center">
                        {{ $index + 1 }}
                    </td>
                    {{-- NAMA PRODUK --}}
                    <td class="px-6 py-4">
                        <div class="text-sm font-black text-gray-800">
                            {{ $item->produk->nama_produk ?? 'Produk Tidak Ditemukan / Terhapus' }}
                        </div>
                    </td>
                    {{-- PABRIKAN --}}
                    <td class="px-6 py-4">
                        <span class="text-xs text-red-500 font-bold uppercase bg-red-50 px-2.5 py-1 rounded">
                            {{ $item->produk->pabrikan->nama_pabrikan ?? 'General Vendor' }}
                        </span>
                    </td>
                    {{-- QTY QUANTITY --}}
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-black text-gray-800 bg-gray-100 px-3 py-1 rounded-full">
                            {{ number_format($item->jumlah) }} Unit
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic text-sm">
                        Tidak ada detail item produk di dalam dokumen penawaran ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection