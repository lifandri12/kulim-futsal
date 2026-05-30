<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kulim Futsal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg,#14532d 0%,#16a34a 50%,#22c55e 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .auth-card { background:#fff; border-radius:20px; padding:40px; max-width:420px; width:100%; box-shadow:0 20px 60px rgba(0,0,0,0.2); }
        .auth-logo { font-size:2rem; font-weight:800; color:#16a34a; }
        .form-control { border-radius:10px; border:1.5px solid #d1fae5; padding:12px 15px; }
        .form-control:focus { border-color:#16a34a; box-shadow:0 0 0 .2rem rgba(22,163,74,.15); }
        .btn-login { background:linear-gradient(135deg,#16a34a,#15803d); border:none; border-radius:10px; padding:12px; font-weight:700; width:100%; }
        .btn-login:hover { background:linear-gradient(135deg,#15803d,#14532d); }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="text-center mb-4">
        <div class="auth-logo"><i class="fas fa-futbol me-2"></i>Kulim Futsal</div>
        <p class="text-muted mt-1">Masuk ke akun Anda</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-3">
            <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold text-muted small">Email</label>
            <input type="email" name="email" class="form-control" placeholder="email@example.com"
                   value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold text-muted small">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-login btn-success text-white mb-3">
            <i class="fas fa-sign-in-alt me-2"></i>Masuk
        </button>
    </form>
    <p class="text-center text-muted small mb-0">
        Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-bold">Daftar sekarang</a>
    </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
