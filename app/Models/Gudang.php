<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gudang extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'gudangs';

    protected $fillable = [
        'name',
        'email',
        'password',
        'no_telp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function mutasiStok()
    {
        return $this->morphMany(StokMutasi::class, 'role');
    }
    
}
