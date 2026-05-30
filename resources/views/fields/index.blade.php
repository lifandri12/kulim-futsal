@extends('layouts.app')
@section('title', 'Daftar Lapangan - Kulim Futsal')

@section('content')
{{-- HERO --}}
<div class="hero-section text-center">
    <h1><i class="fas fa-futbol me-3"></i>Kulim Futsal</h1>
    <p class="mb-0 opacity-75 fs-5">Booking lapangan futsal online — mudah, cepat, terpercaya</p>
    @guest
    <div class="mt-3">
        <a href="{{ route('register') }}" class="btn btn-light fw-bold me-2 px-4 rounded-pill">
            <i class="fas fa-user-plus me-1"></i>Daftar Sekarang
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline-light px-4 rounded-pill">Login</a>
    </div>
    @endguest
</div>

{{-- SEARCH & FILTER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold text-success mb-0">
        <i class="fas fa-th-large me-2"></i>{{ $fields->count() }} Lapangan Tersedia
    </h5>
</div>

<div class="row g-4">
    @forelse($fields as $field)
    <div class="col-sm-6 col-lg-4">
        <div class="card h-100">
            @if($field->foto)
                <img src="{{ asset('storage/' . $field->foto) }}" class="card-img-top"
                     style="height:210px; object-fit:cover; border-radius:14px 14px 0 0;" alt="{{ $field->nama_lapangan }}">
            @else
                <div class="d-flex align-items-center justify-content-center bg-success bg-opacity-10"
                     style="height:210px; border-radius:14px 14px 0 0;">
                    <div class="text-center">
                        <i class="fas fa-futbol fa-4x text-success opacity-40"></i>
                        <p class="text-muted mt-2 small">Foto belum tersedia</p>
                    </div>
                </div>
            @endif

            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title fw-bold mb-0">{{ $field->nama_lapangan }}</h5>
                    @if($field->status == 'tersedia')
                        <span class="badge rounded-pill" style="background:#dcfce7;color:#166534;font-size:.75rem;">
                            <i class="fas fa-circle me-1" style="font-size:.5rem;"></i>Tersedia
                        </span>
                    @else
                        <span class="badge rounded-pill" style="background:#fee2e2;color:#991b1b;font-size:.75rem;">
                            <i class="fas fa-circle me-1" style="font-size:.5rem;"></i>Penuh
                        </span>
                    @endif
                </div>

                <p class="text-muted small mb-2">
                    <i class="fas fa-map-marker-alt me-1 text-success"></i>{{ $field->lokasi }}
                </p>

                {{-- Rating --}}
                <div class="mb-2">
                    @php $rating = round($field->rating_rata_rata); @endphp
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $rating ? 'star-filled' : 'star-empty' }}" style="font-size:.8rem;"></i>
                    @endfor
                    <small class="text-muted ms-1">{{ number_format($field->rating_rata_rata, 1) }} ({{ $field->reviews_count }} ulasan)</small>
                </div>

                <div class="mt-auto">
                    <p class="fw-bold text-success fs-5 mb-3">
                        Rp {{ number_format($field->harga_per_jam, 0, ',', '.') }}<small class="fw-normal text-muted fs-6"> / jam</small>
                    </p>
                    <a href="{{ route('fields.show', $field->id_field) }}" class="btn btn-success w-100 rounded-pill">
                        <i class="fas fa-calendar-plus me-2"></i>Lihat & Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-futbol fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada lapangan tersedia.</p>
        </div>
    @endforelse
</div>
@endsection
