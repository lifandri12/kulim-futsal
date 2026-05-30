<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Tampilkan form booking
    public function create($id_field)
    {
        $field = Field::findOrFail($id_field);
        return view('bookings.create', compact('field'));
    }

    // Simpan booking baru
    public function store(Request $request)
    {
        $request->validate([
            'id_field'        => 'required|exists:fields,id_field',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai'       => 'required',
            'jam_selesai'     => 'required|after:jam_mulai',
        ]);

        $field = Field::findOrFail($request->id_field);

        // Cek apakah jadwal sudah dibooking orang lain
        $cekBentrok = Booking::where('id_field', $request->id_field)
            ->where('tanggal_booking', $request->tanggal_booking)
            ->where('status', '!=', 'dibatalkan')
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })->exists();

        if ($cekBentrok) {
            return back()->with('error', 'Jadwal tersebut sudah dibooking. Pilih waktu lain.');
        }

        // Hitung total harga
        $jamMulai   = strtotime($request->jam_mulai);
        $jamSelesai = strtotime($request->jam_selesai);
        $durasi     = ($jamSelesai - $jamMulai) / 3600;
        $totalHarga = $durasi * $field->harga_per_jam;

        // Simpan booking
        $booking = Booking::create([
            'id_user'         => auth()->user()->id_user,
            'id_field'        => $request->id_field,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai'       => $request->jam_mulai,
            'jam_selesai'     => $request->jam_selesai,
            'status'          => 'menunggu',
            'total_harga'     => $totalHarga,
        ]);

        // Buat record pembayaran awal
        Payment::create([
            'id_booking'        => $booking->id_booking,
            'metode_pembayaran' => 'belum dipilih',
            'status_pembayaran' => 'belum bayar',
        ]);

        return redirect()->route('bookings.payment', $booking->id_booking)
                         ->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran.');
    }

    // Halaman pembayaran
    public function payment($id)
    {
        $booking = Booking::with(['field', 'payment'])->findOrFail($id);

        // Pastikan hanya pemilik booking yang bisa akses
        if ($booking->id_user !== auth()->user()->id_user && !auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        return view('bookings.payment', compact('booking'));
    }

    // Proses pembayaran
    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',
            'bukti_pembayaran'  => 'nullable|image|max:2048',
        ]);

        $booking = Booking::findOrFail($id);
        $payment = $booking->payment;

        // Upload bukti pembayaran jika ada
        $buktiFoto = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiFoto = $request->file('bukti_pembayaran')
                                 ->store('bukti_pembayaran', 'public');
        }

        // Update pembayaran
        $payment->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'sudah bayar',
            'tanggal_pembayaran' => now()->toDateString(),
            'bukti_pembayaran'  => $buktiFoto,
        ]);

        // Update status booking menjadi dikonfirmasi
        $booking->update(['status' => 'dikonfirmasi']);

        return redirect()->route('bookings.riwayat')
                         ->with('success', 'Pembayaran berhasil! Booking dikonfirmasi.');
    }

    // Riwayat booking user
    public function riwayat()
    {
        $bookings = Booking::with(['field', 'payment'])
                           ->where('id_user', auth()->user()->id_user)
                           ->latest()
                           ->get();

        return view('bookings.riwayat', compact('bookings'));
    }

    // Batalkan booking
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->id_user !== auth()->user()->id_user) {
            abort(403);
        }

        $booking->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
