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
            'nama_produk' => 'required|string|unique:produks,nama_produk|max:255',
            'deskripsi_singkat' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori' => 'required|in:reagen,alat',
            'pabrikan_id' => 'required|exists:pabrikans,pabrikan_id',
            'spesifikasi' => 'nullable|array',
            'spesifikasi.*.nama_spesifikasi' => 'required_with:spesifikasi|string|max:100',
            'spesifikasi.*.nilai' => 'required_with:spesifikasi|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.unique' => 'Nama produk sudah terdaftar, gunakan nama lain.',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter.',
            
            'kategori.required' => 'Kategori produk wajib dipilih.',
            'kategori.in' => 'Kategori harus berupa Reagen atau Alat.',
            
            'pabrikan_id.required' => 'Pabrikan wajib dipilih.',
            'pabrikan_id.exists' => 'Pabrikan yang dipilih tidak valid.',
            
            'gambar_utama.image' => 'File harus berupa gambar.',
            'gambar_utama.mimes' => 'Gambar harus berformat: jpeg, png, jpg, gif.',
            'gambar_utama.max' => 'Ukuran gambar maksimal 2MB.',
            
            'spesifikasi.*.nama_spesifikasi.required_with' => 'Nama spesifikasi wajib diisi jika ada spesifikasi.',
            'spesifikasi.*.nilai.required_with' => 'Nilai spesifikasi wajib diisi jika ada spesifikasi.',
        ];
    }
}