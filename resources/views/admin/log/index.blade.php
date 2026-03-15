@extends('admin.layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Log Aktivitas Sistem</h1>
    <p class="text-sm text-gray-500">Pantau semua perubahan data Produk, Pabrikan, dan Stok secara real-time.</p>
</div>

{{-- Filter & Search Card --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
    <form action="{{ route('log.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" name="search" value="{{ $search }}"
                placeholder="Cari aktivitas, nama produk, atau nama admin..."
                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-red-500 focus:border-red-500 transition">
        </div>
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-semibold transition flex items-center justify-center gap-2">
            <i class="fas fa-filter"></i> Filter
        </button>
        @if($search)
            <a href="{{ route('log.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2.5 rounded-lg font-semibold transition text-center">
                Reset
            </a>
        @endif
    </form>
</div>

{{-- Log Table Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Waktu</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Admin</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Aktivitas</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Modul</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Detail Perubahan</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            <span class="block font-medium text-gray-900">{{ $log->created_at->format('d/m/Y') }}</span>
                            <span class="text-xs text-gray-400">{{ $log->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-red-600 font-bold text-xs border border-red-100 uppercase">
                                    {{ substr($log->causer->name ?? 'S', 0, 1) }}
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ $log->causer->name ?? 'System' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badgeColor = match($log->event) {
                                    'created' => 'bg-green-100 text-green-700 border-green-200',
                                    'updated' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'deleted' => 'bg-red-100 text-red-700 border-red-200',
                                    default => 'bg-gray-100 text-gray-700 border-gray-200',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badgeColor }} uppercase">
                                {{ $log->description }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 capitalize">
                            {{ str_replace('App\Models\\', '', $log->subject_type) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($log->event == 'updated' && isset($log->changes['attributes']))
                                <p class="text-[11px] text-gray-500 line-clamp-1 italic">
                                    Mengubah: {{ implode(', ', array_keys($log->changes['attributes'])) }}
                                </p>
                            @else
                                <span class="text-[11px] text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('log.show', $log->id) }}" class="text-blue-600 hover:text-blue-800 transition">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                            <i class="fas fa-history text-4xl mb-3 block"></i>
                            Tidak ada data log yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Pagination --}}
    <div class="p-6 border-t border-gray-50 bg-gray-50/30">
        {{ $logs->links() }}
    </div>
</div>
@endsection