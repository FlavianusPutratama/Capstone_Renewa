<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Certificate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'energy_report_id',
        'issuer_id',
        'owner_id',
        'certificate_uid',
        'amount_mwh',
        'generation_start_date',
        'generation_end_date',
        'status',
        'order_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'generation_start_date' => 'date',
        'generation_end_date' => 'date',
    ];

    /**
     * Relasi ke laporan energi.
     */
    public function energyReport(): BelongsTo
    {
        return $this->belongsTo(EnergyReport::class);
    }

    /**
     * Relasi ke user yang menerbitkan.
     */
    public function issuer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issuer_id');
    }

    /**
     * Relasi ke user yang memiliki.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Mendefinisikan relasi bahwa sertifikat ini "memiliki satu" pesanan.
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
