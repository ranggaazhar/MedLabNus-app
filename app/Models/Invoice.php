<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Tentukan kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'kode_invoice',
        'penawaran_id',
        'nama_pelanggan',
        'whatsapp_pelanggan',
        'subtotal',
        'pajak_ppn',
        'total_harga',
        'status_pembayaran',
        'created_by',
    ];

    /**
     * Relasi ke Invoice Items (Satu invoice memiliki banyak item produk)
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    /**
     * Relasi ke Penawaran (Invoice mungkin merujuk ke sebuah penawaran)
     */
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'penawaran_id', 'id');
    }

    /**
     * Relasi ke User/Admin yang menerbitkan invoice (Untuk Audit Trail)
     */
    public function adminCreator()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }
}