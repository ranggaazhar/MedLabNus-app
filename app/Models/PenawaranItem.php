<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenawaranItem extends Model
{
    // Deklarasikan nama tabel secara eksplisit agar tidak otomatis menjadi penawaran_item_s
    protected $table = 'penawaran_items';

    protected $fillable = [
        'penawaran_id',
        'produk_id',
        'jumlah',
    ];

    /**
     * Relasi ke model Produk untuk mengambil data nama produk, gambar, dll.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id'); 
        // 🌟 Sesuaikan parameter kedua & ketiga dengan primary key tabel produkmu
    }

    /**
     * Relasi balik ke data Penawaran induknya
     */
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'penawaran_id');
    }
}