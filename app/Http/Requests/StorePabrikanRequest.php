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
        // Pastikan aturan validasi Anda sesuai dengan database baru (tanpa alamat)
        return [
            'nama_pabrikan' => ['required', 'string', 'max:255', 'unique:pabrikans,nama_pabrikan'],
            'asal_negara' => ['required', 'string', 'max:100'],
            'logo_pabrikan' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
