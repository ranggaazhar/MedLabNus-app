@extends('admin.layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Log Aktivitas Sistem</h1>
    <p class="text-sm text-gray-500 font-medium">Pantau semua perubahan data Produk, Pabrikan, dan Stok secara real-time.</p>
</div>

{{-- 1. FILTER & SEARCH CARD --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
    <form action="{{ route('log.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-search text-xs"></i>
            </span>
            <input type="text" name="search" value="{{ $search }}"
                placeholder="Cari aktivitas, nama produk, atau nama admin..."
                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-red-500 transition text-sm">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-bold transition flex items-center justify-center gap-2 shadow-sm">
                <i class="fas fa-filter text-xs"></i> Filter
            </button>
            @if($search)
                <a href="{{ route('log.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2.5 rounded-lg font-bold transition text-center text-sm flex items-center shadow-sm">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

{{-- 2. LOG TABLE CARD --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-log">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Waktu</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Admin</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Aktivitas</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Modul</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Detail Perubahan</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap" data-label="Waktu">
                            <span class="block font-bold text-gray-800">{{ $log->created_at->format('d/m/Y') }}</span>
                            <span class="text-[10px] font-bold text-gray-400 italic">{{ $log->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="px-6 py-4" data-label="Admin">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-red-600 font-black text-xs border border-red-100 uppercase">
                                    {{ substr($log->causer->name ?? 'S', 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-gray-700">{{ $log->causer->name ?? 'System' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4" data-label="Aktivitas">
                            @php
                                $badgeColor = match($log->event) {
                                    'created' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'updated' => 'bg-blue-50 text-blue-600 border-blue-200',
                                    'deleted' => 'bg-red-50 text-red-600 border-red-100',
                                    default => 'bg-gray-50 text-gray-600 border-gray-200',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded text-[9px] font-black border {{ $badgeColor }} uppercase tracking-tighter">
                                {{ $log->description }}
                            </span>
                        </td>
                        <td class="px-6 py-4" data-label="Modul">
                            <span class="text-[11px] font-bold text-gray-500 uppercase bg-gray-100 px-2 py-0.5 rounded italic">
                                {{ str_replace('App\Models\\', '', $log->subject_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4" data-label="Detail">
                            @if($log->event == 'updated' && isset($log->changes['attributes']))
                                <p class="text-[11px] text-gray-500 line-clamp-1 italic font-medium">
                                    Mengubah: <span class="text-red-500">{{ implode(', ', array_keys($log->changes['attributes'])) }}</span>
                                </p>
                            @else
                                <span class="text-[11px] text-gray-400 font-medium">- No Changes -</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center" data-label="Aksi">
                            <a href="{{ route('log.show', $log->id) }}" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <i class="fas fa-history text-5xl mb-4"></i>
                                <p class="text-gray-900 font-bold italic uppercase tracking-widest">No Activity Log Found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- 3. CUSTOM PAGINATION SECTION --}}
@if($logs->hasPages())
    <div class="flex flex-col md:flex-row justify-between items-center mt-6 py-3 px-1">
        
        {{-- Show Result Info --}}
        <div class="text-gray-500 text-sm font-medium py-2 order-2 md:order-1">
            @if($logs->total() > 0)
                <span class="text-sm tracking-wide">
                    Showing 
                    <span class="font-bold text-gray-700">{{ $logs->firstItem() }}</span>
                    -
                    <span class="font-bold text-gray-700">{{ $logs->lastItem() }}</span> 
                    of 
                    <span class="font-bold text-gray-700">{{ $logs->total() }}</span> 
                    result{{ $logs->total() !== 1 ? 's' : '' }}
                </span>
            @else
                <span class="text-sm tracking-wide text-gray-400">0 results found</span>
            @endif
        </div>

        {{-- Pagination Buttons --}}
        <div class="flex items-center gap-2 order-1 md:order-2 mb-4 md:mb-0">

            {{-- Previous Button --}}
            <a href="{{ $logs->previousPageUrl() }}" 
               @class([
                   'w-10 h-10 flex items-center justify-center border rounded-lg text-gray-600 transition-all duration-300 hover:scale-110 active:scale-95 text-sm shadow-sm',
                   'border-gray-300 bg-white hover:bg-gray-50 hover:border-red-700 hover:text-red-700' => !$logs->onFirstPage(),
                   'opacity-30 cursor-not-allowed border-gray-200 bg-gray-50' => $logs->onFirstPage(),
               ])
               title="Previous">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </a>

            {{-- Page Numbers (Smart Range) --}}
            @php
                $start = max($logs->currentPage() - 2, 1);
                $end = min($start + 4, $logs->lastPage());
                if ($end - $start < 4) {
                    $start = max($end - 4, 1);
                }
            @endphp

            @for ($i = $start; $i <= $end; $i++)
                <a href="{{ $logs->url($i) }}"
                   @class([
                       'w-10 h-10 flex items-center justify-center border rounded-lg font-bold transition-all duration-300 hover:scale-110 active:scale-95 text-sm shadow-sm',
                       'bg-red-700 text-white border-red-700 scale-110 z-10' => $i == $logs->currentPage(),
                       'bg-white border-gray-300 text-gray-600 hover:bg-gray-50 hover:border-red-700 hover:text-red-700' => $i != $logs->currentPage(),
                   ])>
                    {{ $i }}
                </a>
            @endfor

            {{-- Next Button --}}
            <a href="{{ $logs->nextPageUrl() }}" 
               @class([
                   'w-10 h-10 flex items-center justify-center border rounded-lg text-gray-600 transition-all duration-300 hover:scale-110 active:scale-95 text-sm shadow-sm',
                   'border-gray-300 bg-white hover:bg-gray-50 hover:border-red-700 hover:text-red-700' => $logs->hasMorePages(),
                   'opacity-30 cursor-not-allowed border-gray-200 bg-gray-50' => !$logs->hasMorePages(),
               ])
               title="Next">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        </div>
    </div>
@endif

@endsection