<?php

namespace App\Http\Controllers\Admin;

use App\Models\StokMutasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class StokMutasiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Parameter Filter dari Request
        $search     = $request->get('search');
        $tipe       = $request->get('tipe');
        $start_date = $request->get('start_date');
        $end_date   = $request->get('end_date');

        // 2. QUERY UNTUK TABEL (PAGINATION)
        // Kita buat base query agar filter bisa dipakai berulang untuk tabel & grafik
        $query = StokMutasi::with(['produk.pabrikan', 'user']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('produk', function($p) use ($search) {
                    $p->where('nama_produk', 'like', "%{$search}%");
                })->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($tipe) {
            $query->where('tipe', $tipe);
        }

        if ($start_date) {
            $query->whereDate('created_at', '>=', $start_date);
        }

        if ($end_date) {
            $query->whereDate('created_at', '<=', $end_date);
        }

        // Ambil data untuk tabel (Paginate 10 data per halaman)
        $mutasis = $query->latest()->paginate(10)->withQueryString();


        // 3. LOGIKA GRAFIK (SINKRON DENGAN FILTER)
        // Tentukan rentang hari yang akan ditampilkan di grafik
        $graphStart = $start_date ? Carbon::parse($start_date) : now()->subDays(6);
        $graphEnd   = $end_date ? Carbon::parse($end_date) : now();
        
        $diffInDays = $graphStart->diffInDays($graphEnd);
        
        // Batasi maksimal 31 titik (1 bulan) agar grafik tidak terlalu rapat
        $limitDays = $diffInDays > 31 ? 31 : $diffInDays;

        $days = collect();
        $stokMasuk = [];
        $stokKeluar = [];

        // Lakukan perulangan untuk setiap hari dalam rentang filter
        for ($i = 0; $i <= $limitDays; $i++) {
            $currentDate = (clone $graphStart)->addDays($i);
            $dateString = $currentDate->format('Y-m-d');
            
            // Label sumbu X (misal: 01 Apr)
            $days->push($currentDate->translatedFormat('d M'));

            /** * PENTING: Kita buat query baru untuk setiap titik hari 
             * tapi tetap membawa filter 'search' agar grafik sinkron.
             */
            $graphQuery = StokMutasi::whereDate('created_at', $dateString);

            if ($search) {
                $graphQuery->where(function($q) use ($search) {
                    $q->whereHas('produk', function($p) use ($search) {
                        $p->where('nama_produk', 'like', "%{$search}%");
                    })->orWhere('keterangan', 'like', "%{$search}%");
                });
            }

            // Hitung jumlah masuk & keluar berdasarkan filter pencarian di hari tersebut
            // Gunakan clone agar query 'whereDate' dan 'search' tidak hilang saat sum()
            $stokMasuk[] = (clone $graphQuery)->where('tipe', 'masuk')->sum('jumlah');
            $stokKeluar[] = (clone $graphQuery)->where('tipe', 'keluar')->sum('jumlah');
        }

        // 4. Kirim semua data ke View
        return view('admin.mutasi.index', compact(
            'mutasis', 
            'search', 
            'tipe', 
            'start_date', 
            'end_date', 
            'days', 
            'stokMasuk', 
            'stokKeluar'
        ));
    }
}