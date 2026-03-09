<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            {{ __('Perbarui Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanan.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Password Saat Ini --}}
        <div>
            <label for="update_password_current_password" class="block font-medium text-sm text-gray-700">Kata Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" 
                class="mt-1 block w-full border-gray-300 focus:border-[#B1252E] focus:ring-[#B1252E] rounded-lg shadow-sm bg-white text-gray-900 p-2.5" 
                autocomplete="current-password" />
            @if($errors->updatePassword->get('current_password'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        {{-- Password Baru --}}
        <div>
            <label for="update_password_password" class="block font-medium text-sm text-gray-700">Kata Sandi Baru</label>
            <input id="update_password_password" name="password" type="password" 
                class="mt-1 block w-full border-gray-300 focus:border-[#B1252E] focus:ring-[#B1252E] rounded-lg shadow-sm bg-white text-gray-900 p-2.5" 
                autocomplete="new-password" />
            @if($errors->updatePassword->get('password'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm text-gray-700">Konfirmasi Kata Sandi</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                class="mt-1 block w-full border-gray-300 focus:border-[#B1252E] focus:ring-[#B1252E] rounded-lg shadow-sm bg-white text-gray-900 p-2.5" 
                autocomplete="new-password" />
            @if($errors->updatePassword->get('password_confirmation'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex items-center gap-4">
            <button type="submit" 
                class="inline-flex items-center px-6 py-2 bg-[#B1252E] border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-[#8f1d24] active:bg-[#B1252E] focus:outline-none focus:ring-2 focus:ring-[#B1252E] focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                {{ __('Simpan Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>