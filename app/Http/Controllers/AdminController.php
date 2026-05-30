<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard admin
    public function dashboard()
    {
        $totalBooking    = Booking::count();
        $totalUser       = User::where('role', 'user')->count();
        $totalLapangan   = Field::count();
        $totalPendapatan = Payment::where('status_pembayaran', 'sudah bayar')
                                  ->join('bookings', 'payments.id_booking', '=', 'bookings.id_booking')
                                  ->sum('bookings.total_harga');

        $bookingTerbaru = Booking::with(['user', 'field'])
                                  ->latest()
                                  ->take(5)
                                  ->get();

        return view('admin.dashboard', compact(
            'totalBooking', 'totalUser', 'totalLapangan',
            'totalPendapatan', 'bookingTerbaru'
        ));
    }

    // ====== MANAJEMEN LAPANGAN ======

    public function fields()
    {
        $fields = Field::all();
        return view('admin.fields.index', compact('fields'));
    }

    public function fieldCreate()
    {
        return view('admin.fields.create');
    }

    public function fieldStore(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'lokasi'        => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric|min:0',
            'status'        => 'required|in:tersedia,tidak tersedia',
            'deskripsi'     => 'nullable|string',
            'foto'          => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fields', 'public');
        }

        Field::create($data);

        return redirect()->route('admin.fields')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    public function fieldEdit($id)
    {
        $field = Field::findOrFail($id);
        return view('admin.fields.edit', compact('field'));
    }

    public function fieldUpdate(Request $request, $id)
    {
        $field = Field::findOrFail($id);

        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'lokasi'        => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric|min:0',
            'status'        => 'required|in:tersedia,tidak tersedia',
            'deskripsi'     => 'nullable|string',
            'foto'          => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fields', 'public');
        }

        $field->update($data);

        return redirect()->route('admin.fields')->with('success', 'Lapangan berhasil diupdate!');
    }

    public function fieldDelete($id)
    {
        Field::findOrFail($id)->delete();
        return back()->with('success', 'Lapangan berhasil dihapus.');
    }

    // ====== MANAJEMEN BOOKING ======

    public function bookings()
    {
        $bookings = Booking::with(['user', 'field', 'payment'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function bookingUpdateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:menunggu,dikonfirmasi,selesai,dibatalkan']);
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);
        return back()->with('success', 'Status booking diperbarui.');
    }

    // ====== MANAJEMEN USER ======

    public function users()
    {
        $users = User::where('role', 'user')->with('bookings')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function userDelete($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun admin.');
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
