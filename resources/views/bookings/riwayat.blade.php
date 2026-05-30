@extends('layouts.app')
@section('title', 'Riwayat Booking')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fas fa-history me-2 text-success"></i>Riwayat Booking Saya</h4>
    <a href="{{ route('home') }}" class="btn btn-success rounded-pill btn-sm">
        <i class="fas fa-plus me-1"></i>Booking Baru
    </a>
</div>

@forelse($bookings as $booking)
<div class="card mb-3">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;flex-shrink:0;">
                        <i class="fas fa-futbol text-success"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">{{ $booking->field->nama_lapangan }}</h6>
                        <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $booking->field->lokasi }}</small>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-3 text-muted small ms-1">
                    <span><i class="fas fa-calendar me-1 text-success"></i>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d F Y') }}</span>
                    <span><i class="fas fa-clock me-1 text-success"></i>{{ substr($booking->jam_mulai,0,5) }} – {{ substr($booking->jam_selesai,0,5) }}</span>
                    <span class="fw-semibold text-dark"><i class="fas fa-money-bill me-1 text-success"></i>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="mt-2 ms-1">
                    Pembayaran:
                    @if($booking->payment)
                        @if($booking->payment->status_pembayaran == 'sudah bayar')
                            <span class="badge badge-dikonfirmasi rounded-pill">Lunas</span>
                        @else
                            <span class="badge badge-menunggu rounded-pill">Belum Bayar</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                @php
                    $cls=['menunggu'=>'badge-menunggu','dikonfirmasi'=>'badge-dikonfirmasi','selesai'=>'badge-selesai','dibatalkan'=>'badge-dibatalkan'];
                    $icon=['menunggu'=>'⏳','dikonfirmasi'=>'✓','selesai'=>'✓','dibatalkan'=>'✗'];
                @endphp
                <span class="badge rounded-pill px-3 py-2 {{ $cls[$booking->status] ?? 'bg-secondary' }}" style="font-size:.9rem;">
                    {{ $icon[$booking->status] ?? '' }} {{ ucfirst($booking->status) }}
                </span>

                <div class="mt-2 d-flex flex-wrap gap-2 justify-content-md-end">
                    @if($booking->status == 'menunggu' && $booking->payment && $booking->payment->status_pembayaran == 'belum bayar')
                        <a href="{{ route('bookings.payment', $booking->id_booking) }}" class="btn btn-warning btn-sm rounded-pill fw-bold">
                            <i class="fas fa-credit-card me-1"></i>Bayar
                        </a>
                    @endif
                    @if(in_array($booking->status, ['menunggu', 'dikonfirmasi']))
                        <form action="{{ route('bookings.cancel', $booking->id_booking) }}" method="POST"
                              onsubmit="return confirm('Yakin batalkan booking ini?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                <i class="fas fa-times me-1"></i>Batalkan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="text-center py-5">
    <div class="mb-4">
        <i class="fas fa-calendar-times fa-4x text-muted opacity-50"></i>
    </div>
    <h5 class="text-muted">Belum ada booking</h5>
    <p class="text-muted">Yuk, booking lapangan futsal sekarang!</p>
    <a href="{{ route('home') }}" class="btn btn-success rounded-pill px-4 mt-2">
        <i class="fas fa-futbol me-2"></i>Lihat Lapangan
    </a>
</div>
@endforelse
@endsection
