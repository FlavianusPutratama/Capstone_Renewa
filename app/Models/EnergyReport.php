<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EnergyReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'power_plant_id',
        'reporting_period_start',
        'reporting_period_end',
        'amount_mwh',
        'supporting_document_path',
        'status',
        'rejection_reason',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reporting_period_start' => 'date',
        'reporting_period_end' => 'date',
    ];

    /**
     * Mendefinisikan relasi bahwa laporan ini "milik" satu PowerPlant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function powerPlant(): BelongsTo
    {
        return $this->belongsTo(PowerPlant::class);
    }

    /**
     * Mendefinisikan relasi bahwa laporan ini "memiliki satu" Sertifikat.
     */
    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }
}