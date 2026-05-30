<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    // Tampilkan semua lapangan (halaman utama)
    public function index()
    {
        $fields = Field::withCount('reviews')
                       ->with('reviews')
                       ->get();
        return view('fields.index', compact('fields'));
    }

    // Tampilkan detail lapangan + cek jadwal
    public function show($id)
    {
        $field   = Field::with('reviews.user')->findOrFail($id);
        $reviews = Review::where('id_field', $id)
                         ->with('user')
                         ->latest()
                         ->get();

        // Ambil booking yang sudah ada untuk lapangan ini (7 hari ke depan)
        $bookings = Booking::where('id_field', $id)
                           ->where('tanggal_booking', '>=', now()->toDateString())
                           ->where('status', '!=', 'dibatalkan')
                           ->get(['tanggal_booking', 'jam_mulai', 'jam_selesai']);

        return view('fields.show', compact('field', 'reviews', 'bookings'));
    }

    // Simpan review lapangan
    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        Review::create([
            'id_user'  => auth()->user()->id_user,
            'id_field' => $id,
            'rating'   => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Review berhasil dikirim!');
    }
}
