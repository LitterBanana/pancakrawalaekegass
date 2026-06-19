<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@yield('description', 'Login ke sistem HMI Tour Travel - Record Pembayaran Tour')">
  <title>@yield('title', 'Login — HMI Tour Travel')</title>

  <style>
    /* ===== variables.css ===== */
    :root {
      --color-primary: #8B1A1A; --color-primary-light: #A83232; --color-primary-lighter: #C75050; --color-primary-dark: #6B1010; --color-primary-darker: #4A0B0B;
      --color-primary-50: #FEF2F2; --color-primary-100: #FDE8E8; --color-primary-200: #FACACB; --color-primary-300: #F5A3A5; --color-primary-400: #E06B6E; --color-primary-500: #C53030; --color-primary-600: #8B1A1A; --color-primary-700: #6B1010; --color-primary-800: #4A0B0B; --color-primary-900: #300707;
      --color-primary-gradient: linear-gradient(135deg, #8B1A1A 0%, #C53030 100%); --color-primary-gradient-reverse: linear-gradient(135deg, #C53030 0%, #8B1A1A 100%);
      --color-white: #FFFFFF; --color-bg: #F7F8FA; --color-bg-alt: #F0F2F5; --color-surface: #FFFFFF; --color-surface-hover: #FAFBFC; --color-border: #E5E7EB; --color-border-light: #F3F4F6; --color-divider: #E2E8F0;
      --color-text: #1A1A2E; --color-text-secondary: #6B7280; --color-text-muted: #9CA3AF; --color-text-inverse: #FFFFFF; --color-text-link: #8B1A1A;
      --color-success: #059669; --color-success-light: #10B981; --color-success-bg: #ECFDF5; --color-success-border: #A7F3D0;
      --color-warning: #D97706; --color-warning-light: #F59E0B; --color-warning-bg: #FFFBEB; --color-warning-border: #FDE68A;
      --color-danger: #DC2626; --color-danger-light: #EF4444; --color-danger-bg: #FEF2F2; --color-danger-border: #FECACA;
      --color-info: #2563EB; --color-info-light: #3B82F6; --color-info-bg: #EFF6FF; --color-info-border: #BFDBFE;
      --font-heading: 'Montserrat', sans-serif; --font-body: 'Poppins', sans-serif;
      --text-xs: 0.75rem; --text-sm: 0.875rem; --text-base: 1rem; --text-lg: 1.125rem; --text-xl: 1.25rem; --text-2xl: 1.5rem; --text-3xl: 1.875rem; --text-4xl: 2.25rem; --text-5xl: 3rem;
      --leading-tight: 1.25; --leading-normal: 1.5; --leading-relaxed: 1.75;
      --font-light: 300; --font-normal: 400; --font-medium: 500; --font-semibold: 600; --font-bold: 700; --font-extrabold: 800;
      --space-0: 0; --space-1: 0.25rem; --space-2: 0.5rem; --space-3: 0.75rem; --space-4: 1rem; --space-5: 1.25rem; --space-6: 1.5rem; --space-8: 2rem; --space-10: 2.5rem; --space-12: 3rem; --space-16: 4rem; --space-20: 5rem; --space-24: 6rem;
      --radius-sm: 0.375rem; --radius-md: 0.5rem; --radius-lg: 0.75rem; --radius-xl: 1rem; --radius-2xl: 1.5rem; --radius-3xl: 2rem; --radius-full: 9999px;
      --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.04); --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04); --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.05); --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.04); --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.04); --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.15); --shadow-primary: 0 4px 14px rgba(139, 26, 26, 0.25); --shadow-primary-lg: 0 10px 30px rgba(139, 26, 26, 0.3);
      --transition-fast: all 0.15s ease; --transition-base: all 0.3s ease; --transition-slow: all 0.5s ease; --transition-bounce: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      --sidebar-width: 280px; --sidebar-collapsed: 80px; --header-height: 72px; --max-width: 1200px; --content-max-width: 900px;
      --z-dropdown: 100; --z-sticky: 200; --z-fixed: 300; --z-overlay: 400; --z-modal: 500; --z-toast: 600;
    }
    /* ===== base.css ===== */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap');
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; font-size: 16px; height: 100%; }
    body { font-family: var(--font-body); font-size: var(--text-base); font-weight: var(--font-normal); color: var(--color-text); background-color: var(--color-bg); line-height: var(--leading-normal); min-height: 100vh; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; }
    h1, h2, h3, h4, h5, h6 { font-family: var(--font-heading); font-weight: var(--font-bold); line-height: var(--leading-tight); color: var(--color-text); margin-bottom: var(--space-2); }
    h1 { font-size: var(--text-4xl); } h2 { font-size: var(--text-3xl); } h3 { font-size: var(--text-2xl); } h4 { font-size: var(--text-xl); } h5 { font-size: var(--text-lg); } h6 { font-size: var(--text-base); }
    p { margin-bottom: var(--space-4); color: var(--color-text-secondary); line-height: var(--leading-relaxed); }
    a { text-decoration: none; color: var(--color-primary); transition: var(--transition-base); }
    a:hover { color: var(--color-primary-dark); }
    img { max-width: 100%; height: auto; display: block; }
    ul, ol { list-style: none; }
    input, select, textarea, button { font-family: inherit; font-size: inherit; line-height: inherit; color: inherit; }
    button { cursor: pointer; border: none; background: none; }
    input:focus, select:focus, textarea:focus { outline: none; }
    .hidden { display: none !important; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes scaleIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .animate-fade-in { animation: fadeIn 0.4s ease forwards; }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease forwards; }
    .delay-1 { animation-delay: 0.1s; opacity: 0; } .delay-2 { animation-delay: 0.2s; opacity: 0; } .delay-3 { animation-delay: 0.3s; opacity: 0; } .delay-4 { animation-delay: 0.4s; opacity: 0; } .delay-5 { animation-delay: 0.5s; opacity: 0; }
    /* ===== components.css (minimal for login) ===== */
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: var(--space-2); padding: var(--space-3) var(--space-6); font-family: var(--font-body); font-size: var(--text-sm); font-weight: var(--font-semibold); line-height: 1.5; border: 2px solid transparent; border-radius: var(--radius-xl); cursor: pointer; transition: var(--transition-base); text-decoration: none; white-space: nowrap; user-select: none; }
    .btn-primary { background: var(--color-primary); color: var(--color-white); box-shadow: var(--shadow-primary); }
    .btn-primary:hover { background: var(--color-primary-dark); box-shadow: var(--shadow-primary-lg); transform: translateY(-1px); color: var(--color-white); }
    .btn-full { width: 100%; }
    .form-group { margin-bottom: var(--space-5); }
    .form-label { display: block; font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-text); margin-bottom: var(--space-2); }
    .form-input { width: 100%; padding: var(--space-3) var(--space-4); font-size: var(--text-sm); color: var(--color-text); background: var(--color-white); border: 1.5px solid var(--color-border); border-radius: var(--radius-xl); transition: var(--transition-base); appearance: none; }
    .form-input:hover { border-color: var(--color-primary-300); }
    .form-input:focus { border-color: var(--color-primary); box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.1); }
    .form-input::placeholder { color: var(--color-text-muted); }
    .input-group { position: relative; }
    /* ===== login.css ===== */
    .login-wrapper { display: flex; min-height: 100vh; }
    .login-hero { flex: 1; display: flex; flex-direction: column; justify-content: flex-end; align-items: center; position: relative; overflow: hidden; }
    .login-hero-photo { padding: 0; background: #0a1628; }
    .login-hero-img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; }
    .login-hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(10, 22, 40, 0.92) 0%, rgba(10, 22, 40, 0.55) 40%, rgba(10, 22, 40, 0.15) 70%, rgba(10, 22, 40, 0.05) 100%); display: flex; flex-direction: column; justify-content: flex-end; align-items: center; padding: var(--space-12); z-index: 1; }
    .login-hero-overlay-content { text-align: center; max-width: 420px; }
    .login-hero-logo { width: 72px; height: 72px; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-radius: var(--radius-2xl); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-5); font-size: var(--text-3xl); color: var(--color-white); font-weight: var(--font-extrabold); font-family: var(--font-heading); border: 1px solid rgba(255, 255, 255, 0.25); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2); }
    .login-hero h1 { font-size: var(--text-3xl); font-weight: var(--font-extrabold); color: var(--color-white); margin-bottom: var(--space-3); line-height: 1.2; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); }
    .login-hero p { font-size: var(--text-base); color: rgba(255, 255, 255, 0.85); line-height: var(--leading-relaxed); margin-bottom: 0; text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2); }
    .login-form-side { flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: var(--space-8); background: var(--color-white); max-width: 560px; }
    .login-form-container { width: 100%; max-width: 400px; }
    .login-mobile-logo { display: none; text-align: center; margin-bottom: var(--space-8); }
    .login-mobile-logo .logo-icon { width: 56px; height: 56px; background: var(--color-primary-gradient); border-radius: var(--radius-xl); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-3); font-size: var(--text-xl); color: var(--color-white); font-weight: var(--font-extrabold); font-family: var(--font-heading); }
    .login-mobile-logo h2 { font-size: var(--text-lg); color: var(--color-text); }
    .login-form-header { margin-bottom: var(--space-8); }
    .login-form-header h2 { font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-text); margin-bottom: var(--space-2); }
    .login-form-header p { font-size: var(--text-base); color: var(--color-text-secondary); }
    .login-form .form-group { margin-bottom: var(--space-5); }
    .login-form .form-input { padding: var(--space-4); border-radius: var(--radius-xl); }
    .password-toggle { position: absolute; right: var(--space-4); top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--color-text-muted); cursor: pointer; padding: var(--space-1); transition: var(--transition-fast); font-size: var(--text-lg); }
    .password-toggle:hover { color: var(--color-text); }
    .login-form-options { display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-6); }
    .remember-me { display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm); color: var(--color-text-secondary); cursor: pointer; }
    .remember-me input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--color-primary); }
    .forgot-password { font-size: var(--text-sm); color: var(--color-primary); font-weight: var(--font-medium); }
    .forgot-password:hover { color: var(--color-primary-dark); text-decoration: underline; }
    .login-btn { padding: var(--space-4); font-size: var(--text-base); border-radius: var(--radius-xl); }
    .login-error { padding: var(--space-3) var(--space-4); background: var(--color-danger-bg); border: 1px solid var(--color-danger-border); border-radius: var(--radius-lg); margin-bottom: var(--space-4); display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm); color: var(--color-danger); animation: fadeIn 0.3s ease; }
    .login-form-footer { margin-top: var(--space-8); text-align: center; }
    .login-form-footer p { font-size: var(--text-sm); color: var(--color-text-muted); }
    .demo-credentials { margin-top: var(--space-6); padding: var(--space-4); background: var(--color-info-bg); border: 1px solid var(--color-info-border); border-radius: var(--radius-xl); }
    .demo-credentials p { font-size: var(--text-xs); color: var(--color-info); margin-bottom: var(--space-2); font-weight: var(--font-semibold); }
    .demo-credentials code { font-size: var(--text-xs); color: var(--color-text-secondary); display: block; line-height: 1.8; }
    /* ===== responsive (login) ===== */
    @media (max-width: 768px) {
      .login-hero { display: none; }
      .login-form-side { max-width: 100%; padding: var(--space-6); }
      .login-mobile-logo { display: block; }
      .login-form-header h2 { font-size: var(--text-2xl); }
    }
  </style>

  <!-- Favicon -->
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🕌</text></svg>">
</head>
<body>

  <div class="login-wrapper">
    <!-- Hero Side - Photo -->
    <section class="login-hero login-hero-photo" aria-label="Foto HMI Tour Travel">
      <img src="{{ asset('img/Umroh bareng ibu dan zahro.jpeg') }}" alt="Umroh bersama HMI Tour Travel" class="login-hero-img">
      <div class="login-hero-overlay">
        <div class="login-hero-overlay-content">

          <h1>Hijrah Madani Istiqomah Tour Travel</h1>
          <p>Perjalanan ibadah yang penuh berkah bersama HMI Tour Travel</p>
        </div>
      </div>
    </section>

    <!-- Form Side -->
    <section class="login-form-side" aria-label="Form Login">
      <div class="login-form-container">
        @yield('content')
      </div>
    </section>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('assets/js/utils.js') }}"></script>
</body>
</html>
