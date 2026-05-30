@extends('layouts.app')
@section('title', 'Kelola Lapangan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="fas fa-futbol me-2 text-success"></i>Kelola Lapangan</h4>
        <small class="text-muted">{{ $fields->count() }} lapangan terdaftar</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Dashboard
        </a>
        <a href="{{ route('admin.fields.create') }}" class="btn btn-success rounded-pill btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Lapangan
        </a>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background:#dcfce7;">
                <tr>
                    <th>#</th><th>Lapangan</th><th>Lokasi</th><th>Harga/Jam</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fields as $f)
                <tr>
                    <td class="text-muted small">{{ $f->id_field }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($f->foto)
                                <img src="{{ asset('storage/'.$f->foto) }}" class="rounded" style="width:44px;height:44px;object-fit:cover;">
                            @else
                                <div class="rounded bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                                     style="width:44px;height:44px;">
                                    <i class="fas fa-futbol text-success"></i>
                                </div>
                            @endif
                            <span class="fw-semibold">{{ $f->nama_lapangan }}</span>
                        </div>
                    </td>
                    <td class="text-muted small">{{ $f->lokasi }}</td>
                    <td class="text-success fw-semibold">Rp {{ number_format($f->harga_per_jam, 0, ',', '.') }}</td>
                    <td>
                        @if($f->status == 'tersedia')
                            <span class="badge rounded-pill badge-dikonfirmasi">Tersedia</span>
                        @else
                            <span class="badge rounded-pill badge-dibatalkan">Tidak Tersedia</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.fields.edit', $f->id_field) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.fields.delete', $f->id_field) }}" method="POST"
                                  onsubmit="return confirm('Hapus lapangan {{ $f->nama_lapangan }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada lapangan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
