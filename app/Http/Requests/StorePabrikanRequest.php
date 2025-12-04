<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePabrikanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Aturan validasi untuk data pabrikan
        return [
            'nama_pabrikan' => 'required|string|max:255|unique:pabrikans,nama_pabrikan',
            'asal_negara' => 'required|string|max:100',
            // Gunakan format string untuk aturan validasi, seperti di StoreProdukRequest
            'logo_pabrikan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Pesan kustom untuk nama_pabrikan
            'nama_pabrikan.required' => 'Nama pabrikan wajib diisi.',
            'nama_pabrikan.string' => 'Nama pabrikan harus berupa teks.',
            'nama_pabrikan.max' => 'Nama pabrikan maksimal 255 karakter.',
            'nama_pabrikan.unique' => 'Nama pabrikan sudah terdaftar, gunakan nama lain.',
            
            // Pesan kustom untuk asal_negara
            'asal_negara.required' => 'Asal negara pabrikan wajib diisi.',
            'asal_negara.string' => 'Asal negara harus berupa teks.',
            'asal_negara.max' => 'Asal negara maksimal 100 karakter.',

            // Pesan kustom untuk logo_pabrikan
            'logo_pabrikan.image' => 'File logo harus berupa gambar.',
            'logo_pabrikan.mimes' => 'Logo harus berformat: jpeg, png, jpg, gif, atau svg.',
            'logo_pabrikan.max' => 'Ukuran logo maksimal 2MB.',
        ];
    }
}