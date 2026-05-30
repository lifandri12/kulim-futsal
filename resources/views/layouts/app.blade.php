<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kulim Futsal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --green: #16a34a;
            --green-dark: #15803d;
            --green-light: #dcfce7;
        }
        body { background: #f0fdf4; font-family: 'Segoe UI', sans-serif; }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(135deg, #14532d 0%, #16a34a 100%) !important;
            box-shadow: 0 4px 20px rgba(22,163,74,0.3);
        }
        .navbar-brand { color: #fff !important; font-weight: 800; font-size: 1.4rem; letter-spacing: 1px; }
        .navbar-brand i { color: #bbf7d0; }
        .nav-link { color: rgba(255,255,255,0.88) !important; font-weight: 500; transition: color .2s; }
        .nav-link:hover, .nav-link.active { color: #fff !important; }
        .nav-btn-outline { border: 2px solid rgba(255,255,255,0.6); border-radius: 20px; padding: 4px 16px !important; }
        .nav-btn-outline:hover { background: rgba(255,255,255,0.15) !important; }
        .nav-btn-solid { background: #fff; color: #16a34a !important; border-radius: 20px; padding: 4px 16px !important; font-weight: 700; }
        .nav-btn-solid:hover { background: #bbf7d0 !important; }
        .navbar-toggler { border-color: rgba(255,255,255,0.5); }
        .navbar-toggler-icon { filter: invert(1); }

        /* CARDS */
        .card { border: none; border-radius: 14px; box-shadow: 0 2px 16px rgba(0,0,0,0.07); transition: transform .2s, box-shadow .2s; }
        .card:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        .card-header { border-radius: 14px 14px 0 0 !important; font-weight: 600; }

        /* BUTTONS */
        .btn-success, .btn-primary-custom {
            background: linear-gradient(135deg, #16a34a, #15803d);
            border: none; font-weight: 600;
        }
        .btn-success:hover { background: linear-gradient(135deg, #15803d, #14532d); }

        /* BADGES */
        .badge-menunggu { background: #fef3c7; color: #92400e; }
        .badge-dikonfirmasi { background: #dcfce7; color: #166534; }
        .badge-selesai { background: #dbeafe; color: #1e40af; }
        .badge-dibatalkan { background: #fee2e2; color: #991b1b; }

        /* HERO */
        .hero-section {
            background: linear-gradient(135deg, #14532d 0%, #16a34a 50%, #22c55e 100%);
            color: white;
            padding: 60px 0 40px;
            margin: -24px -12px 30px;
            border-radius: 0 0 30px 30px;
        }
        .hero-section h1 { font-weight: 800; font-size: 2.2rem; }

        /* STATS CARD */
        .stat-card { border-radius: 16px; padding: 20px; text-align: center; color: white; }
        .stat-card.green { background: linear-gradient(135deg, #16a34a, #22c55e); }
        .stat-card.blue { background: linear-gradient(135deg, #2563eb, #3b82f6); }
        .stat-card.orange { background: linear-gradient(135deg, #d97706, #f59e0b); }
        .stat-card.red { background: linear-gradient(135deg, #dc2626, #ef4444); }

        /* TABLE */
        .table { border-radius: 14px; overflow: hidden; }
        .table thead th { font-weight: 600; font-size: .85rem; text-transform: uppercase; letter-spacing: .5px; }

        /* ALERT */
        .alert { border-radius: 12px; border: none; font-weight: 500; }

        /* SIDEBAR STICKY */
        .booking-sidebar { position: sticky; top: 80px; }

        /* FOOTER */
        footer { background: linear-gradient(135deg, #14532d, #16a34a); color: rgba(255,255,255,0.8); }
        footer a { color: rgba(255,255,255,0.7); }

        /* FORM */
        .form-control, .form-select { border-radius: 10px; border: 1.5px solid #d1fae5; }
        .form-control:focus, .form-select:focus { border-color: #16a34a; box-shadow: 0 0 0 .2rem rgba(22,163,74,.15); }

        /* STARS */
        .star-filled { color: #f59e0b; }
        .star-empty { color: #d1d5db; }

        /* Admin sidebar */
        .admin-menu .btn { border-radius: 10px; text-align: left; font-weight: 500; }
    </style>
    @yield('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-futbol me-2"></i>Kulim Futsal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-futbol me-1"></i>Lapangan</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bookings.riwayat') }}"><i class="fas fa-history me-1"></i>Riwayat</a>
                    </li>
                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link nav-btn-outline ms-2" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-shield-alt me-1"></i>Admin
                        </a>
                    </li>
                    @endif
                    <li class="nav-item ms-1">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link nav-btn-outline btn btn-link">
                                <i class="fas fa-sign-out-alt me-1"></i>{{ auth()->user()->nama }}
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link nav-btn-outline" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item ms-1">
                        <a class="nav-link nav-btn-solid" href="{{ route('register') }}">Daftar</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4 px-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<footer class="text-center mt-5 py-4">
    <div class="container">
        <p class="mb-1 fw-bold text-white"><i class="fas fa-futbol me-2"></i>Kulim Futsal</p>
        <small>&copy; {{ date('Y') }} Kulim Futsal — Web Application Development Project</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
