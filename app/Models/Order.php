<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Atribut yang boleh diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'order_uid',
        'buyer_id',
        'total_price',
        'virtual_account_number',
        'status',
    ];

    /**
     * Memberitahu Laravel untuk selalu memperlakukan kolom-kolom ini
     * sebagai objek tanggal (Carbon), yang mencegah error format().
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'payment_confirmed_at' => 'datetime',
    ];

    /**
     * Mendefinisikan relasi bahwa pesanan ini dimiliki oleh satu User (pembeli).
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Mendefinisikan relasi bahwa satu pesanan dapat memiliki banyak sertifikat.
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}