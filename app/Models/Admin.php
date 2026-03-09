<?php

namespace App\Models;

// WAJIB: Import Authenticatable, bukan Model biasa
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    // Menentukan nama tabel secara manual (opsional tapi disarankan)
    protected $table = 'admins';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_telp',
    ];

    // Kolom yang harus disembunyikan (tidak muncul saat return JSON/Array)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting data (opsional)
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Penting di Laravel 10+ agar password otomatis di-hash
    ];

    public function mutasiStok()
    {
        return $this->morphMany(StokMutasi::class, 'role');
    }
}
