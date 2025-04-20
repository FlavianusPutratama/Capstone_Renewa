<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'nik', // NIK field
        'address', // Address field
        'province', // Store province name
        'regency', // Store regency name
        'district', // Store district name
        'village', // Village field
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    public function isIssuer()
    {
        return $this->role === 'issuer';
    }
}