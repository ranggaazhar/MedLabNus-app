<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Biasanya Admin yang mengakses, bisa dikontrol via middleware
    }

    public function rules(): array
    {
        return [
            'penawaran_id'         => 'required|integer|exists:penawarans,id',
            'nama_pelanggan'       => 'required|string|max:255',
            'whatsapp_pelanggan'   => 'required|string|max:20',
            'status_pembayaran'    => 'required|in:pending,lunas,batal',
            'items'                => 'required|array|min:1',
            'items.*.nama'         => 'required|string|max:255',
            'items.*.jumlah'       => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'penawaran_id.required'       => 'ID Penawaran wajib ada.',
            'penawaran_id.exists'         => 'Penawaran tidak ditemukan di sistem.',
            'nama_pelanggan.required'     => 'Nama Pelanggan wajib diisi.',
            'whatsapp_pelanggan.required' => 'Nomor WhatsApp Pelanggan wajib diisi.',
            'status_pembayaran.required'  => 'Status Pembayaran wajib dipilih.',
            'items.required'              => 'Invoice harus memiliki minimal 1 item.',
            'items.min'                   => 'Invoice harus memiliki minimal 1 item.',
            'items.*.nama.required'       => 'Nama item wajib diisi.',
            'items.*.jumlah.required'     => 'Jumlah item wajib diisi.',
            'items.*.jumlah.min'          => 'Jumlah item minimal 1.',
            'items.*.harga_satuan.required' => 'Harga satuan wajib diisi.',
            'items.*.harga_satuan.min'    => 'Harga satuan tidak boleh negatif.',
        ];
    }
}
