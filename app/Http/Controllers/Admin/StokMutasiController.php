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
        // Cek apakah ada data mutasi yang sesuai dengan filter pencarian dan rentang tanggal
        $hasDataInFilter = false;
        if ($start_date || $end_date) {
            $checkQuery = StokMutasi::query();
            if ($search) {
                $checkQuery->where(function($q) use ($search) {
                    $q->whereHas('produk', function($p) use ($search) {
                        $p->where('nama_produk', 'like', "%{$search}%");
                    })->orWhere('keterangan', 'like', "%{$search}%");
                });
            }
            if ($tipe) {
                $checkQuery->where('tipe', $tipe);
            }
            if ($start_date) {
                $checkQuery->whereDate('created_at', '>=', $start_date);
            }
            if ($end_date) {
                $checkQuery->whereDate('created_at', '<=', $end_date);
            }
            $hasDataInFilter = $checkQuery->exists();
        }

        // Tentukan rentang hari yang akan ditampilkan di grafik
        if (($start_date || $end_date) && $hasDataInFilter) {
            // Jika ada filter tanggal dari user DAN ada data di rentang tersebut
            $graphStart = $start_date ? Carbon::parse($start_date) : Carbon::parse($end_date)->subDays(6);
            $graphEnd   = $end_date ? Carbon::parse($end_date) : now();
        } else {
            // Jika pertama kali diload, ATAU filter tanggal tidak menghasilkan data sama sekali,
            // Lompat ke data mutasi terakhir yang ada di database
            $latestRecordQuery = StokMutasi::query();
            if ($search) {
                $latestRecordQuery->where(function($q) use ($search) {
                    $q->whereHas('produk', function($p) use ($search) {
                        $p->where('nama_produk', 'like', "%{$search}%");
                    })->orWhere('keterangan', 'like', "%{$search}%");
                });
            }
            if ($tipe) {
                $latestRecordQuery->where('tipe', $tipe);
            }
            
            $latestRecord = $latestRecordQuery->latest('created_at')->first();
            $graphEnd   = $latestRecord ? Carbon::parse($latestRecord->created_at) : now();
            $graphStart = (clone $graphEnd)->subDays(6);
        }

        // Pastikan start_date tidak melampaui end_date
        if ($graphStart->greaterThan($graphEnd)) {
            $temp = $graphStart;
            $graphStart = $graphEnd;
            $graphEnd = $temp;
        }
        
        $diffInDays = $graphStart->diffInDays($graphEnd);
        
        // Batasi maksimal 180 hari agar tidak membebani query database
        $limitDays = $diffInDays > 180 ? 180 : $diffInDays;

        $days = collect();
        $stokMasuk = [];
        $stokKeluar = [];

        // Lakukan perulangan untuk mengisi data hari
        for ($i = 0; $i <= $limitDays; $i++) {
            // Jika rentang hari melebihi 180 hari, hitung mundur dari $graphEnd
            if ($diffInDays > 180) {
                $currentDate = (clone $graphEnd)->subDays(180 - $i);
            } else {
                $currentDate = (clone $graphStart)->addDays($i);
            }
            
            $dateString = $currentDate->format('Y-m-d');
            
            // Label sumbu X (misal: 01 Apr)
            $days->push($currentDate->translatedFormat('d M'));

            $graphQuery = StokMutasi::whereDate('created_at', $dateString);

            if ($search) {
                $graphQuery->where(function($q) use ($search) {
                    $q->whereHas('produk', function($p) use ($search) {
                        $p->where('nama_produk', 'like', "%{$search}%");
                    })->orWhere('keterangan', 'like', "%{$search}%");
                });
            }

            // Hitung jumlah masuk & keluar berdasarkan filter pencarian di hari tersebut (selalu tampilkan keduanya di grafik)
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