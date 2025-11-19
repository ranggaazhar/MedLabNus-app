<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Pabrikan;
use App\Models\Spesifikasi;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProduk' => Produk::count(),
            'totalPabrikan' => Pabrikan::count(),
            'produkTerbaru' => Produk::latest()->paginate(10),
            'pabrikanTerbaru' => Pabrikan::latest()->take(5)->get(),
        ]);
    }
}
