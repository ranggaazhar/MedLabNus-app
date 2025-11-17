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
        $produkId = $this->route('produk'); // Ambil ID dari route parameter

        return [
            'nama_produk' => 'required|string|max:255',
            'model_produk' => [
                'required',
                'string',
                'max:100',
                Rule::unique('produks', 'model_produk')->ignore($produkId, 'produk_id')
            ],
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
            'pabrikan_id.required' => 'Pabrikan wajib dipilih',
        ];
    }
}