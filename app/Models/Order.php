<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_uid',
        'buyer_id',
        // 'certificate_id', // Dihapus dari sini
        'total_price',
        'virtual_account_number',
        'status',
        'payment_confirmed_at',
        'order_completed_at',
    ];

    protected $casts = [
        'payment_confirmed_at' => 'datetime',
        'order_completed_at' => 'datetime',
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Mendefinisikan relasi bahwa satu pesanan bisa memiliki banyak sertifikat.
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
