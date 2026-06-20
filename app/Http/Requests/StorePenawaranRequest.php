<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenawaranRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_pelanggan' => 'required|string',
            'whatsapp_pelanggan' => 'required|string|max:13',
            'items' => 'required|array',
            'items.*.produk_id' => 'required_without:items.*.id_produk',
            'items.*.id_produk' => 'required_without:items.*.produk_id',
            'items.*.jumlah' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'whatsapp_pelanggan.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp_pelanggan.max' => 'Nomor WhatsApp maksimal 13 digit.',
            'items.required' => 'Minimal harus ada 1 produk yang dipilih.',
            'items.array' => 'Format item tidak valid.',
            'items.*.jumlah.min' => 'Jumlah barang minimal 1.',
        ];
    }
}
