@extends('layouts.app')
@section('title', 'Pembayaran Booking')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('bookings.riwayat') }}" class="btn btn-outline-secondary rounded-circle"
       style="width:38px;height:38px;padding:0;line-height:36px;text-align:center;">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0"><i class="fas fa-credit-card me-2 text-warning"></i>Pembayaran</h4>
</div>

{{-- Detail booking --}}
<div class="card mb-4">
    <div class="card-header" style="background:#f0fdf4;">
        <span class="fw-bold text-success"><i class="fas fa-receipt me-2"></i>Detail Booking</span>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr>
                <td class="text-muted" style="width:40%">Lapangan</td>
                <td class="fw-semibold">{{ $booking->field->nama_lapangan }}</td>
            </tr>
            <tr>
                <td class="text-muted">Tanggal</td>
                <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="text-muted">Waktu</td>
                <td>{{ substr($booking->jam_mulai,0,5) }} – {{ substr($booking->jam_selesai,0,5) }} WIB</td>
            </tr>
            <tr class="table-success">
                <td class="fw-bold">Total Bayar</td>
                <td class="fw-bold text-success fs-5">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</div>

{{-- Form Pembayaran --}}
<div class="card">
    <div class="card-header" style="background:#fffbeb;">
        <span class="fw-bold text-warning"><i class="fas fa-wallet me-2"></i>Metode Pembayaran</span>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('bookings.processPayment', $booking->id_booking) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-semibold">Pilih Metode <span class="text-danger">*</span></label>
                <div class="row g-2">
                    @foreach(['Transfer Bank BRI','Transfer Bank BNI','Transfer Bank Mandiri','DANA','OVO','GoPay','Tunai (Bayar di Tempat)'] as $m)
                    <div class="col-6">
                        <div class="form-check border rounded-3 p-3" style="border-color:#d1fae5 !important;">
                            <input class="form-check-input" type="radio" name="metode_pembayaran"
                                   id="m{{ $loop->index }}" value="{{ $m }}"
                                   {{ old('metode_pembayaran')==$m?'checked':'' }} required>
                            <label class="form-check-label w-100" for="m{{ $loop->index }}" style="cursor:pointer;">
                                {{ $m }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('metode_pembayaran')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Bukti Pembayaran <span class="text-muted fw-normal">(opsional)</span></label>
                <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" id="buktiInput">
                <div class="mt-2">
                    <img id="preview" src="#" alt="" class="rounded d-none" style="max-height:160px;">
                </div>
                @error('bukti_pembayaran')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-warning fw-bold rounded-pill w-100 py-3" style="font-size:1.1rem;">
                <i class="fas fa-check-circle me-2"></i>Konfirmasi Pembayaran
            </button>
        </form>
    </div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('buktiInput').addEventListener('change', function(e) {
    const preview = document.getElementById('preview');
    const file = e.target.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
});
</script>
@endsection
