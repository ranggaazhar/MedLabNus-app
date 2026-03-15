<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;


class Produk extends Model
{
    use LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                $action = match ($eventName) {
                    'created' => 'ditambahkan',
                    'updated' => 'diperbarui',
                    'deleted' => 'dihapus',
                    default   => $eventName,
                };

                return "Data produk telah {$action}";
            });
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = $activity->properties->put('ip', request()->ip());
        $activity->properties = $activity->properties->put('browser', request()->header('User-Agent'));
    }

    use HasFactory;

    protected $table = 'produks';
    protected $primaryKey = 'produk_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_produk',
        'deskripsi_singkat',
        'gambar_utama',
        'kategori',
        'pabrikan_id',
        'satuan',
        'harga_acuan',
        'stok_minimal'
    ];

    // Override route key name untuk Laravel routing
    public function getRouteKeyName()
    {
        return 'produk_id';
    }

    // Relationships
    public function pabrikan()
    {
        return $this->belongsTo(Pabrikan::class, 'pabrikan_id', 'pabrikan_id');
    }

    public function spesifikasis()
    {
        return $this->hasMany(Spesifikasi::class, 'produk_id', 'produk_id');
    }

    // Scopes
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama_produk', 'like', "%{$search}%")
                ->orWhere('deskripsi_singkat', 'like', "%{$search}%")
                ->orWhereHas('pabrikan', function ($q2) use ($search) {
                    $q2->where('nama_pabrikan', 'like', "%{$search}%");
                });
        });
    }

    public function mutasiStok(): HasMany
    {
        // 'produk_id' adalah FK di tabel stok_mutasi
        // 'id_produk' adalah PK di tabel produks
        return $this->hasMany(StokMutasi::class, 'produk_id', 'produk_id');
    }

    /**
     * Method untuk mendapatkan total stok saat ini
     * Sangat berguna untuk ditampilkan di Landing Page/Shop
     */
    public function getCurrentStockAttribute(): int
    {
        // Menjumlahkan kolom 'jumlah' (positif dan negatif) dari semua mutasi
        return $this->mutasiStok()->sum('jumlah');
    }
}
