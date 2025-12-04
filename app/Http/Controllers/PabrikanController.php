<?php

namespace App\Http\Controllers;

use App\Models\Pabrikan;
use App\Http\Requests\StorePabrikanRequest;
use App\Http\Requests\UpdatePabrikanRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PabrikanController extends Controller
{
    public function checkNamaPabrikan(Request $request)
    {
        $nama = $request->input('nama_pabrikan');
        $pabrikanId = $request->input('pabrikan_id'); // untuk update

        $query = Pabrikan::where('nama_pabrikan', $nama);
        
        // Jika update, exclude pabrikan yang sedang diedit
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
            // Memulai transaksi database
            DB::beginTransaction();

            $data = $request->validated();
            $gambar_utama = null; // Variabel untuk menyimpan path gambar sementara

            // Proses upload logo_pabrikan
            if ($request->hasFile('logo_pabrikan')) {
                $gambar_utama = $request->file('logo_pabrikan')
                    ->store('pabrikan_logos', 'public'); // Ganti 'products' dengan 'pabrikan_logos'
                $data['logo_pabrikan'] = $gambar_utama;
            }

            // Membuat record Pabrikan
            $pabrikan = Pabrikan::create($data);

            // Karena Pabrikan tidak memiliki spesifikasi seperti Produk, 
            // logika spesifikasi dihilangkan.

            // Menyelesaikan transaksi
            DB::commit();

            return redirect()
                ->route('pabrikan.index') // Sesuaikan dengan nama route Anda
                ->with('success', 'Pabrikan berhasil ditambahkan');

        } catch (\Exception $e) {
            // Membatalkan transaksi jika terjadi error
            DB::rollBack();

            // Hapus file yang sudah terupload jika ada error setelah upload
            if (isset($gambar_utama)) {
                Storage::disk('public')->delete($gambar_utama);
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
            // Memulai transaksi database
            DB::beginTransaction();

            $data = $request->validated();
            $old_logo_path = $pabrikan->logo_pabrikan; // Simpan path logo lama
            $new_logo_path = null; // Path logo baru jika diupload

            // Proses upload logo_pabrikan
            if ($request->hasFile('logo_pabrikan')) {
                // Upload logo baru
                $new_logo_path = $request->file('logo_pabrikan')
                    ->store('pabrikan_logos', 'public');
                $data['logo_pabrikan'] = $new_logo_path;
            }

            // Update record Pabrikan
            $pabrikan->update($data);
            
            // Logika spesifikasi dihilangkan karena tidak relevan untuk Pabrikan

            // Hapus logo lama jika logo baru berhasil diupload
            if ($new_logo_path && $old_logo_path && Storage::disk('public')->exists($old_logo_path)) {
                Storage::disk('public')->delete($old_logo_path);
            }

            // Menyelesaikan transaksi
            DB::commit();

            return redirect()
                ->route('pabrikan.show', $pabrikan->pabrikan_id) // Sesuaikan dengan nama route Anda
                ->with('success', 'Pabrikan berhasil diupdate');

        } catch (\Exception $e) {
            // Membatalkan transaksi jika terjadi error
            DB::rollBack();

            // Hapus logo baru jika proses update gagal
            if (isset($new_logo_path) && Storage::disk('public')->exists($new_logo_path)) {
                Storage::disk('public')->delete($new_logo_path);
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