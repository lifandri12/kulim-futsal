@extends('layouts.app')
@section('title', $field->nama_lapangan . ' - Kulim Futsal')

@section('content')
<div class="row">
    <div class="col-md-8">
        {{-- Info Lapangan --}}
        <div class="card mb-4">
            @if($field->foto)
                <img src="{{ asset('storage/' . $field->foto) }}" class="card-img-top" style="height:300px; object-fit:cover;" alt="">
            @endif
            <div class="card-body">
                <h3>{{ $field->nama_lapangan }}</h3>
                <p class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $field->lokasi }}</p>
                <h5 class="text-success">Rp {{ number_format($field->harga_per_jam, 0, ',', '.') }} / jam</h5>
                <p>{{ $field->deskripsi }}</p>

                {{-- Status --}}
                @if($field->status == 'tersedia')
                    <span class="badge bg-success fs-6">✓ Lapangan Tersedia</span>
                @else
                    <span class="badge bg-danger fs-6">✗ Tidak Tersedia</span>
                @endif
            </div>
        </div>

        {{-- Jadwal yang sudah dipesan (hari ini) --}}
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <i class="fas fa-calendar me-2"></i>Jadwal Sudah Dipesan
            </div>
            <div class="card-body">
                @if($bookings->isEmpty())
                    <p class="text-muted">Belum ada booking untuk lapangan ini.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $bk)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($bk->tanggal_booking)->format('d/m/Y') }}</td>
                                    <td>{{ $bk->jam_mulai }}</td>
                                    <td>{{ $bk->jam_selesai }}</td>
                                    <td><span class="badge bg-warning text-dark">Dipesan</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Review Lapangan --}}
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-star me-2 text-warning"></i>Ulasan Pengguna
            </div>
            <div class="card-body">
                @forelse($reviews as $review)
                <div class="border-bottom pb-3 mb-3">
                    <strong>{{ $review->user->nama }}</strong>
                    <span class="ms-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                        @endfor
                    </span>
                    <p class="mb-0 mt-1 text-muted">{{ $review->komentar }}</p>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>
                @empty
                    <p class="text-muted">Belum ada ulasan.</p>
                @endforelse

                {{-- Form tulis review (hanya user login) --}}
                @auth
                <hr>
                <h6>Tulis Ulasan Kamu</h6>
                <form action="{{ route('fields.review', $field->id_field) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label>Rating</label>
                        <select name="rating" class="form-select" required>
                            <option value="">-- Pilih Rating --</option>
                            <option value="5">⭐⭐⭐⭐⭐ Luar Biasa</option>
                            <option value="4">⭐⭐⭐⭐ Bagus</option>
                            <option value="3">⭐⭐⭐ Cukup</option>
                            <option value="2">⭐⭐ Kurang</option>
                            <option value="1">⭐ Buruk</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Komentar (opsional)</label>
                        <textarea name="komentar" class="form-control" rows="3" placeholder="Ceritakan pengalaman kamu..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning btn-sm">Kirim Ulasan</button>
                </form>
                @endauth
            </div>
        </div>
    </div>

    {{-- Sidebar: Tombol Booking --}}
    <div class="col-md-4">
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-body text-center">
                <h5 class="text-success">Siap Main?</h5>
                <p class="text-muted">Harga mulai dari</p>
                <h3 class="fw-bold">Rp {{ number_format($field->harga_per_jam, 0, ',', '.') }}</h3>
                <p class="text-muted">per jam</p>

                @auth
                    @if($field->status == 'tersedia')
                        <a href="{{ route('bookings.create', $field->id_field) }}" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-calendar-plus me-2"></i>Booking Sekarang
                        </a>
                    @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>Tidak Tersedia</button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-success btn-lg w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Login untuk Booking
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
