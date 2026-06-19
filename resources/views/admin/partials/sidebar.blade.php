<!-- Admin Sidebar -->
<aside class="sidebar" id="sidebar" aria-label="Navigasi admin">
  <div class="sidebar-brand">
    <a href="{{ url('/') }}">
      <img src="{{ asset('assets/images/side-logo.png') }}" alt="Logo HMI Tour" style="max-width: 150px; height: auto;">
    </a>
  </div>

  <nav class="sidebar-nav">
    <div class="sidebar-nav-label">Utama</div>
    <ul>
      <li class="sidebar-nav-item">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <span class="nav-icon"><i data-lucide="layout-dashboard"></i></span>
          <span class="nav-text">Dashboard</span>
        </a>
      </li>
    </ul>

    <div class="sidebar-nav-label">Transaksi</div>
    <ul>
      <li class="sidebar-nav-item">
        <a href="{{ route('admin.bookings.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
          <span class="nav-icon"><i data-lucide="clipboard-list"></i></span>
          <span class="nav-text">Pesanan</span>
        </a>
      </li>
      <li class="sidebar-nav-item">
        <a href="{{ route('admin.payments.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
          <span class="nav-icon"><i data-lucide="credit-card"></i></span>
          <span class="nav-text">Pembayaran</span>
        </a>
      </li>
      <li class="sidebar-nav-item">
        <a href="{{ route('admin.invoice.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.invoice.*') ? 'active' : '' }}">
          <span class="nav-icon"><i data-lucide="receipt"></i></span>
          <span class="nav-text">Invoice</span>
        </a>
      </li>
    </ul>

    <div class="sidebar-nav-label">Produk & Layanan</div>
    <ul>
      <li class="sidebar-nav-item">
        <a href="{{ route('admin.packages.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
          <span class="nav-icon"><i data-lucide="package"></i></span>
          <span class="nav-text">Paket</span>
        </a>
      </li>
      <li class="sidebar-nav-item">
        <a href="{{ route('admin.destinations.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}">
          <span class="nav-icon"><i data-lucide="map-pin"></i></span>
          <span class="nav-text">Destinasi</span>
        </a>
      </li>
      <li class="sidebar-nav-item">
        <a href="{{ route('admin.hotels.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.hotels.*') ? 'active' : '' }}">
          <span class="nav-icon"><i data-lucide="building-2"></i></span>
          <span class="nav-text">Hotel</span>
        </a>
      </li>
    </ul>

    <div class="sidebar-nav-label">Konten</div>
    <ul>
      <li class="sidebar-nav-item">
        <a href="{{ route('admin.galleries.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
          <span class="nav-icon"><i data-lucide="image"></i></span>
          <span class="nav-text">Galeri</span>
        </a>
      </li>
    </ul>
  </nav>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}</div>
      <div class="sidebar-user-info">
        <div class="sidebar-user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
        <div class="sidebar-user-role">Administrator</div>
      </div>
    </div>
    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
      @csrf
      <button type="submit" class="sidebar-logout-btn" aria-label="Logout" style="display: flex; align-items: center; gap: 8px;">
        <i data-lucide="log-out" style="width: 18px; height: 18px;"></i><span>Logout</span>
      </button>
    </form>
  </div>
</aside>
