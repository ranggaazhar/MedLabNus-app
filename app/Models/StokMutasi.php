<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokMutasi extends Model
{
    use HasFactory;

    // 1. Definisikan Nama Tabel
    protected $table = 'stok_mutasi';

    // 2. Definisikan Primary Key Custom
    protected $primaryKey = 'stok_id';

    // 3. Masukkan kolom ke dalam fillable agar bisa disimpan (Mass Assignment)
    protected $fillable = [
        'produk_id',
        'jumlah',
        'tipe',
        'keterangan',
        'role_id',
        'role_type'
    ];

    /**
     * Relasi ke tabel Produk
     * Menghubungkan mutasi ini dengan produk yang terkait
     */
    public function produk(): BelongsTo
    {
        // Sesuaikan 'id_produk' jika itu nama PK di tabel produks Anda
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }

    /**
     * Relasi Polymorphic 'role'
     * Menghubungkan mutasi ini dengan aktor (Admin atau Gudang)
     */
    public function role(): MorphTo
    {
        return $this->morphTo();
    }
}