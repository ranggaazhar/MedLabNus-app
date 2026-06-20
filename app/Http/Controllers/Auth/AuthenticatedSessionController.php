<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // Aktifkan proteksi rate limiting dari LoginRequest (maks 5 percobaan gagal)
        $request->ensureIsNotRateLimited();

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 1. Coba Login sebagai Staff Internal (Admin / Gudang berada di tabel & guard yang sama)
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            // Ambil data user internal yang baru saja login
            $user = Auth::guard('admin')->user();

            // BLOKIR AKUN YANG DINONAKTIFKAN
            if (!$user->is_active) {
                Auth::guard('admin')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator untuk informasi lebih lanjut.',
                ])->onlyInput('email');
            }

            \Illuminate\Support\Facades\RateLimiter::clear($request->throttleKey());
            $request->session()->regenerate();

            // REDIRECT DINAMIS BERDASARKAN ROLE
            if ($user->role === 'gudang') {
                return redirect()->route('gudang.dashboard')->with('success', 'Selamat Datang Staf Gudang!');
            }

            return redirect()->route('admin.dashboard')->with('success', 'Selamat Datang Admin!');
        }

        // 2. Coba Login sebagai User Biasa / Pelanggan (Guard Web)
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            \Illuminate\Support\Facades\RateLimiter::clear($request->throttleKey());
            $request->session()->regenerate();
            return redirect()->route('welcome')->with('success', 'Login Berhasil!');
        }

        // Semua guard gagal — catat sebagai percobaan gagal
        \Illuminate\Support\Facades\RateLimiter::hit($request->throttleKey());

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request): RedirectResponse
    {
        // Logout dari semua guard yang mungkin sedang login
        Auth::guard('admin')->logout();
        // Auth::guard('gudang')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
