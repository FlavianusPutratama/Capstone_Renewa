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
        // 'certificate_id', // <-- HAPUS BARIS INI
        'total_price',
        'virtual_account_number',
        'status',
    ];

    /**
     * Relasi ke user (pembeli).
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Relasi ke sertifikat-sertifikat yang dimiliki order ini.
     * (Satu order bisa punya BANYAK sertifikat)
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}