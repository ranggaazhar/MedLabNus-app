<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'nama_produk' => 'required|string|max:255',
            'model_produk' => 'required|string|max:100|unique:produks,model_produk',
            'deskripsi_singkat' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori' => 'required|in:reagen,alat',
            'pabrikan_id' => 'required|exists:pabrikans,pabrikan_id',
            'spesifikasi' => 'nullable|array',
            'spesifikasi.*.nama_spesifikasi' => 'required|string|max:100',
            'spesifikasi.*.nilai' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'model_produk.required' => 'Model produk wajib diisi',
            'model_produk.unique' => 'Model produk sudah digunakan',
            'kategori.required' => 'Kategori wajib dipilih',
            'kategori.in' => 'Kategori harus reagen atau alat',
            'pabrikan_id.required' => 'Pabrikan wajib dipilih',
            'pabrikan_id.exists' => 'Pabrikan tidak ditemukan',
            'gambar_utama.image' => 'File harus berupa gambar',
            'gambar_utama.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
