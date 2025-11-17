<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spesifikasi extends Model
{
    use HasFactory;

    protected $table = 'spesifikasis';
    protected $primaryKey = 'spesifikasi_id';

    protected $fillable = [
        'produk_id',
        'nama_spesifikasi',
        'nilai',
    ];

    // Relationship: Spesifikasi belongs to Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }
}