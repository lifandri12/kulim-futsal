@extends('layouts.app')
@section('title', 'Kelola User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="fas fa-users me-2 text-warning"></i>Daftar User</h4>
        <small class="text-muted">{{ $users->count() }} user terdaftar</small>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Dashboard
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background:#fef3c7;">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Bergabung</th>
                    <th>Total Booking</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td class="text-muted small">{{ $u->id_user }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                                 style="width:36px;height:36px;font-weight:700;font-size:.9rem;flex-shrink:0;">
                                {{ strtoupper(substr($u->nama, 0, 1)) }}
                            </div>
                            <span class="fw-semibold">{{ $u->nama }}</span>
                        </div>
                    </td>
                    <td class="text-muted">{{ $u->email }}</td>
                    <td>{{ $u->no_hp ?? '-' }}</td>
                    <td class="text-muted small">{{ $u->created_at->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge rounded-pill bg-primary">{{ $u->bookings->count() }} booking</span>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.delete', $u->id_user) }}" method="POST"
                              onsubmit="return confirm('Hapus user {{ $u->nama }}? Semua booking terkait akan ikut terhapus.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger rounded-pill">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada user terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
