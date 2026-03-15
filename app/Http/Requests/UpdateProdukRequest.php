<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Mendapatkan ID produk dari route
        $produkId = $this->route('produk')->produk_id; 

        return [
            'kode_produk' => [
                'nullable',
                'string',
                'max:50',
                // Pastikan kode produk juga unik tapi mengabaikan diri sendiri
                Rule::unique('produks', 'kode_produk')->ignore($produkId, 'produk_id')
            ],
            'nama_produk' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produks', 'nama_produk')->ignore($produkId, 'produk_id') 
            ],
            'deskripsi_singkat' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori' => 'required|in:reagen,alat,steril,non steril,invitro',
            'pabrikan_id' => 'required|exists:pabrikans,pabrikan_id',

            // --- KOLOM BARU ---
            'satuan' => 'required|string|max:50',
            'harga_acuan' => 'nullable|numeric|min:0',
            'stok_minimal' => 'nullable|integer|min:0',
            
            'spesifikasi' => 'nullable|array',
            'spesifikasi.*.nama_spesifikasi' => 'required_with:spesifikasi|string|max:100',
            'spesifikasi.*.nilai' => 'required_with:spesifikasi|string',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_produk.unique' => 'Kode produk sudah digunakan oleh produk lain.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.unique' => 'Nama produk sudah terdaftar, gunakan nama lain.',
            
            'kategori.required' => 'Kategori produk wajib dipilih.',
            'kategori.in' => 'Kategori yang dipilih tidak valid. Pilihan: Reagen, Alat, Steril, Non Steril, atau Invitro.',
            
            'satuan.required' => 'Satuan (Box/Pcs/Unit) wajib diisi.',
            'harga_acuan.numeric' => 'Harga acuan harus berupa angka.',
            
            'pabrikan_id.required' => 'Pabrikan wajib dipilih.',
            'pabrikan_id.exists' => 'Pabrikan yang dipilih tidak valid.',
            
            'gambar_utama.image' => 'File harus berupa gambar.',
            'gambar_utama.max' => 'Ukuran gambar maksimal 2MB.',
            
            'spesifikasi.*.nama_spesifikasi.required_with' => 'Nama spesifikasi wajib diisi.',
            'spesifikasi.*.nilai.required_with' => 'Nilai spesifikasi wajib diisi.',
        ];
    }
}