<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pabrikan;
use App\Models\Spesifikasi;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Exports\ProdukExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function checkNamaProduk(Request $request)
    {
        $nama = $request->input('nama_produk');
        $produkId = $request->input('produk_id');

        $query = Produk::where('nama_produk', $nama);

        if ($produkId) {
            $query->where('produk_id', '!=', $produkId);
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }

    public function export(Request $request)
    {
        $kategori = $request->query('kategori', 'semua');
        $search = $request->query('search');

        $filename = 'produk_' . ($kategori !== 'semua' ? $kategori . '_' : '') . date('YmdHis') . '.xlsx';

        return Excel::download(new ProdukExport($kategori, $search), $filename);
    }

    public function create()
    {
        $pabrikans = Pabrikan::orderBy('nama_pabrikan')->get();
        return view('admin.produk.create', compact('pabrikans'));
    }

    public function store(StoreProdukRequest $request)
    {
        Log::info('--- PROSES STORE PRODUK DIMULAI ---');

        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Kolom baru sudah otomatis masuk lewat $request->validated() 
            // jika sudah ditambahkan di StoreProdukRequest

            $nama_file_baru = null;
            if ($request->hasFile('gambar_utama')) {
                $file = $request->file('gambar_utama');
                $nama_file_baru = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products'), $nama_file_baru);
                $data['gambar_utama'] = 'uploads/products/' . $nama_file_baru;
            }

            $produk = Produk::create($data);
            Log::info('Produk Berhasil Dibuat. ID Produk: ' . $produk->produk_id);

            // --- LOGIKA STOK AWAL ---
            if ($request->has('stok_awal') && $request->stok_awal > 0) {
                $produk->mutasiStok()->create([
                    'jumlah'     => $request->stok_awal,
                    'tipe'       => 'masuk',
                    'keterangan' => 'Pemasukan stok awal produk',
                    'role_id'    => Auth::id(),
                    'role_type'  => get_class(Auth::user()),
                ]);
                Log::info('Stok awal dicatat: ' . $request->stok_awal);
            }

            if ($request->has('spesifikasi') && is_array($request->spesifikasi)) {
                foreach ($request->spesifikasi as $index => $spec) {
                    if (!empty($spec['nama_spesifikasi']) && !empty($spec['nilai'])) {
                        $produk->spesifikasis()->create([
                            'nama_spesifikasi' => $spec['nama_spesifikasi'],
                            'nilai' => $spec['nilai']
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Produk dan stok awal berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Pesan Error: ' . $e->getMessage());

            if ($nama_file_baru && file_exists(public_path('uploads/products/' . $nama_file_baru))) {
                unlink(public_path('uploads/products/' . $nama_file_baru));
            }

            return redirect()->back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function show(Produk $produk)
    {
        // Memuat stok mutasi juga agar bisa menampilkan angka stok real-time di Admin
        $produk->load(['pabrikan', 'spesifikasis', 'mutasiStok']);
        return view('admin.produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        $produk->load('spesifikasis');
        $pabrikans = Pabrikan::orderBy('nama_pabrikan')->get();
        return view('admin.produk.edit', compact('produk', 'pabrikans'));
    }

    public function update(UpdateProdukRequest $request, Produk $produk)
    {
        try {
            DB::beginTransaction();

            // 1. Ambil data yang telah divalidasi oleh Request
            $data = $request->validated();

            // --- LOGIKA TRANSFORMASI DATA KE STOK MUTASI ---

            // A. Cek input 'stok_awal' (Penambahan Stok Fisik manual)
            if ($request->filled('stok_awal') && $request->stok_awal > 0) {
                $produk->mutasiStok()->create([
                    'produk_id'  => $produk->produk_id,
                    'jumlah'     => $request->stok_awal,
                    'tipe'       => 'masuk',
                    'keterangan' => 'Penambahan stok fisik melalui pengeditan produk',
                    'role_id'    => Auth::id(),
                    'role_type'  => get_class(Auth::user()),
                ]);
            }

            // B. Cek perubahan Stok Minimal (Transformasi Data Otomatis)
            $stokMinLama = (int) $produk->getOriginal('stok_minimal');
            $stokMinBaru = (int) $request->input('stok_minimal');

            if ($stokMinBaru !== $stokMinLama) {
                // Hitung selisih agar Sum Otomatis di tabel stok bekerja
                $selisih = $stokMinBaru - $stokMinLama;

                $produk->mutasiStok()->create([
                    'produk_id'  => $produk->produk_id,
                    'jumlah'     => abs($selisih), // Menggunakan angka positif untuk record
                    'tipe'       => $selisih > 0 ? 'masuk' : 'keluar',
                    'keterangan' => "Transformasi Data: Perubahan batas stok minimal dari {$stokMinLama} ke {$stokMinBaru}",
                    'role_id'    => Auth::id(),
                    'role_type'  => get_class(Auth::user()),
                ]);
            }

            // --- LOGIKA UPDATE DATA PRODUK ---

            // Hapus stok_awal dari array data agar tidak error saat update tabel produks
            unset($data['stok_awal']);

            // Handle Gambar Utama
            $old_image_path = $produk->gambar_utama;
            $nama_file_baru = null;

            if ($request->hasFile('gambar_utama')) {
                $file = $request->file('gambar_utama');
                $nama_file_baru = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products'), $nama_file_baru);
                $data['gambar_utama'] = 'uploads/products/' . $nama_file_baru;

                if ($old_image_path && file_exists(public_path($old_image_path))) {
                    unlink(public_path($old_image_path));
                }
            }

            // Eksekusi Update ke Tabel Produks
            $produk->update($data);

            // Update Spesifikasi (Delete & Insert ulang)
            if ($request->has('spesifikasi') && is_array($request->spesifikasi)) {
                $produk->spesifikasis()->delete();
                foreach ($request->spesifikasi as $spec) {
                    if (!empty($spec['nama_spesifikasi']) && !empty($spec['nilai'])) {
                        $produk->spesifikasis()->create([
                            'nama_spesifikasi' => $spec['nama_spesifikasi'],
                            'nilai' => $spec['nilai']
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('produk.show', $produk->produk_id)
                ->with('success', 'Produk diperbarui dan riwayat mutasi telah dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal Update Produk: ' . $e->getMessage());

            if ($nama_file_baru && file_exists(public_path('uploads/products/' . $nama_file_baru))) {
                unlink(public_path('uploads/products/' . $nama_file_baru));
            }

            return redirect()->back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
    
    public function destroy(Produk $produk)
    {
        try {
            DB::beginTransaction();

            if ($produk->gambar_utama && file_exists(public_path($produk->gambar_utama))) {
                unlink(public_path($produk->gambar_utama));
            }

            $produk->delete();
            DB::commit();

            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    public function publicIndex(Request $request)
    {
        // Load mutasiStok agar accessor total_stok bekerja dengan efisien (Eager Loading)
        $produks = Produk::with(['pabrikan', 'mutasiStok'])
            ->orderBy('nama_produk', 'asc')
            ->get();

        $activeCategory = strtolower($request->query('kategori') ?? 'semua');
        $searchQuery = $request->query('search') ?? '';

        $productsJson = $produks->map(function ($produk) {
            return [
                'id' => $produk->produk_id,
                'name' => $produk->nama_produk,
                'brand' => $produk->pabrikan ? $produk->pabrikan->nama_pabrikan : 'Unknown',
                'description' => $produk->deskripsi_singkat ?? 'No description available',
                'kategori' => strtolower($produk->kategori),
                'satuan' => $produk->satuan,
                // Kita tambahkan status stok untuk UI Alpine.js
                'stock' => $produk->total_stok,
                'image' => $produk->gambar_utama
                    ? asset($produk->gambar_utama)
                    : asset('images/default-product.png'),
            ];
        });

        return view('public.products', [
            'productsJson' => $productsJson,
            'activeCategory' => $activeCategory,
            'searchQuery' => $searchQuery,
        ]);
    }

    public function publicShow($produk_id)
    {
        $produk = Produk::with(['pabrikan', 'spesifikasis', 'mutasiStok'])
            ->findOrFail($produk_id);

        $relatedProducts = Produk::with('pabrikan')
            ->where('kategori', $produk->kategori)
            ->where('produk_id', '!=', $produk_id)
            ->limit(4)
            ->get();

        $spesifikasiHtml = '';
        if ($produk->spesifikasis && $produk->spesifikasis->count() > 0) {
            $spesifikasiHtml .= '<div class="space-y-3">';
            foreach ($produk->spesifikasis as $spec) {
                $spesifikasiHtml .= '<div class="flex border-b border-gray-200 pb-2">';
                $spesifikasiHtml .= '<span class="font-semibold text-gray-700 w-1/3">' . e($spec->nama_spesifikasi) . ':</span>';
                $spesifikasiHtml .= '<span class="text-gray-600 w-2/3">' . e($spec->nilai) . '</span>';
                $spesifikasiHtml .= '</div>';
            }
            $spesifikasiHtml .= '</div>';
        } else {
            $spesifikasiHtml = '<p class="text-gray-500">Spesifikasi tidak tersedia.</p>';
        }

        $produk->spesifikasi_formatted = $spesifikasiHtml;

        return view('public.product-detail', compact('produk', 'relatedProducts'));
    }
}
