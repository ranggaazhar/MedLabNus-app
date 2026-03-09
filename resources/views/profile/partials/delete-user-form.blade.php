<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    {{-- Tombol Pemicu Modal --}}
    <button
        class="inline-flex items-center px-6 py-2 bg-red-600 border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Hapus Akun Saya') }}
    </button>

    {{-- Modal Konfirmasi --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-white rounded-2xl">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Setelah akun Anda dihapus, semua data akan hilang selamanya. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Kata Sandi') }}</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full md:w-3/4 border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm bg-white text-gray-900 p-2.5"
                    placeholder="{{ __('Masukkan Kata Sandi Anda') }}"
                />

                @if($errors->userDeletion->get('password'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="mt-6 flex justify-end gap-3">
                {{-- Tombol Batal --}}
                <button 
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="inline-flex items-center px-6 py-2 bg-gray-100 border border-transparent rounded-full font-bold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 transition ease-in-out duration-150"
                >
                    {{ __('Batal') }}
                </button>

                {{-- Tombol Konfirmasi Hapus --}}
                <button 
                    type="submit"
                    class="inline-flex items-center px-6 py-2 bg-red-600 border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150 shadow-sm"
                >
                    {{ __('Ya, Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>