<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@yield('description', 'HMI Tour Admin Panel')">
  <title>@yield('title', 'HMI Tour Admin')</title>

  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  @stack('styles')

  <link rel="icon"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z'/><circle cx='12' cy='10' r='3'/></svg>">
</head>

<body>
  <div class="app-layout">

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Wrapper -->
    <div class="main-wrapper">
      <!-- Top Header -->
      <header class="top-header">
        <div class="header-left">
          <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Buka menu navigasi">
            <i data-lucide="menu"></i>
          </button>
          <div class="page-title-section">
            <h1>@yield('page_title', 'Dashboard')</h1>
            <p>@yield('page_subtitle', 'Panel Admin HMI Tour')</p>
          </div>
        </div>
        <div class="header-right">
          <div class="header-user-btn">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}</div>
            <span class="user-name-text">{{ explode(' ', Auth::user()->name ?? 'Admin')[0] }}</span>
          </div>
        </div>
      </header>

      <!-- Main Content -->
      <main class="main-content">
        @if(session('success'))
          <div class="card" style="background: var(--color-success-bg); border-color: var(--color-success-border); margin-bottom: var(--space-6);">
            <div class="card-body" style="padding: var(--space-4) var(--space-6); color: var(--color-success); font-weight: 600; display: flex; align-items: center; gap: 8px;">
              <i data-lucide="check-circle-2" style="width: 20px; height: 20px;"></i> {{ session('success') }}
            </div>
          </div>
        @endif
        @if($errors->any())
          <div class="card" style="background: var(--color-danger-bg); border-color: var(--color-danger-border); margin-bottom: var(--space-6);">
            <div class="card-body" style="padding: var(--space-4) var(--space-6); color: var(--color-danger);">
              <strong>Terjadi kesalahan:</strong>
              <ul style="margin: var(--space-2) 0 0; padding-left: var(--space-5);">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
              </ul>
            </div>
          </div>
        @endif

        @yield('content')
      </main>

      <!-- Footer -->
      <footer class="page-footer">
        <p>© {{ date('Y') }} HMI Tour Travel — Admin Panel</p>
      </footer>
    </div>
  </div>

  <!-- Sidebar mobile toggle script -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const menuBtn = document.getElementById('mobileMenuBtn');

    function openSidebar() {
      sidebar.classList.add('open');
      overlay.classList.add('active');
      overlay.style.pointerEvents = 'auto';
    }

    function closeSidebar() {
      sidebar.classList.remove('open');
      overlay.classList.remove('active');
      overlay.style.pointerEvents = 'none';
    }

    if (menuBtn) {
      menuBtn.addEventListener('click', () => {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
      });
    }

    if (overlay) {
      overlay.addEventListener('click', closeSidebar);
    }

    // Close sidebar when clicking a nav link on mobile
    document.querySelectorAll('.sidebar-nav-link').forEach(link => {
      link.addEventListener('click', () => {
        if (window.innerWidth < 768) closeSidebar();
      });
    });

    // Initialize Lucide Icons
    lucide.createIcons();
  </script>
  @stack('scripts')
</body>

</html>