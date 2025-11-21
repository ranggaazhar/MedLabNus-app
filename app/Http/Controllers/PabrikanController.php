<?php

namespace App\Http\Controllers;

use App\Models\Pabrikan;
use App\Http\Requests\StorePabrikanRequest;
use App\Http\Requests\UpdatePabrikanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PabrikanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pabrikan::withCount('produks');

        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $pabrikans = $query->latest()->paginate(10);

        return view('admin.pabrikan.list-pabrik', compact('pabrikans'));
    }

    public function create()
    {
        return view('admin.pabrikan.create');
    }

    public function store(StorePabrikanRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('logo_pabrikan')) {
                $data['logo_pabrikan'] = $request->file('logo_pabrikan')
                    ->store('logos', 'public');
            }

            Pabrikan::create($data);

            return redirect()
                ->route('pabrikan.index')
                ->with('success', 'Pabrikan berhasil ditambahkan');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan pabrikan: ' . $e->getMessage());
        }
    }

    public function show(Pabrikan $pabrikan)
    {
        $pabrikan->load('produks');
        return view('admin.pabrikan.show', compact('pabrikan'));
    }

    // public function edit(Pabrikan $pabrikan)
    // {
    //     return view('admin.pabrikan.edit', compact('pabrikan'));
    // }

    public function update(UpdatePabrikanRequest $request, Pabrikan $pabrikan)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('logo_pabrikan')) {
                if ($pabrikan->logo_pabrikan) {
                    Storage::disk('public')->delete($pabrikan->logo_pabrikan);
                }
                
                $data['logo_pabrikan'] = $request->file('logo_pabrikan')
                    ->store('logos', 'public');
            }

            $pabrikan->update($data);

            return redirect()
                ->route('pabrikan.index')
                ->with('success', 'Pabrikan berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate pabrikan: ' . $e->getMessage());
        }
    }

    public function destroy(Pabrikan $pabrikan)
    {
        try {
            if ($pabrikan->produks()->count() > 0) {
                return redirect()
                    ->back()
                    ->with('error', 'Tidak dapat menghapus pabrikan yang memiliki produk');
            }

            if ($pabrikan->logo_pabrikan) {
                Storage::disk('public')->delete($pabrikan->logo_pabrikan);
            }

            $pabrikan->delete();

            return redirect()
                ->route('pabrikan.index')
                ->with('success', 'Pabrikan berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus pabrikan: ' . $e->getMessage());
        }
    }
}