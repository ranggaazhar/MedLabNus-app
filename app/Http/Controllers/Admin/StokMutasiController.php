<?php

namespace App\Http\Controllers\Admin;

use App\Models\StokMutasi; // Pastikan nama model sesuai (StokMutasi / MutasiStok)
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StokMutasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $tipe = $request->get('tipe');

        $mutasis = StokMutasi::with(['produk', 'user']) // Eager load relasi
            ->when($search, function($query, $search) {
                return $query->whereHas('produk', function($q) use ($search) {
                    $q->where('nama_produk', 'like', "%{$search}%");
                })->orWhere('keterangan', 'like', "%{$search}%");
            })
            ->when($tipe, function($query, $tipe) {
                return $query->where('tipe', $tipe);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.mutasi.index', compact('mutasis', 'search', 'tipe'));
    }
}