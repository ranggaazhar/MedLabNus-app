<?php

namespace App\Http\Controllers\User;

use App\Models\Penawaran;
use App\Models\PenawaranItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PenawaranController extends Controller
{
    /**
     * Menyimpan data permintaan penawaran baru dari Pelanggan
     */
    public function store(Request $request)
    {
        Log::info('=== PENAWARAN STORE: DATA MASUK ===', $request->all());

        $request->validate([
            'nama_pelanggan' => 'required|string',
            'whatsapp_pelanggan' => 'required|string',
            'items' => 'required|array'
        ]);

        // 🌟 Mulai transaksi database
        DB::beginTransaction();

        try {
            // 1. Simpan Data Awal ke Database Utama Penawaran
            $penawaran = new Penawaran();
            $penawaran->user_id = Auth::id();
            $penawaran->nama_pelanggan = $request->nama_pelanggan;
            $penawaran->whatsapp_pelanggan = $request->whatsapp_pelanggan;

            // Buat kode penawaran terlebih dahulu
            $kodePenawaran = 'PNW-' . strtoupper(Str::random(6));
            $penawaran->kode_penawaran = $kodePenawaran;

            // 🌟 TAMBAHKAN BARIS INI: Definisikan nama file PDF yang akan disimpan ke database
            $pdfName = 'Surat_Penawaran_' . $kodePenawaran . '.pdf';
            $penawaran->file_pdf = $pdfName; // Memasukkan nama file ke kolom file_pdf

            $penawaran->save();

            // 2. Simpan ke tabel penawaran_items
            foreach ($request->items as $index => $item) {
                $penawaranItem = new PenawaranItem();
                $penawaranItem->penawaran_id = $penawaran->id;
                $penawaranItem->produk_id = isset($item['produk_id']) ? $item['produk_id'] : $item['id_produk'];
                $penawaranItem->jumlah = $item['jumlah'];
                $penawaranItem->save();
            }

            // 3. Ambil data lengkap untuk dilempar ke view PDF
            $penawaranData = Penawaran::with('items.produk')->find($penawaran->id);

            // 4. Generate & Simpan Fisik File PDF ke Folder Public
            $pdf = Pdf::loadView('pdf.surat_penawaran', compact('penawaranData'));
            $pdfPath = 'uploads/pdf_penawaran/' . $pdfName;

            if (!file_exists(public_path('uploads/pdf_penawaran'))) {
                mkdir(public_path('uploads/pdf_penawaran'), 0777, true);
            }

            $pdf->save(public_path($pdfPath));

            // Jika semua proses aman, Commit transaksi database
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permintaan penawaran berhasil diproses!',
                'pdf_url' => asset($pdfPath),
                'kode_penawaran' => $penawaran->kode_penawaran
            ]);
        } catch (\Exception $e) {
            // 🌟 Jika ada error di bagian mana pun, batalkan semua insert data agar tidak menggantung
            DB::rollBack();

            Log::error('=== PENAWARAN STORE ERROR CRASH ===', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function keranjang()
    {
        // 1. Ambil satu produk acak untuk memancing rekomendasi
        $baseProduct = Produk::inRandomOrder()->first();

        // 2. Jika database masih kosong, langsung oper collection kosong agar tidak error
        if (!$baseProduct) {
            $relatedProducts = collect();
            return view('frontend.penawaran.keranjang', compact('relatedProducts'));
        }

        // 3. Ambil produk terkait berdasarkan 'pabrikan_id' yang sama (Bukan kategori_id)
        $relatedProducts = Produk::with('pabrikan')
            ->where('pabrikan_id', $baseProduct->pabrikan_id) // Menggunakan pabrikan_id yang lebih aman
            ->where('produk_id', '!=', $baseProduct->produk_id)
            ->take(8)
            ->get();

        // 4. JAGA-JAGA: Jika produk dari pabrikan yang sama kurang dari 4,
        // kita gabungkan dengan produk acak lainnya agar slider-nya tetap ramai
        if ($relatedProducts->count() < 4) {
            $backupProducts = Produk::with('pabrikan')
                ->where('produk_id', '!=', $baseProduct->produk_id)
                ->inRandomOrder()
                ->take(8)
                ->get();

            // Gabungkan, hilangkan duplikasi berdasarkan produk_id, lalu ambil 8
            $relatedProducts = $relatedProducts->merge($backupProducts)->unique('produk_id')->take(8);
        }

        // 4. Kirim data ke view keranjang
        return view('components.keranjang_penawaran', compact('relatedProducts'));
    }
}
