<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'power_plant_id',
        'reporting_period_start',
        'reporting_period_end',
        'amount_mwh',
        'proof_documentation_url',
        'status',
        'rejection_reason',
    ];

    /**
     * KUNCI PERBAIKAN:
     * Menambahkan created_at dan updated_at ke dalam casts yang sudah ada.
     *
     * @var array
     */
    protected $casts = [
        'reporting_period_start' => 'date',
        'reporting_period_end' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function powerPlant()
    {
        return $this->belongsTo(PowerPlant::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}