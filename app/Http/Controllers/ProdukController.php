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
    

    public function create()
    {
        $pabrikans = Pabrikan::orderBy('nama_pabrikan')->get();
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

            if ($request->has('spesifikasi') && is_array($request->spesifikasi)) {
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
            
            return redirect()
                ->route('produk.index')
                ->with('success', 'Produk berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (isset($data['gambar_utama'])) {
                Storage::disk('public')->delete($data['gambar_utama']);
            }
            
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
        $pabrikans = Pabrikan::orderBy('nama_pabrikan')->get();
        return view('admin.produk.edit', compact('produk', 'pabrikans'));
    }

    public function update(UpdateProdukRequest $request, Produk $produk)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            if ($request->hasFile('gambar_utama')) {
                if ($produk->gambar_utama && Storage::disk('public')->exists($produk->gambar_utama)) {
                    Storage::disk('public')->delete($produk->gambar_utama);
                }
                
                $data['gambar_utama'] = $request->file('gambar_utama')
                    ->store('products', 'public');
            }
            $produk->update($data);

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

            return redirect()
                ->route('produk.show', $produk->produk_id)
                ->with('success', 'Produk berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($data['gambar_utama']) && $data['gambar_utama'] != $produk->gambar_utama) {
                Storage::disk('public')->delete($data['gambar_utama']);
            }
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate produk: ' . $e->getMessage());
        }
    }

    public function destroy(Produk $produk)
    {
        try {
            DB::beginTransaction();

            if ($produk->gambar_utama && Storage::disk('public')->exists($produk->gambar_utama)) {
                Storage::disk('public')->delete($produk->gambar_utama);
            }

            $produk->delete();

            DB::commit();

            return redirect()
                ->route('produk.index')
                ->with('success', 'Produk berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}