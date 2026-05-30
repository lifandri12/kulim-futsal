@extends('layouts.app')
@section('title', 'Booking ' . $field->nama_lapangan)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('fields.show', $field->id_field) }}" class="btn btn-outline-secondary rounded-circle"
               style="width:38px;height:38px;padding:0;line-height:36px;text-align:center;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="fw-bold mb-0"><i class="fas fa-calendar-plus me-2 text-success"></i>Form Booking</h4>
                <small class="text-muted">{{ $field->nama_lapangan }}</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        @foreach($errors->all() as $e)
                            <div><i class="fas fa-exclamation-circle me-1"></i>{{ $e }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_field" value="{{ $field->id_field }}">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Booking <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_booking" class="form-control"
                               min="{{ date('Y-m-d') }}" value="{{ old('tanggal_booking') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Jam Mulai <span class="text-danger">*</span></label>
                            <select name="jam_mulai" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                @for($h = 6; $h <= 22; $h++)
                                    @php $t = sprintf('%02d:00', $h); @endphp
                                    <option value="{{ $t }}" {{ old('jam_mulai')==$t?'selected':'' }}>{{ $t }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Jam Selesai <span class="text-danger">*</span></label>
                            <select name="jam_selesai" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                @for($h = 7; $h <= 23; $h++)
                                    @php $t = sprintf('%02d:00', $h); @endphp
                                    <option value="{{ $t }}" {{ old('jam_selesai')==$t?'selected':'' }}>{{ $t }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="alert" style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:12px;">
                        <i class="fas fa-info-circle text-success me-2"></i>
                        Harga: <strong>Rp {{ number_format($field->harga_per_jam, 0, ',', '.') }} / jam</strong>.
                        Total dihitung otomatis berdasarkan durasi.
                    </div>

                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold w-100 mt-2">
                        <i class="fas fa-check me-2"></i>Lanjut ke Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="card booking-sidebar">
            <div class="card-body">
                @if($field->foto)
                    <img src="{{ asset('storage/'.$field->foto) }}" class="rounded-3 w-100 mb-3" style="height:160px;object-fit:cover;" alt="">
                @endif
                <h6 class="fw-bold">{{ $field->nama_lapangan }}</h6>
                <p class="text-muted small mb-1"><i class="fas fa-map-marker-alt me-1 text-success"></i>{{ $field->lokasi }}</p>
                <p class="text-success fw-bold fs-5 mb-0">Rp {{ number_format($field->harga_per_jam, 0, ',', '.') }}<small class="fw-normal text-muted fs-6"> / jam</small></p>
            </div>
        </div>
    </div>
</div>
@endsection
