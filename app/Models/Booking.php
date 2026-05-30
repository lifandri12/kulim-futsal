<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'id_booking';

    protected $fillable = [
        'id_user', 'id_field', 'tanggal_booking',
        'jam_mulai', 'jam_selesai', 'status', 'total_harga',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke lapangan
    public function field()
    {
        return $this->belongsTo(Field::class, 'id_field', 'id_field');
    }

    // Relasi ke pembayaran
    public function payment()
    {
        return $this->hasOne(Payment::class, 'id_booking', 'id_booking');
    }

    // Hitung total harga otomatis
    public function hitungTotalHarga()
    {
        $jamMulai   = strtotime($this->jam_mulai);
        $jamSelesai = strtotime($this->jam_selesai);
        $durasi     = ($jamSelesai - $jamMulai) / 3600; // dalam jam
        return $durasi * $this->field->harga_per_jam;
    }
}
