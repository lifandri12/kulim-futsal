<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $primaryKey = 'id_field';

    protected $fillable = [
        'nama_lapangan', 'lokasi', 'harga_per_jam', 'status', 'deskripsi', 'foto',
    ];

    // Relasi: satu lapangan bisa punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_field', 'id_field');
    }

    // Relasi: satu lapangan bisa punya banyak review
    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_field', 'id_field');
    }

    // Hitung rata-rata rating
    public function getRatingRataRataAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
