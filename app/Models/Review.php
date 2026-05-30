<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $primaryKey = 'id_review';

    protected $fillable = [
        'id_user', 'id_field', 'rating', 'komentar',
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
}
