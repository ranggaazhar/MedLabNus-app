<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui nama akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Input Nama --}}
        <div>
            <label for="name" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
            <input id="name" name="name" type="text" 
                class="mt-1 block w-full border-gray-300 focus:border-[#B1252E] focus:ring-[#B1252E] rounded-lg shadow-sm bg-white text-gray-900 p-2.5" 
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @if($errors->get('name'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('name') }}</p>
            @endif
        </div>

        {{-- Input Email --}}
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email" name="email" type="email" 
                class="mt-1 block w-full border-gray-300 focus:border-[#B1252E] focus:ring-[#B1252E] rounded-lg shadow-sm bg-white text-gray-900 p-2.5" 
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @if($errors->get('email'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B1252E]">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex items-center gap-4">
            <button type="submit" 
                class="inline-flex items-center px-6 py-2 bg-[#B1252E] border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-[#8f1d24] active:bg-[#B1252E] focus:outline-none focus:ring-2 focus:ring-[#B1252E] focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
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