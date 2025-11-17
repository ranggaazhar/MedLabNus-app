<?php

namespace App\Http\Controllers;

use App\Models\Spesifikasi;
use App\Models\Produk;
use App\Http\Requests\StoreSpesifikasiRequest;
use App\Http\Requests\UpdateSpesifikasiRequest;
use Illuminate\Http\Request;

class SpesifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Spesifikasi::with('produk');

        if ($request->has('produk_id')) {
            $query->where('produk_id', $request->produk_id);
        }

        $spesifikasis = $query->latest()->paginate(10);
        $produks = Produk::all();

        return view('admin.spesifikasi.index', compact('spesifikasis', 'produks'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('admin.spesifikasi.create', compact('produks'));
    }

    public function store(StoreSpesifikasiRequest $request)
    {
        try {
            Spesifikasi::create($request->validated());

            return redirect()
                ->route('spesifikasi.index')
                ->with('success', 'Spesifikasi berhasil ditambahkan');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan spesifikasi: ' . $e->getMessage());
        }
    }

    public function show(Spesifikasi $spesifikasi)
    {
        $spesifikasi->load('produk');
        return view('admin.spesifikasi.show', compact('spesifikasi'));
    }

    public function edit(Spesifikasi $spesifikasi)
    {
        $produks = Produk::all();
        return view('admin.spesifikasi.edit', compact('spesifikasi', 'produks'));
    }

    public function update(UpdateSpesifikasiRequest $request, Spesifikasi $spesifikasi)
    {
        try {
            $spesifikasi->update($request->validated());

            return redirect()
                ->route('spesifikasi.index')
                ->with('success', 'Spesifikasi berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate spesifikasi: ' . $e->getMessage());
        }
    }

    public function destroy(Spesifikasi $spesifikasi)
    {
        try {
            $spesifikasi->delete();

            return redirect()
                ->route('spesifikasi.index')
                ->with('success', 'Spesifikasi berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus spesifikasi: ' . $e->getMessage());
        }
    }
}