<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Kulim Futsal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg,#14532d 0%,#16a34a 50%,#22c55e 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; }
        .auth-card { background:#fff; border-radius:20px; padding:40px; max-width:460px; width:100%; box-shadow:0 20px 60px rgba(0,0,0,0.2); }
        .auth-logo { font-size:2rem; font-weight:800; color:#16a34a; }
        .form-control { border-radius:10px; border:1.5px solid #d1fae5; padding:12px 15px; }
        .form-control:focus { border-color:#16a34a; box-shadow:0 0 0 .2rem rgba(22,163,74,.15); }
        .btn-register { background:linear-gradient(135deg,#16a34a,#15803d); border:none; border-radius:10px; padding:12px; font-weight:700; width:100%; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="text-center mb-4">
        <div class="auth-logo"><i class="fas fa-futbol me-2"></i>Kulim Futsal</div>
        <p class="text-muted mt-1">Buat akun baru</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-3">
            @foreach($errors->all() as $e)
                <div><i class="fas fa-exclamation-circle me-1"></i>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold text-muted small">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" placeholder="Nama Anda"
                   value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold text-muted small">Email</label>
            <input type="email" name="email" class="form-control" placeholder="email@example.com"
                   value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold text-muted small">No. HP</label>
            <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx"
                   value="{{ old('no_hp') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold text-muted small">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold text-muted small">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
        </div>
        <button type="submit" class="btn btn-register btn-success text-white mb-3">
            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
        </button>
    </form>
    <p class="text-center text-muted small mb-0">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-success fw-bold">Login di sini</a>
    </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
