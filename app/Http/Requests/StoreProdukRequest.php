<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Kode Produk ditambahkan sebagai identitas unik alkes
            'kode_produk' => 'nullable|string|unique:produks,kode_produk|max:50',
            'nama_produk' => 'required|string|unique:produks,nama_produk|max:255',
            'deskripsi_singkat' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori' => 'required|in:reagen,alat,steril,non steril,invitro',
            'pabrikan_id' => 'required|exists:pabrikans,pabrikan_id',
            
            // --- KOLOM BARU ---
            'satuan' => 'required|string|max:50', // Contoh: PCS, BOX, Unit
            'harga_acuan' => 'nullable|numeric|min:0', // Untuk patokan penawaran Admin
            'stok_minimal' => 'nullable|integer|min:0', // Warning stok tipis
            'stok_awal' => 'nullable|integer|min:0', // Untuk input stok pertama kali
            
            'spesifikasi' => 'nullable|array',
            'spesifikasi.*.nama_spesifikasi' => 'required_with:spesifikasi|string|max:100',
            'spesifikasi.*.nilai' => 'required_with:spesifikasi|string',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_produk.unique' => 'Kode produk sudah digunakan.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.unique' => 'Nama produk sudah terdaftar.',
            
            'kategori.required' => 'Kategori produk wajib dipilih.',
            'kategori.in' => 'Kategori tidak valid. Pilih: Reagen, Alat, Steril, Non Steril, atau Invitro.',
            
            'pabrikan_id.required' => 'Pabrikan wajib dipilih.',
            'pabrikan_id.exists' => 'Pabrikan tidak valid.',
            
            'satuan.required' => 'Satuan produk (Pcs/Box/Unit) wajib diisi.',
            'harga_acuan.numeric' => 'Harga acuan harus berupa angka.',
            'stok_awal.integer' => 'Stok awal harus berupa angka bulat.',
            
            'gambar_utama.image' => 'File harus berupa gambar.',
            'gambar_utama.max' => 'Ukuran gambar maksimal 2MB.',
            
            'spesifikasi.*.nama_spesifikasi.required_with' => 'Nama spesifikasi wajib diisi.',
            'spesifikasi.*.nilai.required_with' => 'Nilai spesifikasi wajib diisi.',
        ];
    }
}