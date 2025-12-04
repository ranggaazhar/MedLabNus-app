@props(['pabrikan'])

{{-- Card container --}}
<div class="bg-white rounded-2xl shadow-md p-5 flex flex-col justify-between h-52 transition-all duration-300 ease-in-out hover:shadow-xl hover:scale-[1.01] border border-gray-100">
    
    {{-- Bagian Atas: Logo --}}
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center space-x-2">
            @if ($pabrikan->logo_pabrikan)
                <img src="{{ asset('storage/' . $pabrikan->logo_pabrikan) }}"
                    alt="{{ $pabrikan->nama_pabrikan }}"
                    class="h-8 w-auto max-h-8 object-contain"> 
            @else
                {{-- Placeholder jika tidak ada logo --}}
                <div class="h-8 w-8 flex items-center justify-center text-gray-400">
                    <i class="fas fa-industry text-base"></i>
                </div>
            @endif
        </div>
    </div>

    {{-- Bagian Tengah: Nama Pabrikan Utama --}}
    <div class="flex-1 -mt-2">
        <h3 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ $pabrikan->nama_pabrikan }}
        </h3>
        
        {{-- Asal Negara --}}
        <p class="text-base text-gray-500 mt-1">
            {{ $pabrikan->asal_negara }}
        </p>
    </div>

    {{-- Bagian Bawah: Tombol Aksi --}}
    <div class="flex justify-between items-center mt-3 w-full">
        
        {{-- Tombol Edit --}}
        <a href="{{ route('pabrikan.edit', $pabrikan) }}" title="Edit Data Pabrikan"
            class="bg-gray-800 text-white hover:bg-gray-900 
                   font-medium py-2 px-5 rounded-lg 
                   transition duration-300 ease-in-out flex items-center space-x-2 
                   focus:outline-none focus:ring-2 focus:ring-gray-300 transform hover:scale-[1.03]">
            
            <img src="{{ asset('icons/edit.svg') }}" 
                 alt="Edit Icon" 
                 class="w-5 h-5 brightness-0 invert">
            
            <span class="text-sm">Edit</span>
        </a>

        {{-- Tombol Hapus (UPDATED FOR SWEETALERT) --}}
        <form action="{{ route('pabrikan.destroy', $pabrikan) }}" method="POST">
            @csrf
            @method('DELETE')
            {{-- Perhatikan: type="button" dan penambahan class "btn-delete" --}}
            <button type="button" title="Hapus Data Pabrikan"
                class="btn-delete bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-5 rounded-lg 
                       transition duration-300 ease-in-out 
                       flex items-center space-x-2 focus:outline-none focus:ring-2 focus:ring-red-300 transform hover:scale-[1.03]">
                <i class="fas fa-trash-alt text-xs"></i>
                <span class="text-sm">Delete</span>
            </button>
        </form>
    </div>
</div>

{{-- SWEETALERT LOGIC --}}
{{-- Menggunakan @once agar script tidak diduplikasi jika component ini di-loop --}}
@once
    {{-- Pastikan library SweetAlert2 sudah diload di layout utama (app.blade.php) --}}
    {{-- Jika belum, uncomment baris di bawah ini: --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Logic Hapus
            // Event delegation lebih aman, tapi ini sesuai request Anda (querySelectorAll)
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data pabrikan tidak dapat dikembalikan setelah dihapus!", // Saya sesuaikan text jadi 'pabrikan'
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Logic Alert Success/Error dari Session
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ session('error') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
@endonce