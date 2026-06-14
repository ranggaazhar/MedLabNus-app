<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\StokMutasi;
use Carbon\Carbon;

class GudangDashboardController extends Controller
{
    public function index()
    {
        // Mengambil semua produk beserta mutasinya agar dapat menghitung stok
        $produks = Produk::with('mutasiStok')->get();
        
        $totalStok = 0;
        $stokMenipisCount = 0;
        $stokHabisCount = 0;
        
        $semuaStokMenipis = collect();

        foreach ($produks as $produk) {
            $stok = (int) $produk->total_stok;
            $totalStok += $stok;

            // Asumsi stok menipis adalah di bawah atau sama dengan stok_minimal (atau <= 5 jika tidak diset)
            $batasMenipis = 5;

            if ($stok <= 0) {
                $stokHabisCount++;
            }

            if ($stok <= $batasMenipis) {
                // Jika stok_minimal diatas 5, jangan tampilkan (apapun satuannya)
                if ($produk->stok_minimal > 5) {
                    // skip
                } else {
                    $stokMenipisCount++;
                    $semuaStokMenipis->push(['produk' => $produk, 'sisa' => $produk->stok_minimal]);
                }
            }
        }

        $stokMenipisList = $semuaStokMenipis->take(4);

        // Mutasi Hari Ini
        $mutasiHariIni = StokMutasi::whereDate('created_at', Carbon::today())->count();

        // Aktivitas Mutasi Terbaru (5 terakhir)
        $mutasiTerbaru = StokMutasi::with('produk')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('gudang.dashboard', compact(
            'totalStok',
            'stokMenipisCount',
            'stokHabisCount',
            'mutasiHariIni',
            'stokMenipisList',
            'mutasiTerbaru'
        ));
    }
}
