<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Invoice extends Model
{
    use HasFactory, LogsActivity;

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

                $totalHargaVal = $this->invoiceItems()->sum('total_item_harga') ?: ($this->total_harga ?? 0);
                $totalHarga = number_format($totalHargaVal, 0, ',', '.');

                return "Invoice dengan Kode {$this->kode_invoice} dengan Total Harga Rp {$totalHarga} telah {$action}";
            });
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = $activity->properties->put('ip', request()->ip());
        $activity->properties = $activity->properties->put('browser', request()->header('User-Agent'));
    }

    // Tentukan kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'kode_invoice',
        'penawaran_id',
        'nama_pelanggan',
        'whatsapp_pelanggan',
        'subtotal',
        'pajak_ppn',
        'total_harga',
        'status_pembayaran',
        'created_by',
    ];

    /**
     * Relasi ke Invoice Items (Satu invoice memiliki banyak item produk)
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    /**
     * Relasi ke Penawaran (Invoice mungkin merujuk ke sebuah penawaran)
     */
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'penawaran_id', 'id');
    }

    /**
     * Relasi ke User/Admin yang menerbitkan invoice (Untuk Audit Trail)
     */
    public function adminCreator()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }
}