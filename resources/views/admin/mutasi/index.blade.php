@extends('admin.layouts.app')

@section('title', 'Riwayat Mutasi Stok')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Riwayat Mutasi Stok</h1>
    <p class="text-sm text-gray-500">Daftar keluar masuk stok produk Medlab Nusantara.</p>
</div>

{{-- Filter Box --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
    <form action="{{ route('stok-mutasi.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama produk atau keterangan..." 
                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-red-500 focus:border-red-500">
        </div>
        <div class="w-full md:w-48">
            <select name="tipe" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-red-500 focus:border-red-500">
                <option value="">Semua Tipe</option>
                <option value="masuk" {{ $tipe == 'masuk' ? 'selected' : '' }}>Stok Masuk</option>
                <option value="keluar" {{ $tipe == 'keluar' ? 'selected' : '' }}>Stok Keluar</option>
            </select>
        </div>
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-700 transition">
            Filter
        </button>
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Waktu</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Produk</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Tipe</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-right">Jumlah</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Keterangan</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Admin</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($mutasis as $mutasi)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                    {{ $mutasi->created_at->format('d/m/Y H:i') }}
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm font-bold text-gray-800">{{ $mutasi->produk->nama_produk ?? 'Produk Dihapus' }}</span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border uppercase
                        {{ $mutasi->tipe == 'masuk' ? 'bg-green-100 text-green-700 border-green-200' : 'bg-orange-100 text-orange-700 border-orange-200' }}">
                        {{ $mutasi->tipe }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <span class="text-sm font-bold {{ $mutasi->tipe == 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $mutasi->tipe == 'masuk' ? '+' : '-' }} {{ number_format($mutasi->jumlah) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 italic">
                    {{ $mutasi->keterangan }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">
                    {{ $mutasi->user->name ?? 'System' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">
                    Belum ada riwayat mutasi stok.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-6 bg-gray-50 border-t border-gray-100">
        {{ $mutasis->links() }}
    </div>
</div>
@endsection