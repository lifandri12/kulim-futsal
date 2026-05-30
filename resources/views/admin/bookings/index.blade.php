@extends('layouts.app')
@section('title', 'Kelola Booking')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>Kelola Booking</h4>
        <small class="text-muted">{{ $bookings->count() }} total booking</small>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Dashboard
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-primary">
                <tr>
                    <th>#</th><th>User</th><th>Lapangan</th><th>Tanggal</th>
                    <th>Jam</th><th>Total</th><th>Booking</th><th>Pembayaran</th><th>Ubah Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td class="text-muted small">{{ $b->id_booking }}</td>
                    <td>{{ $b->user->nama }}</td>
                    <td>{{ $b->field->nama_lapangan }}</td>
                    <td class="small">{{ \Carbon\Carbon::parse($b->tanggal_booking)->format('d/m/Y') }}</td>
                    <td class="small text-muted">{{ substr($b->jam_mulai,0,5) }}–{{ substr($b->jam_selesai,0,5) }}</td>
                    <td class="text-success fw-semibold small">Rp {{ number_format($b->total_harga, 0, ',', '.') }}</td>
                    <td>
                        @php $cls=['menunggu'=>'badge-menunggu','dikonfirmasi'=>'badge-dikonfirmasi','selesai'=>'badge-selesai','dibatalkan'=>'badge-dibatalkan']; @endphp
                        <span class="badge rounded-pill px-2 {{ $cls[$b->status] ?? 'bg-secondary' }}">{{ ucfirst($b->status) }}</span>
                    </td>
                    <td>
                        @if($b->payment)
                            <span class="badge rounded-pill {{ $b->payment->status_pembayaran == 'sudah bayar' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $b->payment->status_pembayaran == 'sudah bayar' ? 'Lunas' : 'Belum' }}
                            </span>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.bookings.status', $b->id_booking) }}" method="POST" class="d-flex gap-1">
                            @csrf
                            <select name="status" class="form-select form-select-sm" style="min-width:120px;">
                                <option value="menunggu" {{ $b->status=='menunggu'?'selected':'' }}>Menunggu</option>
                                <option value="dikonfirmasi" {{ $b->status=='dikonfirmasi'?'selected':'' }}>Dikonfirmasi</option>
                                <option value="selesai" {{ $b->status=='selesai'?'selected':'' }}>Selesai</option>
                                <option value="dibatalkan" {{ $b->status=='dibatalkan'?'selected':'' }}>Dibatalkan</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-success">✓</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Belum ada booking.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
