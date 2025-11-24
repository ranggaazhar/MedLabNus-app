<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpesifikasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'produk_id' => 'required|exists:produks,produk_id',
            'nama_spesifikasi' => 'required|string|max:100',
            'nilai' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'produk_id.required' => 'Produk wajib dipilih',
            'produk_id.exists' => 'Produk tidak ditemukan',
            'nama_spesifikasi.required' => 'Nama spesifikasi wajib diisi',
            'nilai.required' => 'Nilai spesifikasi wajib diisi',
        ];
    }
}