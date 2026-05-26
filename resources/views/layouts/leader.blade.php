<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Leader') &mdash; HMI Tour Travel</title>
    <meta name="description" content="@yield('description', 'Sistem Manajemen Leader HMI Tour Travel')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'fi': {
                            'primary': '#8B1A1A',
                            'primary-hover': '#6B1010',
                            'primary-50': '#fef2f2',
                            'primary-100': '#fee2e2',
                            'primary-200': '#fecaca',
                            'surface': '#ffffff',
                            'border': '#e5e7eb',
                            'bg': '#f9fafb',
                            'text-main': '#111827',
                            'text-muted': '#6b7280',
                            'text-secondary': '#4b5563',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* ── CSS Custom Properties (Design System) ── */
        :root {
            --color-fi-primary: #8B1A1A;
            --color-fi-primary-hover: #6B1010;
            --color-fi-primary-50: #fef2f2;
            --color-fi-primary-100: #fee2e2;
            --color-fi-primary-200: #fecaca;
            --color-fi-surface: #ffffff;
            --color-fi-border: #e5e7eb;
            --color-fi-bg: #f9fafb;
            --color-fi-text-main: #111827;
            --color-fi-text-muted: #6b7280;
            --color-fi-text-secondary: #4b5563;

            --sidebar-width: 260px;
            --header-height: 64px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--color-fi-bg);
            color: var(--color-fi-text-main);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--color-fi-surface);
            border-right: 1px solid var(--color-fi-border);
            z-index: 40;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--color-fi-border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            background: var(--color-fi-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            font-weight: 700;
            font-size: 1rem;
            color: var(--color-fi-primary);
            line-height: 1.2;
        }

        .sidebar-brand-sub {
            font-size: 0.7rem;
            color: var(--color-fi-text-muted);
            font-weight: 400;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0.75rem;
            overflow-y: auto;
        }

        .sidebar-section-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--color-fi-text-muted);
            padding: 0.5rem 0.75rem;
            margin-top: 0.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--color-fi-text-secondary);
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 2px;
        }

        .sidebar-link:hover {
            background: var(--color-fi-bg);
            color: var(--color-fi-text-main);
        }

        .sidebar-link.active {
            background: var(--color-fi-primary-50);
            color: var(--color-fi-primary);
            font-weight: 600;
        }

        .sidebar-link-icon {
            width: 20px;
            text-align: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 1rem 1rem;
            border-top: 1px solid var(--color-fi-border);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: 0.5rem;
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--color-fi-primary-100);
            color: var(--color-fi-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .sidebar-user-info {
            min-width: 0;
        }

        .sidebar-user-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--color-fi-text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 0.7rem;
            color: var(--color-fi-text-muted);
        }

        /* ── Main Content ── */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Top Header ── */
        .top-header {
            height: var(--header-height);
            background: var(--color-fi-surface);
            border-bottom: 1px solid var(--color-fi-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .header-left h1 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--color-fi-text-main);
            margin: 0;
        }

        .header-left p {
            font-size: 0.8rem;
            color: var(--color-fi-text-muted);
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--color-fi-text-muted);
            background: transparent;
            border: 1px solid var(--color-fi-border);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .btn-logout:hover {
            background: var(--color-fi-primary-50);
            color: var(--color-fi-primary);
            border-color: var(--color-fi-primary-200);
        }

        /* ── Content Area ── */
        .main-content {
            flex: 1;
            padding: 1.5rem;
            max-width: 1400px;
            width: 100%;
        }

        /* ── Mobile Toggle ── */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            color: var(--color-fi-text-main);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 35;
        }

        /* ── Animations ── */
        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .delay-2 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .delay-3 {
            animation-delay: 0.3s;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.open {
                display: block;
            }

            .sidebar-toggle {
                display: block;
            }

            .main-wrapper {
                margin-left: 0;
            }
        }

        /* ── Flash Message ── */
        .flash-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .flash-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ── Shared Card / Table / Button Components ── */
        .card {
            background: var(--color-fi-surface, #ffffff);
            border-radius: 0.75rem;
            border: 1px solid var(--color-fi-border, #e5e7eb);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--color-fi-border, #e5e7eb);
        }

        .card-body {
            padding: 1.5rem;
        }

        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: var(--color-fi-bg, #f9fafb);
        }

        .data-table th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--color-fi-text-muted, #6b7280);
            border-bottom: 1px solid var(--color-fi-border, #e5e7eb);
        }

        .data-table td {
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
            color: var(--color-fi-text-secondary, #4b5563);
            border-bottom: 1px solid var(--color-fi-border, #e5e7eb);
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: var(--color-fi-bg, #f9fafb);
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 600;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            border: 1px solid transparent;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            line-height: 1.5;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 0.375rem 0.75rem;
        }

        .btn-primary {
            background: var(--color-fi-primary, #8B1A1A);
            color: white;
            border-color: var(--color-fi-primary, #8B1A1A);
        }

        .btn-primary:hover {
            background: var(--color-fi-primary-hover, #6B1010);
        }

        .btn-ghost {
            background: transparent;
            color: var(--color-fi-text-muted, #6b7280);
            border-color: var(--color-fi-border, #e5e7eb);
        }

        .btn-ghost:hover {
            background: var(--color-fi-bg, #f9fafb);
            color: var(--color-fi-text-main, #111827);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-info {
            background: #eff6ff;
            color: #1e40af;
        }

        .badge-success {
            background: #ecfdf5;
            color: #065f46;
        }

        .badge-warning {
            background: #fffbeb;
            color: #92400e;
        }

        .badge-danger {
            background: #fef2f2;
            color: #991b1b;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/side-logo.png') }}" alt="Logo HMI Tour" style="max-width: 150px; height: auto;">
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Menu Utama</div>

            <a href="{{ route('leader.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('leader.dashboard') ? 'active' : '' }}">
                <span class="sidebar-link-icon">🏠</span>
                Dashboard
            </a>

            <a href="{{ route('leader.members.index') }}"
                class="sidebar-link {{ request()->routeIs('leader.members.*') ? 'active' : '' }}">
                <span class="sidebar-link-icon">👥</span>
                Anggota Tim
            </a>

            <a href="{{ route('leader.reports.index') }}"
                class="sidebar-link {{ request()->routeIs('leader.reports.index') ? 'active' : '' }}">
                <span class="sidebar-link-icon">📊</span>
                Laporan Penjualan
            </a>

            <a href="{{ route('leader.reports.crud') }}"
                class="sidebar-link {{ request()->routeIs('leader.reports.crud') ? 'active' : '' }}">
                <span class="sidebar-link-icon">📈</span>
                Analitik
            </a>

            <a href="{{ route('leader.invoices.index') }}"
                class="sidebar-link {{ request()->routeIs('leader.invoices.*') ? 'active' : '' }}">
                <span class="sidebar-link-icon">🧾</span>
                Invoice Downline
            </a>


            <div class="sidebar-section-label">Akun</div>

            <a href="{{ route('leader.profile') }}"
                class="sidebar-link {{ request()->routeIs('leader.profile') ? 'active' : '' }}">
                <span class="sidebar-link-icon">👤</span>
                Profil Saya
            </a>

        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">Leader</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="sidebar-link" style="border:none;background:none;cursor:pointer;font:inherit;width:100%;margin-top:0.5rem;">
                    <span class="sidebar-link-icon">🚪</span>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left" style="display:flex;align-items:center;gap:0.75rem;">
                <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
                <div>
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <p>@yield('page-description', '')</p>
                </div>
            </div>
            <div class="header-right">
                @if(Auth::user()->referral_code)
                    <div
                        style="font-size:0.75rem;background:var(--color-fi-primary-50);color:var(--color-fi-primary);padding:0.375rem 0.75rem;border-radius:0.375rem;font-weight:600;font-family:monospace;">
                        🔗 {{ Auth::user()->referral_code }}
                    </div>
                @endif
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            @if(session('success'))
                <div class="flash-success">✅ {{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="flash-error">❌ {{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('open');
        }
    </script>
</body>

</html>
