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

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 1. Coba Login sebagai Admin
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            // Menggunakan name route 'dashboard' yang mengarah ke /admin/dashboard
            return redirect()->route('dashboard')->with('success', 'Selamat Datang Admin!');
        }

        // // 2. Coba Login sebagai Gudang (Aktifkan jika sudah siap)
        // if (Auth::guard('gudang')->attempt($credentials, $request->boolean('remember'))) {
        //     $request->session()->regenerate();
        //     return redirect()->route('gudang.dashboard')->with('success', 'Selamat Datang Staf Gudang!');
        // }

        // 3. Coba Login sebagai User Biasa
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('welcome')->with('success', 'Login Berhasil!');
        }

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
