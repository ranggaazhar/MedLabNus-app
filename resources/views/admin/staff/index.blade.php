@extends('admin.layouts.app')

@section('title', 'Manajemen Staf Gudang')

@section('content')
<div x-data="{ openModal: false }">
    
    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Manajemen Staf Gudang</h1>
            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mt-1">Kelola Akun Hak Akses Logistik & Stok</p>
        </div>
        
        {{-- Tombol Tambah --}}
        <button @click="openModal = true" class="bg-[#b91c1c] hover:bg-red-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Staf Gudang
        </button>
    </div>

    {{-- TABEL DAFTAR STAF GUDANG --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-[10px] font-black text-gray-400 uppercase tracking-wider bg-gray-50/50">
                        <th class="py-3 px-6 font-semibold">Nama Staf</th>
                        <th class="py-3 px-6 font-semibold">Email Karyawan</th>
                        <th class="py-3 px-6 font-semibold">No. Telp / WA</th>
                        <th class="py-3 px-6 font-semibold">Role Sistem</th>
                        <th class="py-3 px-6 font-semibold">Status Akun</th>
                        <th class="py-3 px-6 font-semibold">Tanggal Dibuat</th>
                        <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-gray-600 divide-y divide-gray-50">
                    @forelse ($stafGudang as $staf)
                        <tr class="hover:bg-gray-50/50 transition-colors {{ !$staf->is_active ? 'opacity-60' : '' }}">
                            <td class="py-3.5 px-6 font-bold {{ $staf->is_active ? 'text-gray-700' : 'text-gray-400 line-through' }}">
                                {{ $staf->name }}
                            </td>
                            <td class="py-3.5 px-6 text-gray-500">{{ $staf->email }}</td>
                            <td class="py-3.5 px-6 text-gray-600 font-medium">
                                {{ $staf->no_telp ?? '-' }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="bg-amber-50 text-amber-700 border border-amber-100 px-2 py-0.5 rounded-md font-bold uppercase tracking-wide text-[10px]">
                                    {{ $staf->role }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6">
                                @if($staf->is_active)
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-100 px-2 py-0.5 rounded-md font-bold uppercase tracking-wide text-[10px]">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full inline-block"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 border border-gray-200 px-2 py-0.5 rounded-md font-bold uppercase tracking-wide text-[10px]">
                                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full inline-block"></span> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-gray-400">{{ $staf->created_at->format('d M Y') }}</td>
                            <td class="py-3.5 px-6 text-center">
                                {{-- Form toggle status --}}
                                <form action="{{ route('staff.toggle-status', $staf->id) }}" method="POST" class="inline toggle-status-form"
                                      data-name="{{ $staf->name }}" data-active="{{ $staf->is_active ? 'true' : 'false' }}">
                                    @csrf
                                    @method('PATCH')
                                    @if($staf->is_active)
                                        <button type="button"
                                            title="Nonaktifkan Akun"
                                            class="btn-toggle inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-[#b91c1c] border border-red-100 text-[10px] font-bold px-3 py-1.5 rounded-lg transition">
                                            <i class="fas fa-ban text-[9px]"></i> Nonaktifkan
                                        </button>
                                    @else
                                        <button type="button"
                                            title="Aktifkan Akun"
                                            class="btn-toggle inline-flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-100 text-[10px] font-bold px-3 py-1.5 rounded-lg transition">
                                            <i class="fas fa-check text-[9px]"></i> Aktifkan
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400 font-medium">Belum ada akun staf gudang yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($stafGudang->hasPages())
            <div class="px-6 py-2 border-t border-gray-50 bg-gray-50/30">
                {{ $stafGudang->links('partials.pagination') }}
            </div>
        @endif
    </div>

    {{-- MODAL FORM TAMBAH GUDANG (POPUP) --}}
    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="openModal = false"></div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl max-w-md w-full mx-4 p-6 relative z-10 transform transition-all">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-sm font-bold text-gray-800">Buat Akun Staf Gudang</h3>
                <button @click="openModal = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('staff.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full bg-gray-50/50 border border-gray-200 text-xs text-gray-700 px-3 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-[#b91c1c]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email Karyawan</label>
                        <input type="email" name="email" required class="w-full bg-gray-50/50 border border-gray-200 text-xs text-gray-700 px-3 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-[#b91c1c]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">No Telepon</label>
                        <input type="text" name="no_telp" required placeholder="Contoh: 08123456789" class="w-full bg-gray-50/50 border border-gray-200 text-xs text-gray-700 px-3 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-[#b91c1c]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Password</label>
                        <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full bg-gray-50/50 border border-gray-200 text-xs text-gray-700 px-3 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-[#b91c1c]">
                    </div>

                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 flex items-center justify-between">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Otoritas Akses</span>
                        <span class="text-[10px] font-black uppercase bg-red-50 border border-red-100 text-[#b91c1c] px-2 py-0.5 rounded-md">GUDANG SECARA OTOMATIS</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" @click="openModal = false" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold px-4 py-2.5 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-[#b91c1c] hover:bg-red-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Notifikasi dari session
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end',
                timerProgressBar: true,
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end',
                timerProgressBar: true,
            });
        @endif

        // Event listener untuk tombol toggle status
        document.querySelectorAll('.btn-toggle').forEach(button => {
            button.addEventListener('click', function (e) {
                const form = this.closest('form');
                const staffName = form.getAttribute('data-name');
                const isActive = form.getAttribute('data-active') === 'true';
                
                const actionText = isActive ? 'menonaktifkan' : 'mengaktifkan';
                const confirmButtonText = isActive ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan';
                const confirmButtonColor = isActive ? '#d33' : '#10b981';

                Swal.fire({
                    title: 'Konfirmasi Tindakan',
                    text: `Apakah Anda yakin ingin ${actionText} akun staf "${staffName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: confirmButtonColor,
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl text-xs px-4 py-2.5 font-bold',
                        cancelButton: 'rounded-xl text-xs px-4 py-2.5 font-bold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
