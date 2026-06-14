<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Penawaran extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                $action = match ($eventName) {
                    'created' => 'dibuat oleh admin',
                    'updated' => 'diperbarui oleh admin',
                    'deleted' => 'dihapus oleh admin',
                    default   => $eventName,
                };

                return "Surat Penawaran dengan Kode {$this->kode_penawaran} telah {$action}";
            });
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = $activity->properties->put('ip', request()->ip());
        $activity->properties = $activity->properties->put('browser', request()->header('User-Agent'));
    }

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
