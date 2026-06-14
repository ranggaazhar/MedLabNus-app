<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Penawaran;
use App\Models\Invoice;
use App\Models\User;
use Spatie\Activitylog\Models\Activity; // Tambahkan import model Spatie
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $rentang = $request->input('rentang', '12_bulan');

        $startDate = null;
        if ($rentang === '7_hari') {
            $startDate = Carbon::now()->subDays(7)->startOfDay();
        } elseif ($rentang === '30_hari') {
            $startDate = Carbon::now()->subDays(30)->startOfDay();
        } elseif ($rentang === '12_bulan') {
            $startDate = Carbon::now()->subMonths(12)->startOfDay();
        }

        // 1. Ambil data statistik card utama (Dashboard Utama)
        $totalPenawaranQuery = Penawaran::query();
        $invoiceBulanIniQuery = Invoice::query();
        $penawaranMasukQuery = Penawaran::where('status', 'pending');
        $pelangganAktifQuery = User::query();

        if ($startDate) {
            $totalPenawaranQuery->where('created_at', '>=', $startDate);
            $invoiceBulanIniQuery->where('created_at', '>=', $startDate);
            $penawaranMasukQuery->where('created_at', '>=', $startDate);
            $pelangganAktifQuery->where('created_at', '>=', $startDate);
        }

        $totalPenawaran = $totalPenawaranQuery->count();
        $invoiceBulanIni = $invoiceBulanIniQuery->count();
        $penawaranMasuk = $penawaranMasukQuery->count();
        $pelangganAktif = $pelangganAktifQuery->count();

        // Mockup Persentase Tren Kenaikan untuk UI Metric Cards
        $persentase = [
            'penawaran' => '+12%',
            'invoice' => '+8%',
            'penawaran_masuk' => 'In Review',
            'pelanggan' => '+24%'
        ];

        // 2. Data Grafik Penawaran Keluar Berdasarkan Filter
        $grafikTanggal = collect();
        $grafikData = collect();
        
        if ($rentang === '7_hari') {
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $grafikTanggal->push($date->locale('id')->isoFormat('ddd')); 
                $count = Penawaran::whereDate('created_at', $date->format('Y-m-d'))->count();
                $grafikData->push($count);
            }
        } elseif ($rentang === '30_hari') {
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                // Hanya push label setiap 5 hari agar tidak penuh
                $grafikTanggal->push($i % 5 == 0 ? $date->format('d/m') : ''); 
                $count = Penawaran::whereDate('created_at', $date->format('Y-m-d'))->count();
                $grafikData->push($count);
            }
        } else {
            // 12 Bulan Terakhir
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $grafikTanggal->push($date->locale('id')->isoFormat('MMM YY')); 
                $count = Penawaran::whereMonth('created_at', $date->month)
                                  ->whereYear('created_at', $date->year)->count();
                $grafikData->push($count);
            }
        }

        // 3. Data Top 5 Produk Terlaris berdasarkan produk paling laku di Invoice (Status Lunas)
        $topProdukIds = \App\Models\InvoiceItem::select('produk_id', \DB::raw('SUM(jumlah) as total_terjual'))
            ->whereHas('invoice', function ($query) use ($startDate) {
                $query->whereIn('status_pembayaran', ['lunas', 'Lunas', 'paid', 'Paid', 'LUNAS', 'PAID']);
                if ($startDate) {
                    $query->where('created_at', '>=', $startDate);
                }
            })
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        if ($topProdukIds->isNotEmpty()) {
            $ids = $topProdukIds->pluck('produk_id')->toArray();
            $topProdukData = Produk::with('pabrikan')->whereIn('produk_id', $ids)->get();
                
            $totals = $topProdukIds->pluck('total_terjual', 'produk_id');
            foreach ($topProdukData as $produk) {
                $produk->total_terjual = $totals[$produk->produk_id] ?? 0;
            }
            // Urutkan collection dari yang paling laku
            $topProduk = $topProdukData->sortByDesc('total_terjual')->values();
        } else {
            // Fallback jika belum ada data invoice lunas
            $topProduk = Produk::with('pabrikan')->latest()->take(5)->get();
            foreach ($topProduk as $produk) {
                $produk->total_terjual = 0;
            }
        }

        // 4. Tabel Penawaran Terbaru (Bawah Kiri)
        $penawaranTerbaru = Penawaran::with('user')->latest()->take(5)->get();

        // 5. RIIL AUDIT TRAIL LOGS (Bawah Kanan)
        // Menarik 4 data log aktivitas terbaru beserta relasi user (causer)
        $aktivitasSistem = Activity::with('causer')
                                   ->latest()
                                   ->take(5)
                                   ->get();

        // Kirim semua data riil ke View Dashboard Utama Admin
        return view('admin.dashboard', compact(
            'totalPenawaran',
            'invoiceBulanIni',
            'penawaranMasuk',
            'pelangganAktif',
            'persentase',
            'grafikTanggal',
            'grafikData',
            'topProduk',
            'penawaranTerbaru',
            'aktivitasSistem', // Variabel log riil dikirim ke view
            'rentang'
        ));
    }
}