<?php

namespace App\Http\Controllers\Admin;

use App\Models\Penawaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminPenawaranController extends Controller
{
    /**
     * Menampilkan daftar semua penawaran yang masuk di halaman Admin
     */
    public function index(Request $request)
    {
        // 1. Ambil input filter dari request (jika kosong, default ke 7 hari terakhir)
        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

        $startDate = $startDateInput ? Carbon::parse($startDateInput)->startOfDay() : Carbon::now()->subDays(6)->startOfDay();
        $endDate = $endDateInput ? Carbon::parse($endDateInput)->endOfDay() : Carbon::now()->endOfDay();

        // 2. Query untuk list data tabel (mendukung pencarian kode/pelanggan dan status)
        $query = Penawaran::with(['user', 'items.produk'])->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_penawaran', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_pelanggan', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter list tabel berdasarkan date picker juga agar sinkron
        $query->whereBetween('created_at', [$startDate, $endDate]);
        $penawarans = $query->get();

        // 3. LOGIKA GRAFIK: Ambil tren statistik penawaran per hari dalam rentang tanggal
        $chartDataRaw = Penawaran::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->pluck('total', 'date'); // Format hasil: ['2026-05-15' => 4, '2026-05-16' => 8]

        // 4. Looping untuk memastikan setiap hari dalam rentang tanggal terisi (mencegah hari kosong meloncat)
        $days = [];
        $totals = [];

        // Iterasi dari tanggal mulai sampai tanggal akhir
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dateString = $date->format('Y-m-d');

            // Format label tanggal untuk sumbu X grafik (Contoh: "19 Mei")
            $days[] = $date->translatedFormat('d M');

            // Isikan total dokumen, jika hari itu tidak ada transaksi pasang angka 0
            $totals[] = $chartDataRaw->get($dateString, 0);
        }

        // 5. Kembalikan semua data ke view index
        return view('admin.penawaran.index', compact(
            'penawarans',
            'days',
            'totals',
            'startDateInput',
            'endDateInput'
        ));
    }

    public function show($id)
    {
        // Mengambil data penawaran beserta relasi user pengaju, item keranjang, dan data produk terkaitnya
        $penawaran = Penawaran::with(['user', 'items.produk.pabrikan'])->findOrFail($id);

        // Menghitung total kuantitas unit alat kesehatan di dalam dokumen ini sebagai metadata tambahan
        $totalQty = collect($penawaran->items)->sum('jumlah');

        return view('admin.penawaran.show', compact('penawaran', 'totalQty'));
    }

    /**
     * Mengubah status penawaran berdasarkan hasil nego WA
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,disetujui,dibatalkan'
        ]);

        $penawaran = Penawaran::findOrFail($id);
        $penawaran->update([
            'status' => $request->status
        ]);

        // Catatan: Tempat yang tepat untuk panggil Activity Log / Audit Trail kamu nanti!
        // ActivityLog::log("Admin mengubah status penawaran {$penawaran->kode_penawaran} menjadi {$request->status}");

        return redirect()->back()->with('success', 'Status dokumen penawaran berhasil diperbarui!');
    }

    /**
     * 🌟 TAMBAHAN: Menghapus data penawaran jika diperlukan
     */
    public function destroy($id)
    {
        $penawaran = Penawaran::findOrFail($id);

        // Hapus file fisik PDF di folder public terlebih dahulu agar tidak memenuhi storage server
        $pdfPath = public_path('uploads/pdf_penawaran/' . $penawaran->file_pdf);
        if ($penawaran->file_pdf && file_exists($pdfPath)) {
            unlink($pdfPath);
        }

        // Karena di database menggunakan foreign key, pastikan relasi itemnya ikut terhapus
        // (Akan otomatis terhapus jika di migration kamu pakai ->onDelete('cascade'))
        $penawaran->items()->delete();
        $penawaran->delete();

        return redirect()->route('admin.penawaran.index')->with('success', 'Data penawaran berhasil dihapus dari sistem.');
    }
}
