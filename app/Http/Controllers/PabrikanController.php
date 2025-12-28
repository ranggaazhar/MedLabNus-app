<?php

namespace App\Http\Controllers;

use App\Models\Pabrikan;
use App\Http\Requests\StorePabrikanRequest;
use App\Http\Requests\UpdatePabrikanRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// Storage tidak lagi digunakan untuk upload, tapi bisa disimpan untuk referensi atau dihapus

class PabrikanController extends Controller
{
    public function checkNamaPabrikan(Request $request)
    {
        $nama = $request->input('nama_pabrikan');
        $pabrikanId = $request->input('pabrikan_id'); 

        $query = Pabrikan::where('nama_pabrikan', $nama);
        
        if ($pabrikanId) {
            $query->where('pabrikan_id', '!=', $pabrikanId);
        }
        
        $exists = $query->exists();
        
        return response()->json(['exists' => $exists]);
    }

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
            DB::beginTransaction();

            $data = $request->validated();
            $nama_file_baru = null; 

            if ($request->hasFile('logo_pabrikan')) {
                $file = $request->file('logo_pabrikan');
                // Membuat nama file unik
                $nama_file_baru = time() . '_' . $file->getClientOriginalName();
                
                // Pindahkan file ke public/uploads/pabrikan_logos
                $file->move(public_path('uploads/pabrikan_logos'), $nama_file_baru);
                
                // Simpan path relatif ke database agar mudah dipanggil asset()
                $data['logo_pabrikan'] = 'uploads/pabrikan_logos/' . $nama_file_baru;
            }

            $pabrikan = Pabrikan::create($data);

            DB::commit();

            return redirect()
                ->route('pabrikan.index')
                ->with('success', 'Pabrikan berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();

            // Jika error, hapus file yang sudah terlanjur pindah ke folder uploads
            if ($nama_file_baru && file_exists(public_path('uploads/pabrikan_logos/' . $nama_file_baru))) {
                unlink(public_path('uploads/pabrikan_logos/' . $nama_file_baru));
            }

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

    public function edit(Pabrikan $pabrikan)
    {
        return view('admin.pabrikan.edit', compact('pabrikan'));
    }

    public function update(UpdatePabrikanRequest $request, Pabrikan $pabrikan)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $old_logo_path = $pabrikan->logo_pabrikan; 
            $nama_file_baru = null;

            if ($request->hasFile('logo_pabrikan')) {
                $file = $request->file('logo_pabrikan');
                $nama_file_baru = time() . '_' . $file->getClientOriginalName();
                
                // Upload file baru ke folder uploads
                $file->move(public_path('uploads/pabrikan_logos'), $nama_file_baru);
                $data['logo_pabrikan'] = 'uploads/pabrikan_logos/' . $nama_file_baru;

                // Hapus logo lama dari folder public jika ada
                if ($old_logo_path && file_exists(public_path($old_logo_path))) {
                    unlink(public_path($old_logo_path));
                }
            }

            $pabrikan->update($data);

            DB::commit();

            return redirect()
                ->route('pabrikan.index', $pabrikan->pabrikan_id)
                ->with('success', 'Pabrikan berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus logo baru jika proses DB gagal
            if ($nama_file_baru && file_exists(public_path('uploads/pabrikan_logos/' . $nama_file_baru))) {
                unlink(public_path('uploads/pabrikan_logos/' . $nama_file_baru));
            }

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

            // Hapus file fisik dari folder uploads
            if ($pabrikan->logo_pabrikan && file_exists(public_path($pabrikan->logo_pabrikan))) {
                unlink(public_path($pabrikan->logo_pabrikan));
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