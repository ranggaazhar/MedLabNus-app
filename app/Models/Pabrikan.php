<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pabrikan extends Model
{
    use HasFactory;

    protected $table = 'pabrikans';
    protected $primaryKey = 'pabrikan_id';

    protected $fillable = [
        'nama_pabrikan',
        'logo_pabrikan',
        'asal_negara',
    ];

    // Relationship: Pabrikan has many Produk
    public function produks()
    {
        return $this->hasMany(Produk::class, 'pabrikan_id', 'pabrikan_id');
    }

    // Accessor untuk URL logo
    public function getLogoUrlAttribute()
    {
        return $this->logo_pabrikan 
            ? asset('storage/' . $this->logo_pabrikan)
            : asset('images/default-logo.png');
    }
}
