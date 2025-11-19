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

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with(['pabrikan', 'spesifikasis']);

        if ($request->has('kategori') && $request->kategori != 'semua') {
            $query->kategori($request->kategori);
        }

        // Pencarian
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $produks = $query->latest()->paginate(10);

        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        $pabrikans = Pabrikan::all();
        return view('admin.produk.create', compact('pabrikans'));
    }

    public function store(StoreProdukRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            if ($request->hasFile('gambar_utama')) {
                $data['gambar_utama'] = $request->file('gambar_utama')
                    ->store('products', 'public');
            }

            $produk = Produk::create($data);

            if ($request->has('spesifikasi')) {
                foreach ($request->spesifikasi as $spec) {
                    $produk->spesifikasis()->create($spec);
                }
            }
            DB::commit();
            return redirect()
                ->route('produk.index')
                ->with('success', 'Produk berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }
    public function show(Produk $produk)
    {
        $produk->load(['pabrikan', 'spesifikasis']);
        return view('admin.produk.show', compact('produk'));
    }
    public function edit(Produk $produk)
    {
        $produk->load('spesifikasis');
        $pabrikans = Pabrikan::all();
        return view('admin.produk.edit', compact('produk', 'pabrikans'));
    }

    public function update(UpdateProdukRequest $request, Produk $produk)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            if ($request->hasFile('gambar_utama')) {
                if ($produk->gambar_utama) {
                    Storage::disk('public')->delete($produk->gambar_utama);
                }
                
                $data['gambar_utama'] = $request->file('gambar_utama')
                    ->store('products', 'public');
            }

            $produk->update($data);

            if ($request->has('spesifikasi')) {
                $produk->spesifikasis()->delete();

                foreach ($request->spesifikasi as $spec) {
                    $produk->spesifikasis()->create($spec);
                }
            }

            DB::commit();

            return redirect()
                ->route('produk.index')
                ->with('success', 'Produk berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate produk: ' . $e->getMessage());
        }
    }

    public function destroy(Produk $produk)
    {
        try {
            // Hapus gambar jika ada
            if ($produk->gambar_utama) {
                Storage::disk('public')->delete($produk->gambar_utama);
            }

            // Hapus produk (spesifikasi akan terhapus otomatis karena cascade)
            $produk->delete();

            return redirect()
                ->route('produk.index')
                ->with('success', 'Produk berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}