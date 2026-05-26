<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@yield('description', 'HMI Tour Admin Panel')">
  <title>@yield('title', 'HMI Tour Admin')</title>

  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
  @stack('styles')

  <link rel="icon"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🕌</text></svg>">
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
            ☰
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
            <div class="card-body" style="padding: var(--space-4) var(--space-6); color: var(--color-success); font-weight: 600;">
              ✅ {{ session('success') }}
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
  </script>
  @stack('scripts')
</body>

</html>