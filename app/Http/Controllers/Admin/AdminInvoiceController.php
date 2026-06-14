<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Penawaran;
use App\Models\StokMutasi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminInvoiceController extends Controller
{
    /**
     * Tampilkan semua daftar invoice untuk Admin
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['adminCreator']);

        // Filter berdasarkan status pembayaran jika admin memilih filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pembayaran', $request->status);
        }

        // Pencarian berdasarkan kode invoice atau nama instansi pelanggan
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('kode_invoice', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_pelanggan', 'like', '%' . $request->search . '%');
            });
        }

        $invoices = $query->latest()->paginate(10);

        return view('admin.invoice.index', compact('invoices'));
    }

    /**
     * Form pembuatan invoice baru (Mendukung penarikan data dari Surat Penawaran)
     */
    public function create(Request $request)
    {
        // Ambil semua data penawaran, langsung tarik relasi items dan produknya ke memory PHP 🌟
        $daftarPenawaran = Penawaran::with('items.produk')
            ->orderBy('created_at', 'desc')
            ->get();

        // Kirim data ke view
        return view('admin.invoice.create', compact('daftarPenawaran'));
    }

    /**
     * Endpoint API internal untuk mengambil detail penawaran (opsional jika dibutuhkan di tempat lain)
     */
    public function ambilPenawaranAjax($id)
    {
        // Eager loading mengambil item penawaran beserta harga master produknya
        $penawaran = Penawaran::with('items.produk')->find($id);

        if (!$penawaran) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'nama_pelanggan' => $penawaran->nama_pelanggan,
            'whatsapp_pelanggan' => $penawaran->whatsapp_pelanggan,
            'items' => $penawaran->items
        ]);
    }

    /**
     * Simpan invoice baru beserta kalkulasi nominal otomatis & Audit Trail
     */
    public function store(\App\Http\Requests\StoreInvoiceRequest $request)
    {
        Log::info('=== INVOICE STORE GENERATION: DATA MASUK ===', $request->all());

        // Validasi sudah ditangani oleh StoreInvoiceRequest
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Hitung subtotal, pajak, & total_harga dari request items sebelum simpan invoice
            $subtotal = 0;
            foreach ($request->items as $item) {
                $totalItemHarga = $item['jumlah'] * $item['harga_satuan'];
                $subtotal += $totalItemHarga;
            }
            $pajakPpn   = $subtotal * 0.11;
            $totalHarga = $subtotal + $pajakPpn;

            $invoice = new Invoice();
            $invoice->penawaran_id      = $request->penawaran_id;
            $invoice->nama_pelanggan    = $request->nama_pelanggan;
            $invoice->status_pembayaran = $request->status_pembayaran; // ← FIX 2
            $invoice->created_by        = Auth::id();

            // Normalisasi nomor HP WhatsApp
            $nomor_hp = $request->whatsapp_pelanggan;
            if (str_starts_with($nomor_hp, '0'))        $nomor_hp = substr($nomor_hp, 1);
            elseif (str_starts_with($nomor_hp, '+62'))  $nomor_hp = substr($nomor_hp, 3);
            elseif (str_starts_with($nomor_hp, '62'))   $nomor_hp = substr($nomor_hp, 2);
            $invoice->whatsapp_pelanggan = '62' . $nomor_hp;

            // Generate Kode Invoice
            $tahunBulan          = now()->format('Ym');
            $cekInvoiceTerakhir  = Invoice::where('kode_invoice', 'like', "INV-{$tahunBulan}-%")->latest()->first();
            $nomorUrutBaru       = $cekInvoiceTerakhir
                ? str_pad((int) substr($cekInvoiceTerakhir->kode_invoice, -4) + 1, 4, '0', STR_PAD_LEFT)
                : '0001';

            $kodeInvoice       = "INV-{$tahunBulan}-{$nomorUrutBaru}";
            $invoice->kode_invoice = $kodeInvoice;

            $pdfName         = 'Invoice_' . str_replace('/', '_', $kodeInvoice) . '.pdf';
            $invoice->file_pdf = $pdfName;

            // Set data nominal sebelum save agar langsung ter-log di activity log
            $invoice->subtotal    = $subtotal;
            $invoice->pajak_ppn   = $pajakPpn;
            $invoice->total_harga = $totalHarga;
            $invoice->save();

            // Simpan items
            foreach ($request->items as $item) {
                $totalItemHarga = $item['jumlah'] * $item['harga_satuan'];

                InvoiceItem::create([
                    'invoice_id'       => $invoice->id,
                    'produk_id'        => $item['produk_id'] ?? null,
                    'nama'             => $item['nama'],
                    'jumlah'           => $item['jumlah'],
                    'harga_satuan'     => $item['harga_satuan'],
                    'total_item_harga' => $totalItemHarga,
                ]);
            }

            // ← FIX 3: Kurangi stok jika langsung lunas saat pembuatan invoice
            if ($request->status_pembayaran === 'lunas') {
                // Gunakan $request->items langsung — lebih efisien, data sudah ada
                foreach ($request->items as $itemData) {
                    $produkId = $itemData['produk_id'] ?? null;

                    // Skip jika tidak ada relasi ke produk master
                    if (!$produkId) continue;

                    $produk = Produk::find($produkId);

                    // Skip jika produk tidak ditemukan di database
                    if (!$produk) {
                        Log::warning("Produk ID {$produkId} tidak ditemukan saat pengurangan stok invoice.");
                        continue;
                    }

                    $jumlah = (int) $itemData['jumlah'];

                    // ← Sesuaikan nama kolom stok dengan kolom di tabel produks kamu
                    $namaKolomStok   = 'stok_minimal';        // ganti jika berbeda, misal: 'stok_tersedia', 'qty'
                    $namaKolomNama   = 'nama_produk'; // ganti sesuai kolom nama di tabel produks

                    Log::info("Cek stok produk", [
                        'produk_id' => $produkId,
                        'nama'      => $produk->$namaKolomNama ?? '(kolom nama salah)',
                        'stok'      => $produk->$namaKolomStok ?? '(kolom stok salah)',
                        'dibutuhkan' => $jumlah,
                    ]);

                    if ($produk->$namaKolomStok < $jumlah) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => "Stok produk \"{$produk->$namaKolomNama}\" tidak mencukupi. " .
                                "Tersedia: {$produk->$namaKolomStok}, dibutuhkan: {$jumlah}."
                        ], 422);
                    }

                    $produk->$namaKolomStok -= $jumlah;
                    $produk->save();

                    $produk->mutasiStok()->create([
                        'produk_id'  => $produk->produk_id,
                        'jumlah'     => $jumlah,
                        'tipe'       => 'keluar', // Stok berkurang karena invoice lunas
                        'keterangan' => 'Pengurangan stok otomatis via Invoice: ' . $kodeInvoice,
                        'role_id'    => Auth::id(),
                        'role_type'  => get_class(Auth::user()),
                    ]);
                }
            }

            // Hapus kode yang menyimpan PDF secara fisik ke folder uploads
            // File akan digenerate on-the-fly ketika route admin.invoice.download-pdf diakses
            
            DB::commit();

            return response()->json([
                'success'       => true,
                'message'       => "Invoice {$kodeInvoice} berhasil diterbitkan!",
                'pdf_url'       => route('admin.invoice.download-pdf', $invoice->id),
                'kode_invoice'  => $invoice->kode_invoice,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('=== INVOICE STORE ERROR CRASH ===', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan detail spesifik dari satu Invoice
     */
    public function show($id)
    {
        $invoice = Invoice::with(['invoiceItems.produk', 'adminCreator'])->findOrFail($id);
        return view('admin.invoice.show', compact('invoice'));
    }

    /**
     * Update status pembayaran oleh admin (Lunas / Batal)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:pending,lunas,batal'
        ]);

        $invoice = Invoice::with('invoiceItems.produk')->findOrFail($id);

        // Cegah update berulang jika sudah lunas
        if ($invoice->status_pembayaran === 'lunas' && $request->status_pembayaran === 'lunas') {
            return redirect()->back()->with('error', 'Invoice ini sudah berstatus lunas.');
        }

        DB::beginTransaction();

        try {
            // Kurangi stok hanya saat pertama kali berubah menjadi 'lunas'
            if ($request->status_pembayaran === 'lunas' && $invoice->status_pembayaran !== 'lunas') {
                foreach ($invoice->invoiceItems as $item) {
                    // Skip jika item tidak terhubung ke produk master
                    if (!$item->produk_id || !$item->produk) {
                        continue;
                    }

                    $produk = $item->produk;

                    // Validasi stok mencukupi sebelum dikurangi
                    if ($produk->stok < $item->jumlah) {
                        DB::rollBack();
                        return redirect()->back()->with(
                            'error',
                            "Stok produk \"{$produk->nama}\" tidak mencukupi. " .
                                "Stok tersedia: {$produk->stok}, dibutuhkan: {$item->jumlah}."
                        );
                    }

                    $produk->stok -= $item->jumlah;
                    $produk->save();

                    // ... di dalam loop setelah $produk->save();
                    $produk->mutasiStok()->create([
                        'produk_id'  => $produk->produk_id,
                        'jumlah'     => $item->jumlah,
                        'tipe'       => 'keluar', // Stok berkurang saat berubah menjadi lunas
                        'keterangan' => 'Pengurangan stok otomatis melalui update status Invoice: ' . $invoice->kode_invoice,
                        'role_id'    => Auth::id(),
                        'role_type'  => get_class(Auth::user()),
                    ]);
                }
            }

            $invoice->status_pembayaran = $request->status_pembayaran;
            $invoice->save();

            DB::commit();

            return redirect()->back()->with('success', "Status invoice {$invoice->kode_invoice} berhasil diperbarui.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update status invoice gagal', [
                'invoice_id' => $id,
                'message'    => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status invoice.');
        }
    }

    /**
     * 🖨️ FITUR UTAMA: Cetak Faktur/Invoice Resmi ke format PDF (Menggunakan data PT. Medlab Nusantara)
     */
    public function generatePdf($id)
    {
        // Tarik data lengkap invoice beserta produk dan admin pembuatnya
        $invoice = Invoice::with(['invoiceItems.produk', 'adminCreator'])->findOrFail($id);

        // Load dokumen view khusus cetak PDF dan kirimkan datanya
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('invoice'));

        // Atur ukuran kertas ke A4 dengan orientasi Portrait
        $pdf->setPaper('a4', 'portrait');

        // Kembalikan file PDF agar langsung terunduh otomatis dengan nama sesuai nomor invoice
        return $pdf->download('Invoice-' . $invoice->kode_invoice . '.pdf');
    }

    // Di AdminInvoiceController.php

    // GANTI destroy($id) menjadi cancel($id)
    public function cancel($id)
    {
        $invoice = Invoice::findOrFail($id);

        // Validasi: Hanya bisa dibatalkan jika status masih 'pending'
        if ($invoice->status_pembayaran !== 'pending') {
            return redirect()->back()->with('error', 'Invoice yang sudah lunas tidak dapat dibatalkan.');
        }

        $invoice->update(['status_pembayaran' => 'batal']);
        return redirect()->back()->with('success', 'Invoice berhasil dibatalkan.');
    }
}
