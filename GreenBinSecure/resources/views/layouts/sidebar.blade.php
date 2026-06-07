<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f8f9fc; min-height: 100vh; }
        .sidebar { background: linear-gradient(180deg, #198754 0%, #146c43 100%); min-height: 100vh; width: 250px; position: fixed; top: 0; left: 0; z-index: 100; padding-top: 1rem; }
        .sidebar .nav-link { color: rgba(255,255,255,.8); padding: .75rem 1.25rem; border-radius: .5rem; margin: 0 .5rem; transition: all .2s; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,.15); }
        .sidebar .nav-link.active { color: #198754; background: #fff; font-weight: 600; }
        .sidebar .nav-link i { margin-right: .75rem; width: 1.25rem; text-align: center; }
        .sidebar-brand { color: #fff; font-size: 1.25rem; font-weight: 700; padding: 1rem 1.25rem; display: block; text-decoration: none; }
        .sidebar-brand:hover { color: #fff; }
        .sidebar-divider { border-top: 1px solid rgba(255,255,255,.2); margin: 1rem 1.25rem; }
        .content-wrapper { margin-left: 250px; padding: 1.5rem; }
        .navbar-top { background: #fff; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075); margin: -1.5rem -1.5rem 1.5rem -1.5rem; padding: 1rem 1.5rem; }
        .stat-card { border: none; border-radius: 1rem; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075); transition: transform .2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card .icon { font-size: 2rem; opacity: .3; }
        .card { border: none; border-radius: 1rem; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075); }
        .table { margin-bottom: 0; }
        .page-title { font-size: 1.5rem; font-weight: 600; color: #333; }
        @media (max-width: 768px) { .sidebar { width: 100%; min-height: auto; position: relative; } .content-wrapper { margin-left: 0; } }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <a href="{{ route($role . '.dashboard') }}" class="sidebar-brand">
                <i class="bi bi-recycle"></i> GreenBin
            </a>
            <hr class="sidebar-divider">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs($role . '.dashboard') ? 'active' : '' }}"
                       href="{{ route($role . '.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                @if ($role === 'warga')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('warga.setoran.*') ? 'active' : '' }}"
                           href="{{ route('warga.setoran.index') }}">
                            <i class="bi bi-clock-history"></i> Riwayat Setoran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('warga.setoran.create') ? 'active' : '' }}"
                           href="{{ route('warga.setoran.create') }}">
                            <i class="bi bi-plus-circle"></i> Tambah Setoran
                        </a>
                    </li>
                @endif
                @if ($role === 'petugas')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.setoran.*') ? 'active' : '' }}"
                           href="{{ route('petugas.setoran.index') }}">
                            <i class="bi bi-list-check"></i> Semua Setoran
                        </a>
                    </li>
                @endif
                @if ($role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                           href="{{ route('admin.users.index') }}">
                            <i class="bi bi-people"></i> Kelola User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.setoran.*') ? 'active' : '' }}"
                           href="{{ route('admin.setoran.index') }}">
                            <i class="bi bi-box-seam"></i> Semua Setoran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}"
                           href="{{ route('admin.logs.index') }}">
                            <i class="bi bi-activity"></i> Activity Log
                        </a>
                    </li>
                @endif
            </ul>
            <hr class="sidebar-divider">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <div class="content-wrapper w-100">
            <div class="navbar-top d-flex justify-content-between align-items-center">
                <span class="page-title">@yield('title', 'Dashboard')</span>
                <div>
                    <i class="bi bi-person-circle"></i>
                    <span class="ms-1">{{ Auth::user()->nama }}</span>
                    <span class="badge bg-success ms-2 text-capitalize">{{ Auth::user()->role }}</span>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
