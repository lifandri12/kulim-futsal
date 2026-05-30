<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'id_payment';

    protected $fillable = [
        'id_booking', 'metode_pembayaran',
        'status_pembayaran', 'tanggal_pembayaran', 'bukti_pembayaran',
    ];

    // Relasi ke booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }
}
