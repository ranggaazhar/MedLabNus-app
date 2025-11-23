@extends('admin.layouts.app')

@section('title', 'List Pabrik')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Pabrikan</h1>

        </div>

        {{-- Session Messages --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                <p class="font-bold">Sukses!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                <p class="font-bold">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        {{-- Search Form - Disesuaikan agar field search lebih panjang dan sejajar dengan tabel --}}
        <div class="mb-6">
            <form action="{{ route('pabrikan.index') }}" method="GET" class="flex items-center space-x-3">

                {{-- Search Input Container (Menggunakan flex-1 untuk mengambil sisa ruang) --}}
                <div class="relative flex-1">
                    {{-- Ikon Kaca Pembesar Absolut --}}
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 z-10"></i>

                    {{-- Input Field --}}
                    <input type="text" name="search" placeholder="Cari pabrikan..." value="{{ request('search') }}"
                        class="w-full border border-gray-200 pl-10 pr-4 py-2.5 rounded-xl bg-white focus:ring-red-500 focus:border-red-500 shadow-sm text-gray-700 placeholder-gray-400 transition duration-150">
                </div>

                {{-- Placeholder Tombol Filter --}}
                <button type="button"
                    class="bg-white border border-gray-300 text-gray-700 font-semibold py-2.5 px-4 rounded-xl shadow-sm transition duration-150 flex items-center gap-2 hover:bg-gray-50 focus:outline-none">
                    <i class="fas fa-filter"></i> Filter
                </button>


                
                {{-- Tombol Tambah Pabrikan - Diubah ke style ikon dan warna merah --}}

                <a href="{{ route('pabrikan.create') }}"

                    class="bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center gap-1">

                    <i class="fas fa-plus"></i> Tambah Pabrikan

                </a>

            </form>
        </div>

        {{-- Pabrikan Table --}}
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Logo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Pabrikan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Asal Negara
                            </th>
                            {{-- Header Aksi dibuat rata tengah --}}
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pabrikans as $pabrikan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($pabrikan->logo_pabrikan)
                                        <img src="{{ asset('storage/' . $pabrikan->logo_pabrikan) }}"
                                            alt="{{ $pabrikan->nama_pabrikan }}" class="h-10 w-10 object-contain rounded-full">
                                    @else
                                        <div
                                            class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                            <i class="fas fa-industry text-lg"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $pabrikan->nama_pabrikan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $pabrikan->asal_negara }}
                                </td>

                                {{-- Kolom Aksi diubah menjadi format ikon --}}
                                <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-500">
                                    <div class="flex items-center justify-center space-x-3">

                                        {{-- Tombol Edit (Ikon) - Memicu Modal --}}
                                        <button type="button" title="Edit"
                                            class="edit-button text-gray-900 hover:text-red-600 transition duration-150"
                                            data-id="{{ $pabrikan->id }}" data-nama="{{ $pabrikan->nama_pabrikan }}"
                                            data-negara="{{ $pabrikan->asal_negara }}"
                                            data-logo="{{ $pabrikan->logo_pabrikan ? asset('storage/' . $pabrikan->logo_pabrikan) : '' }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        {{-- Tombol Hapus (Ikon) - Dalam Form --}}
                                        <form action="{{ route('pabrikan.destroy', $pabrikan) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus pabrikan {{ $pabrikan->nama_pabrikan }}? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                class="text-red-600 hover:text-red-900 transition duration-150">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    Tidak ada data pabrikan yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Links --}}
        <div class="mt-6">
            {{ $pabrikans->links() }}
        </div>
    </div>

    {{-- Modal Edit Pabrikan --}}
    <div id="editModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300 ease-in-out">

        {{-- Modal Content (Diperlebar menjadi max-w-lg) --}}
        {{-- Catatan: max-w-lg memberikan lebar sekitar 500-600px pada layar desktop --}}
        <div
            class="relative top-20 mx-auto p-6 bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 ease-out">

            <div class="text-center">

                <h3 class="text-2xl font-bold text-gray-800 mb-4">
                    {{-- Menggunakan ikon Edit dengan warna merah --}}
                    <i class="fas fa-edit mr-2 text-red-700"></i> Edit Pabrikan
                </h3>

                <div class="mt-2 text-left">
                    <form id="editForm" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Input Nama Pabrikan --}}
                        <div class="mb-4">
                            <label for="modal_nama_pabrikan" class="block text-sm font-semibold text-gray-700 mb-1">Nama
                                Pabrikan</label>
                            <input type="text" name="nama_pabrikan" id="modal_nama_pabrikan" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                        </div>

                        {{-- Input Asal Negara --}}
                        <div class="mb-4">
                            <label for="modal_asal_negara" class="block text-sm font-semibold text-gray-700 mb-1">Asal
                                Negara</label>
                            <input type="text" name="asal_negara" id="modal_asal_negara" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                        </div>

                        {{-- Input Logo (jika perlu diubah) --}}
                        <div class="mb-6">
                            <label for="modal_logo_pabrikan" class="block text-sm font-semibold text-gray-700 mb-1">Logo
                                Pabrikan (Kosongkan jika tidak diubah)</label>

                            {{-- Logo Saat Ini --}}
                            <div id="current_logo_container" class="my-3 flex items-center space-x-3">
                                <p class="text-sm text-gray-600">Logo Saat Ini: </p>
                                {{-- Placeholder untuk menampilkan gambar logo saat ini --}}
                                <img id="modal_current_logo" src="" alt="Logo Pabrikan Saat Ini"
                                    class="w-16 h-16 object-contain border rounded-lg p-1 bg-white">
                            </div>

                            {{-- Input file baru --}}
                            <input type="file" name="logo_pabrikan" id="modal_logo_pabrikan"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition duration-150">
                        </div>

                        {{-- Tombol Aksi (Disesuaikan dengan styling Save Product) --}}
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" id="closeModalButton"
                                class="close-modal bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg px-4 py-2.5 transition duration-150 shadow-sm focus:outline-none">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2.5 bg-red-700 text-white font-medium rounded-lg shadow-md hover:bg-red-800 transition duration-300 focus:outline-none flex items-center gap-1">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@vite('resources/js/admin/edit.js')
@endsection
