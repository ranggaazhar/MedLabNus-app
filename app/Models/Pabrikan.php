<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Pabrikan extends Model
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
