<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $totalProduk = Produk::count();
        
        // --- Perubahan di sini: Menambahkan perhitungan kategori baru ---
        $totalAlat = Produk::where('kategori', 'alat')->count();
        $totalReagen = Produk::where('kategori', 'reagen')->count();
        $totalSteril = Produk::where('kategori', 'steril')->count();
        $totalNonSteril = Produk::where('kategori', 'non steril')->count();
        $totalInvitro = Produk::where('kategori', 'invitro')->count();
        // ----------------------------------------------------------------
        
        $query = Produk::with(['pabrikan', 'spesifikasis']);

        // Blok ini menggabungkan dua pengecekan if yang redundant
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }
        
        // (Saya menghapus blok if yang sama di bawahnya untuk menghindari redundansi)

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('deskripsi_singkat', 'like', "%{$search}%")
                  ->orWhereHas('pabrikan', function($q2) use ($search) {
                      $q2->where('nama_pabrikan', 'like', "%{$search}%");
                  });
            });
        }


        $produkTerbaru = $query->latest()->paginate(10)->withQueryString();

        return view('dashboard', compact(
            'totalProduk',
            'totalAlat',
            'totalReagen',
            // --- Perubahan di sini: Mengirim variabel kategori baru ke view ---
            'totalSteril',
            'totalNonSteril',
            'totalInvitro',
            // ----------------------------------------------------------------
            'produkTerbaru'
        ));
    }
}