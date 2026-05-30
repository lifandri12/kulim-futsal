@extends('layouts.app')
@section('title', 'Dashboard Admin - Kulim Futsal')

@section('content')
{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-success mb-0"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</h4>
        <small class="text-muted">Selamat datang, <strong>{{ auth()->user()->nama }}</strong></small>
    </div>
    <span class="badge bg-success rounded-pill px-3 py-2">
        <i class="fas fa-shield-alt me-1"></i>Administrator
    </span>
</div>

{{-- STATS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card stat-card green h-100">
            <i class="fas fa-calendar-check fa-2x mb-2 opacity-75"></i>
            <h2 class="fw-bold mb-0">{{ $totalBooking }}</h2>
            <p class="mb-0 small opacity-75">Total Booking</p>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card blue h-100">
            <i class="fas fa-users fa-2x mb-2 opacity-75"></i>
            <h2 class="fw-bold mb-0">{{ $totalUser }}</h2>
            <p class="mb-0 small opacity-75">Total User</p>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card orange h-100">
            <i class="fas fa-futbol fa-2x mb-2 opacity-75"></i>
            <h2 class="fw-bold mb-0">{{ $totalLapangan }}</h2>
            <p class="mb-0 small opacity-75">Lapangan</p>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card red h-100">
            <i class="fas fa-coins fa-2x mb-2 opacity-75"></i>
            <p class="fw-bold mb-0" style="font-size:1rem;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            <p class="mb-0 small opacity-75">Pendapatan</p>
        </div>
    </div>
</div>

{{-- QUICK MENU --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <a href="{{ route('admin.fields') }}" class="card text-decoration-none h-100" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
            <div class="card-body text-center py-4">
                <i class="fas fa-futbol fa-2x text-success mb-2"></i>
                <p class="fw-bold text-success mb-1">Kelola Lapangan</p>
                <small class="text-muted">CRUD data lapangan futsal</small>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.bookings') }}" class="card text-decoration-none h-100" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);">
            <div class="card-body text-center py-4">
                <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                <p class="fw-bold text-primary mb-1">Kelola Booking</p>
                <small class="text-muted">Monitor & update status booking</small>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.users') }}" class="card text-decoration-none h-100" style="background:linear-gradient(135deg,#fffbeb,#fef3c7);">
            <div class="card-body text-center py-4">
                <i class="fas fa-users fa-2x text-warning mb-2"></i>
                <p class="fw-bold text-warning mb-1">Kelola User</p>
                <small class="text-muted">Daftar user terdaftar</small>
            </div>
        </a>
    </div>
</div>

{{-- BOOKING TERBARU --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center" style="background:#f0fdf4;">
        <span class="text-success fw-bold"><i class="fas fa-clock me-2"></i>Booking Terbaru</span>
        <a href="{{ route('admin.bookings') }}" class="btn btn-sm btn-outline-success rounded-pill">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th><th>User</th><th>Lapangan</th><th>Tanggal</th><th>Total</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookingTerbaru as $b)
                <tr>
                    <td class="text-muted small">{{ $b->id_booking }}</td>
                    <td>{{ $b->user->nama }}</td>
                    <td>{{ $b->field->nama_lapangan }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->tanggal_booking)->format('d/m/Y') }}</td>
                    <td class="text-success fw-semibold">Rp {{ number_format($b->total_harga, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $cls = ['menunggu'=>'badge-menunggu','dikonfirmasi'=>'badge-dikonfirmasi','selesai'=>'badge-selesai','dibatalkan'=>'badge-dibatalkan'];
                        @endphp
                        <span class="badge {{ $cls[$b->status] ?? 'bg-secondary' }} rounded-pill px-3">{{ ucfirst($b->status) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
