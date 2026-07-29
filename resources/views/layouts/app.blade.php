<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SpekTi') — Sistem Prediksi Tiga Setengah Tahun</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* ── Academic Precision Design System ── */
        :root {
            --primary: #004ac6;
            --primary-light: #2563eb;
            --primary-tint: rgba(0, 74, 198, 0.1);
            --on-primary: #ffffff;
            --bg: #f8f9ff;
            --surface: #ffffff;
            --on-surface: #0b1c30;
            --on-surface-variant: #434655;
            --outline: #737686;
            --outline-variant: #c3c6d7;
            --border: #E2E8F0;
            --success-bg: #d4edda;
            --success-text: #155724;
            --danger-bg: #f8d7da;
            --danger-text: #721c24;
            --warning-bg: #fef3c7;
            --warning-text: #92400e;
            --sidebar-w: 240px;
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background: var(--bg);
            color: var(--on-surface);
            min-height: 100vh;
        }

        /* ── Animations ── */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .page-content {
            animation: fadeInUp 0.35s ease-out;
        }

        /* ── Mobile Topbar (hidden on desktop) ── */
        .mobile-topbar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            z-index: 101;
            align-items: center;
            padding: 0 1rem;
            gap: 0.75rem;
        }

        .mobile-topbar .brand-text {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
        }

        .mobile-topbar .btn-hamburger {
            background: none;
            border: none;
            color: var(--on-surface);
            font-size: 22px;
            cursor: pointer;
            padding: 0.25rem;
            line-height: 1;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 102;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-brand h5 {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
        }

        .sidebar-brand small {
            font-size: 11px;
            color: var(--on-surface-variant);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex: 1;
        }

        .sidebar-section {
            padding: 0.5rem 1.5rem;
            font-size: 11px;
            font-weight: 600;
            color: var(--outline);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1.5rem;
            color: var(--on-surface-variant);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s;
        }

        .sidebar-nav .nav-link:hover {
            background: var(--primary-tint);
            color: var(--primary);
        }

        .sidebar-nav .nav-link.active {
            background: var(--primary);
            color: var(--on-primary);
        }

        .sidebar-nav .nav-link i {
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border);
        }

        /* ── Sidebar Overlay (mobile) ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 101;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
        }

        /* ── Content ── */
        .main-content {
            margin-left: var(--sidebar-w);
            padding: 2rem;
            min-height: 100vh;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--on-surface);
            margin: 0;
        }

        .page-header p {
            font-size: 14px;
            color: var(--on-surface-variant);
            margin: 0.25rem 0 0;
        }

        /* ── Cards ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 74, 198, 0.08);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            font-size: 16px;
            padding: 1rem 1.5rem;
        }

        .card-body { padding: 1.5rem; }

        /* ── Stat Cards ── */
        .stat-card {
            text-align: center;
            padding: 1.5rem;
        }

        .stat-card .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
        }

        .stat-card .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--on-surface-variant);
            text-transform: uppercase;
            letter-spacing: 0.02em;
            margin-top: 0.25rem;
        }

        /* ── Buttons ── */
        .btn-primary-custom {
            background: var(--primary);
            color: var(--on-primary);
            border: none;
            font-weight: 500;
            font-size: 14px;
            padding: 0.625rem 1.25rem;
            border-radius: 6px;
            transition: background 0.2s ease;
        }

        .btn-primary-custom:hover {
            background: var(--primary-light);
            color: var(--on-primary);
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
            font-weight: 500;
            font-size: 14px;
            padding: 0.625rem 1.25rem;
            border-radius: 6px;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .btn-outline-custom:hover {
            background: var(--primary-tint);
            color: var(--primary);
        }

        /* ── Forms ── */
        .form-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--on-surface-variant);
            margin-bottom: 0.375rem;
        }

        .form-control, .form-select {
            border: 1px solid var(--outline-variant);
            border-radius: 6px;
            font-size: 14px;
            padding: 0.625rem 0.875rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 74, 198, 0.1);
        }

        /* ── Tables ── */
        .table { font-size: 14px; }
        .table thead th {
            font-size: 12px;
            font-weight: 600;
            color: var(--on-surface-variant);
            text-transform: uppercase;
            letter-spacing: 0.02em;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
        }

        /* ── Badges ── */
        .badge-success-custom {
            background: var(--success-bg);
            color: var(--success-text);
            font-weight: 600;
            font-size: 11px;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
        }

        .badge-danger-custom {
            background: var(--danger-bg);
            color: var(--danger-text);
            font-weight: 600;
            font-size: 11px;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
        }

        .badge-warning-custom {
            background: var(--warning-bg);
            color: var(--warning-text);
            font-weight: 600;
            font-size: 11px;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
        }

        /* ── CF Slider ── */
        .cf-slider-group {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .cf-slider-group input[type="range"] {
            flex: 1;
            accent-color: var(--primary);
            height: 6px;
        }

        .cf-slider-value {
            min-width: 40px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
            color: var(--primary);
        }

        /* ── Alert ── */
        .alert { border-radius: 8px; font-size: 14px; }
        .alert-warning {
            background: var(--warning-bg);
            color: var(--warning-text);
            border-color: var(--warning-bg);
        }
        .alert-success {
            background: var(--success-bg);
            color: var(--success-text);
            border-color: var(--success-bg);
        }

        /* ── Pagination ── */
        .pagination .page-link {
            font-size: 14px;
            color: var(--primary);
            border-color: var(--border);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* ── Mobile Responsive ── */
        @media (max-width: 767.98px) {
            .mobile-topbar {
                display: flex;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
                padding-top: calc(56px + 1rem);
            }

            .page-header h1 {
                font-size: 20px;
            }

            .card-body { padding: 1rem; }
            .card-header { padding: 0.75rem 1rem; font-size: 14px; }

            .stat-card .stat-number { font-size: 22px; }
            .stat-card { padding: 1rem; }

            .btn-primary-custom, .btn-outline-custom {
                padding: 0.5rem 1rem;
                font-size: 13px;
            }

            /* Disable hover effect on mobile (touch) */
            .card:hover {
                transform: none;
                box-shadow: none;
            }

            /* Fix table horizontal scroll on mobile */
            .table-responsive { border: none; }

            /* Stack d-flex button groups on mobile */
            .d-flex.gap-1, .d-flex.gap-2 {
                flex-wrap: wrap;
            }
        }

        /* ── Print ── */
        @media print {
            .sidebar, .mobile-topbar, .sidebar-overlay { display: none !important; }
            .main-content { margin-left: 0; padding: 0; }
            .card:hover { transform: none; box-shadow: none; }
            .page-content { animation: none; }
        }
    </style>

    @stack('styles')
</head>
<body>
    @auth
    {{-- Mobile Topbar --}}
    <div class="mobile-topbar">
        <button class="btn-hamburger" id="sidebarToggle" aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>
        <span class="brand-text">SpekTi</span>
    </div>

    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Sidebar --}}
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h5>SpekTi</h5>
            <small>Sistem Prediksi 3,5 Tahun</small>
        </div>

        <nav class="sidebar-nav">
            @if(Auth::user()->role === 'mahasiswa')
                <div class="sidebar-section">Menu</div>
                <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>
                <a href="{{ route('mahasiswa.kuesioner') }}" class="nav-link {{ request()->routeIs('mahasiswa.kuesioner') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check"></i> Kuesioner
                </a>
                <a href="{{ route('mahasiswa.riwayat') }}" class="nav-link {{ request()->routeIs('mahasiswa.riwayat') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Riwayat
                </a>
            @endif

            @if(Auth::user()->role === 'admin')
                <div class="sidebar-section">Admin Prodi</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.variables.index') }}" class="nav-link {{ request()->routeIs('admin.variables.*') ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3-gap"></i> Variabel
                </a>
                <a href="{{ route('admin.rules.index') }}" class="nav-link {{ request()->routeIs('admin.rules.*') ? 'active' : '' }}">
                    <i class="bi bi-lightning"></i> Rules CF
                </a>
                <a href="{{ route('admin.revisions.index') }}" class="nav-link {{ request()->routeIs('admin.revisions.*') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square"></i> Revisi
                </a>
                <a href="{{ route('admin.mahasiswa.index') }}" class="nav-link {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Data Mahasiswa
                </a>
                <a href="{{ route('admin.prescreening') }}" class="nav-link {{ request()->routeIs('admin.prescreening') ? 'active' : '' }}">
                    <i class="bi bi-x-circle"></i> Ditolak Screening
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:32px;height:32px;border-radius:50%;background:var(--primary-tint);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-person-fill" style="color:var(--primary);font-size:14px;"></i>
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;">{{ Auth::user()->name }}</div>
                    <div style="font-size:11px;color:var(--outline);">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="d-grid">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-custom">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        @if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

        <div class="page-content">
            @yield('content')
        </div>
    </div>
    @else
        <div class="page-content">
            @yield('content')
        </div>
    @endauth

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        (function() {
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('sidebarOverlay');
            var toggle  = document.getElementById('sidebarToggle');

            if (!sidebar || !toggle) return;

            function openSidebar() {
                sidebar.classList.add('open');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            toggle.addEventListener('click', function() {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });

            overlay.addEventListener('click', closeSidebar);

            // Close on nav link click (mobile)
            sidebar.querySelectorAll('.nav-link').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) closeSidebar();
                });
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>
