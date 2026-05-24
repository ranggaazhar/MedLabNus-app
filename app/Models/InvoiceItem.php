<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'total_item_harga',
    ];

    /**
     * Relasi balik ke Induk Invoice
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    /**
     * Relasi ke Produk Alat Kesehatan
     * 🛠️ FIX: Menggunakan 'produk_id' sebagai local key/foreign key target karena custom primary key
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }
}