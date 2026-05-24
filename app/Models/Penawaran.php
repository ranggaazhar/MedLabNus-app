<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    // Mengarahkan ke nama tabel yang benar jika kamu menggunakan jamak 'penawarans'
    protected $table = 'penawarans';

    protected $fillable = [
        'user_id',
        'nama_pelanggan',
        'whatsapp_pelanggan',
        'kode_penawaran',
        'file_pdf',
        'status', // 'pending', 'disetujui', 'dibatalkan'
    ];

    /**
     * Relasi ke item-item penawaran (One to Many)
     * Satu penawaran memiliki banyak produk yang diminta
     */
    public function items()
    {
        return $this->hasMany(\App\Models\PenawaranItem::class, 'penawaran_id');
    }

    /**
     * Relasi balik ke User/Pelanggan yang login
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function invoice()
    {
        return $this->hasOne(\App\Models\Invoice::class, 'penawaran_id');
    }
}
