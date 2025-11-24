<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'nama_produk',
        'deskripsi_singkat',
        'gambar_utama',
        'kategori',
        'pabrikan_id',
    ];

    protected $casts = [
        'kategori' => 'string',
    ];

    // Relationship: Produk belongs to Pabrikan
    public function pabrikan()
    {
        return $this->belongsTo(Pabrikan::class, 'pabrikan_id', 'pabrikan_id');
    }

    // Relationship: Produk has many Spesifikasi
    public function spesifikasis()
    {
        return $this->hasMany(Spesifikasi::class, 'produk_id', 'produk_id');
    }

    // Accessor untuk URL gambar
    public function getGambarUrlAttribute()
    {
        return $this->gambar_utama 
            ? asset('storage/' . $this->gambar_utama)
            : asset('images/default-product.png');
    }

    // Scope untuk filter kategori
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nama_produk', 'like', "%{$search}%")
              ->orWhere('deskripsi_singkat', 'like', "%{$search}%");
        });
    }
}