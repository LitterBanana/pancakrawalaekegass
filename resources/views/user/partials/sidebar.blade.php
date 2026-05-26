<!-- Sidebar -->
<aside class="sidebar" id="sidebar" aria-label="Navigasi utama">
  <div class="sidebar-brand">
    <div class="sidebar-brand-logo" aria-hidden="true">🕌</div>
    <div class="sidebar-brand-text">
      <span class="sidebar-brand-name">HMI Tour</span>
      <span class="sidebar-brand-sub">Payment System</span>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="sidebar-nav-label">Menu Utama</div>
    <ul>
      <li class="sidebar-nav-item">
        <a href="{{ route('user.dashboard') }}" class="sidebar-nav-link {{ request()->is('user/dashboard*') ? 'active' : '' }}" {{ request()->is('user/dashboard*') ? 'aria-current="page"' : '' }}>
          <span class="nav-icon">📊</span>
          <span class="nav-text">Dashboard</span>
        </a>
      </li>
      <li class="sidebar-nav-item">
        @if(session()->has('impersonate_user_id'))
        <div class="sidebar-nav-link" style="opacity: 0.6; cursor: not-allowed;" onclick="alert('Fitur pembayaran dikunci selama Anda melakukan akses dari Dashboard Admin.')">
          <span class="nav-icon" style="filter: grayscale(100%); opacity: 0.7;">🔒</span>
          <span class="nav-text">Bayar Sekarang</span>
        </div>
        @else
        <a href="{{ route('user.payment') }}" class="sidebar-nav-link {{ request()->is('user/payment*') ? 'active' : '' }}" {{ request()->is('user/payment*') ? 'aria-current="page"' : '' }}>
          <span class="nav-icon">💳</span>
          <span class="nav-text">Bayar Sekarang</span>
        </a>
        @endif
      </li>
      <li class="sidebar-nav-item">
        <a href="{{ route('user.invoices') }}" class="sidebar-nav-link {{ request()->is('user/invoices*') ? 'active' : '' }}" {{ request()->is('user/invoices*') ? 'aria-current="page"' : '' }}>
          <span class="nav-icon">📋</span>
          <span class="nav-text">Travel Invoices</span>
        </a>
      </li>
    </ul>

    <div class="sidebar-nav-label">Akun</div>
    <ul>
      <li class="sidebar-nav-item">
        <a href="{{ route('user.profile') }}" class="sidebar-nav-link {{ request()->is('user/profile*') ? 'active' : '' }}" {{ request()->is('user/profile*') ? 'aria-current="page"' : '' }}>
          <span class="nav-icon">👤</span>
          <span class="nav-text">Profil Saya</span>
        </a>
      </li>
    </ul>
  </nav>

  <div class="sidebar-footer">
    @php
      $sidebarUser = $user ?? Auth::user();
    @endphp
    <div class="sidebar-user">
      <div class="avatar">{{ strtoupper(substr($sidebarUser->name, 0, 2)) }}</div>
      <div class="sidebar-user-info">
        <div class="sidebar-user-name">{{ $sidebarUser->name }}</div>
        <div class="sidebar-user-role">{{ ucfirst($sidebarUser->role ?? 'Anggota') }}</div>
      </div>
    </div>
    
    @if(session()->has('impersonate_user_id'))
        <a href="{{ route('admin.stop.impersonating') }}" class="sidebar-logout-btn" style="color:#d97706; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:0.5rem; background:#fffbeb; border:1px solid #fde68a; font-weight:700;">
            <span>🔙</span><span>Kembali ke Admin</span>
        </a>
    @else
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
          @csrf
          <button type="submit" class="sidebar-logout-btn" aria-label="Logout">
            <span>🚪</span><span>Logout</span>
          </button>
        </form>
    @endif
  </div>
</aside>
