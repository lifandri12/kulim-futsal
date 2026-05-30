<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama', 'email', 'password', 'no_hp', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relasi: satu user bisa punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_user', 'id_user');
    }

    // Relasi: satu user bisa punya banyak review
    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_user', 'id_user');
    }

    // Cek apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
