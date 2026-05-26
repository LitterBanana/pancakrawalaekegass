<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@yield('description', 'HMI Tour Travel')">
  <title>@yield('title', 'HMI Tour Travel')</title>

  <style>
    /* ===== variables.css ===== */
    :root {
      --color-primary: #8B1A1A;
      --color-primary-light: #A83232;
      --color-primary-lighter: #C75050;
      --color-primary-dark: #6B1010;
      --color-primary-darker: #4A0B0B;
      --color-primary-50: #FEF2F2;
      --color-primary-100: #FDE8E8;
      --color-primary-200: #FACACB;
      --color-primary-300: #F5A3A5;
      --color-primary-400: #E06B6E;
      --color-primary-500: #C53030;
      --color-primary-600: #8B1A1A;
      --color-primary-700: #6B1010;
      --color-primary-800: #4A0B0B;
      --color-primary-900: #300707;
      --color-primary-gradient: linear-gradient(135deg, #8B1A1A 0%, #C53030 100%);
      --color-primary-gradient-reverse: linear-gradient(135deg, #C53030 0%, #8B1A1A 100%);
      --color-white: #FFFFFF;
      --color-bg: #F7F8FA;
      --color-bg-alt: #F0F2F5;
      --color-surface: #FFFFFF;
      --color-surface-hover: #FAFBFC;
      --color-border: #E5E7EB;
      --color-border-light: #F3F4F6;
      --color-divider: #E2E8F0;
      --color-text: #1A1A2E;
      --color-text-secondary: #6B7280;
      --color-text-muted: #9CA3AF;
      --color-text-inverse: #FFFFFF;
      --color-text-link: #8B1A1A;
      --color-success: #059669;
      --color-success-light: #10B981;
      --color-success-bg: #ECFDF5;
      --color-success-border: #A7F3D0;
      --color-warning: #D97706;
      --color-warning-light: #F59E0B;
      --color-warning-bg: #FFFBEB;
      --color-warning-border: #FDE68A;
      --color-danger: #DC2626;
      --color-danger-light: #EF4444;
      --color-danger-bg: #FEF2F2;
      --color-danger-border: #FECACA;
      --color-info: #2563EB;
      --color-info-light: #3B82F6;
      --color-info-bg: #EFF6FF;
      --color-info-border: #BFDBFE;
      --font-heading: 'Montserrat', sans-serif;
      --font-body: 'Poppins', sans-serif;
      --text-xs: 0.75rem;
      --text-sm: 0.875rem;
      --text-base: 1rem;
      --text-lg: 1.125rem;
      --text-xl: 1.25rem;
      --text-2xl: 1.5rem;
      --text-3xl: 1.875rem;
      --text-4xl: 2.25rem;
      --text-5xl: 3rem;
      --leading-tight: 1.25;
      --leading-normal: 1.5;
      --leading-relaxed: 1.75;
      --font-light: 300;
      --font-normal: 400;
      --font-medium: 500;
      --font-semibold: 600;
      --font-bold: 700;
      --font-extrabold: 800;
      --space-0: 0;
      --space-1: 0.25rem;
      --space-2: 0.5rem;
      --space-3: 0.75rem;
      --space-4: 1rem;
      --space-5: 1.25rem;
      --space-6: 1.5rem;
      --space-8: 2rem;
      --space-10: 2.5rem;
      --space-12: 3rem;
      --space-16: 4rem;
      --space-20: 5rem;
      --space-24: 6rem;
      --radius-sm: 0.375rem;
      --radius-md: 0.5rem;
      --radius-lg: 0.75rem;
      --radius-xl: 1rem;
      --radius-2xl: 1.5rem;
      --radius-3xl: 2rem;
      --radius-full: 9999px;
      --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.04);
      --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.04);
      --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
      --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      --shadow-primary: 0 4px 14px rgba(139, 26, 26, 0.25);
      --shadow-primary-lg: 0 10px 30px rgba(139, 26, 26, 0.3);
      --transition-fast: all 0.15s ease;
      --transition-base: all 0.3s ease;
      --transition-slow: all 0.5s ease;
      --transition-bounce: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      --sidebar-width: 280px;
      --sidebar-collapsed: 80px;
      --header-height: 72px;
      --max-width: 1200px;
      --content-max-width: 900px;
      --z-dropdown: 100;
      --z-sticky: 200;
      --z-fixed: 300;
      --z-overlay: 400;
      --z-modal: 500;
      --z-toast: 600;
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
    a:focus-visible { outline: 2px solid var(--color-primary); outline-offset: 2px; border-radius: var(--radius-sm); }
    img { max-width: 100%; height: auto; display: block; }
    ul, ol { list-style: none; }
    input, select, textarea, button { font-family: inherit; font-size: inherit; line-height: inherit; color: inherit; }
    button { cursor: pointer; border: none; background: none; }
    input:focus, select:focus, textarea:focus { outline: none; }
    table { border-collapse: collapse; width: 100%; }
    ::selection { background-color: var(--color-primary); color: var(--color-white); }
    ::-moz-selection { background-color: var(--color-primary); color: var(--color-white); }
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--color-primary-300); border-radius: var(--radius-full); }
    ::-webkit-scrollbar-thumb:hover { background: var(--color-primary); }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }
    .text-center { text-align: center; } .text-right { text-align: right; } .text-left { text-align: left; }
    .font-medium { font-weight: var(--font-medium); } .font-semibold { font-weight: var(--font-semibold); } .font-bold { font-weight: var(--font-bold); }
    .text-primary { color: var(--color-primary); } .text-success { color: var(--color-success); } .text-warning { color: var(--color-warning); } .text-danger { color: var(--color-danger); } .text-muted { color: var(--color-text-muted); } .text-secondary { color: var(--color-text-secondary); }
    .mb-0 { margin-bottom: 0; } .mb-2 { margin-bottom: var(--space-2); } .mb-4 { margin-bottom: var(--space-4); } .mb-6 { margin-bottom: var(--space-6); } .mb-8 { margin-bottom: var(--space-8); }
    .mt-4 { margin-top: var(--space-4); } .mt-6 { margin-top: var(--space-6); }
    .hidden { display: none !important; } .visible { display: block !important; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInLeft { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes fadeInRight { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes scaleIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    @keyframes slideInRight { from { transform: translateX(100%); } to { transform: translateX(0); } }
    @keyframes slideOutRight { from { transform: translateX(0); } to { transform: translateX(100%); } }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes progressBar { from { width: 0; } }
    @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    .animate-fade-in { animation: fadeIn 0.4s ease forwards; }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease forwards; }
    .animate-scale-in { animation: scaleIn 0.3s ease forwards; }
    .delay-1 { animation-delay: 0.1s; opacity: 0; } .delay-2 { animation-delay: 0.2s; opacity: 0; } .delay-3 { animation-delay: 0.3s; opacity: 0; } .delay-4 { animation-delay: 0.4s; opacity: 0; } .delay-5 { animation-delay: 0.5s; opacity: 0; }

    /* ===== components.css ===== */
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: var(--space-2); padding: var(--space-3) var(--space-6); font-family: var(--font-body); font-size: var(--text-sm); font-weight: var(--font-semibold); line-height: 1.5; border: 2px solid transparent; border-radius: var(--radius-xl); cursor: pointer; transition: var(--transition-base); text-decoration: none; white-space: nowrap; user-select: none; position: relative; overflow: hidden; }
    .btn:focus-visible { outline: 2px solid var(--color-primary); outline-offset: 2px; }
    .btn:active { transform: scale(0.97); }
    .btn-primary { background: var(--color-primary); color: var(--color-white); box-shadow: var(--shadow-primary); }
    .btn-primary:hover { background: var(--color-primary-dark); box-shadow: var(--shadow-primary-lg); transform: translateY(-1px); color: var(--color-white); }
    .btn-primary:active { transform: translateY(0) scale(0.97); }
    .btn-secondary { background: var(--color-white); color: var(--color-primary); border-color: var(--color-primary); }
    .btn-secondary:hover { background: var(--color-primary-50); color: var(--color-primary-dark); transform: translateY(-1px); }
    .btn-ghost { background: transparent; color: var(--color-text-secondary); }
    .btn-ghost:hover { background: var(--color-bg-alt); color: var(--color-text); }
    .btn-danger { background: var(--color-danger); color: var(--color-white); }
    .btn-danger:hover { background: var(--color-danger-light); transform: translateY(-1px); }
    .btn-success { background: var(--color-success); color: var(--color-white); }
    .btn-success:hover { background: var(--color-success-light); transform: translateY(-1px); }
    .btn-lg { padding: var(--space-4) var(--space-8); font-size: var(--text-base); border-radius: var(--radius-2xl); }
    .btn-sm { padding: var(--space-2) var(--space-4); font-size: var(--text-xs); }
    .btn-full { width: 100%; }
    .btn-icon { width: 40px; height: 40px; padding: 0; border-radius: var(--radius-lg); }
    .btn-icon.btn-sm { width: 32px; height: 32px; }
    .btn .btn-spinner { width: 18px; height: 18px; border: 2px solid transparent; border-top-color: currentColor; border-radius: 50%; animation: spin 0.6s linear infinite; }
    .btn:disabled, .btn.disabled { opacity: 0.5; cursor: not-allowed; pointer-events: none; }
    .card { background: var(--color-surface); border-radius: var(--radius-2xl); border: 1px solid var(--color-border-light); box-shadow: var(--shadow-sm); transition: var(--transition-base); overflow: hidden; }
    .card:hover { box-shadow: var(--shadow-md); }
    .card-elevated { box-shadow: var(--shadow-md); }
    .card-elevated:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
    .card-header { padding: var(--space-6); border-bottom: 1px solid var(--color-border-light); display: flex; align-items: center; justify-content: space-between; gap: var(--space-4); }
    .card-body { padding: var(--space-6); }
    .card-footer { padding: var(--space-4) var(--space-6); border-top: 1px solid var(--color-border-light); background: var(--color-bg); }
    .form-group { margin-bottom: var(--space-5); }
    .form-label { display: block; font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-text); margin-bottom: var(--space-2); }
    .form-label .required { color: var(--color-danger); margin-left: 2px; }
    .form-hint { font-size: var(--text-xs); color: var(--color-text-muted); margin-top: var(--space-1); }
    .form-input, .form-select, .form-textarea { width: 100%; padding: var(--space-3) var(--space-4); font-size: var(--text-sm); color: var(--color-text); background: var(--color-white); border: 1.5px solid var(--color-border); border-radius: var(--radius-xl); transition: var(--transition-base); appearance: none; }
    .form-input:hover, .form-select:hover, .form-textarea:hover { border-color: var(--color-primary-300); }
    .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--color-primary); box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.1); }
    .form-input::placeholder { color: var(--color-text-muted); }
    .form-input.error, .form-select.error { border-color: var(--color-danger); box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1); }
    .form-error { font-size: var(--text-xs); color: var(--color-danger); margin-top: var(--space-1); display: flex; align-items: center; gap: var(--space-1); }
    .form-input:disabled, .form-input[readonly] { background: var(--color-bg-alt); color: var(--color-text-secondary); cursor: not-allowed; }
    .form-select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right var(--space-4) center; padding-right: var(--space-10); }
    .form-textarea { min-height: 100px; resize: vertical; }
    .input-group { position: relative; }
    .input-group .input-prefix { position: absolute; left: var(--space-4); top: 50%; transform: translateY(-50%); color: var(--color-text-muted); font-size: var(--text-sm); font-weight: var(--font-medium); pointer-events: none; }
    .input-group .form-input.has-prefix { padding-left: var(--space-10); }
    .input-group .input-icon { position: absolute; right: var(--space-4); top: 50%; transform: translateY(-50%); color: var(--color-text-muted); pointer-events: none; }
    .radio-group { display: flex; gap: var(--space-4); flex-wrap: wrap; }
    .radio-card { flex: 1; min-width: 140px; position: relative; }
    .radio-card input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    .radio-card-label { display: flex; flex-direction: column; align-items: center; gap: var(--space-2); padding: var(--space-4) var(--space-5); background: var(--color-white); border: 2px solid var(--color-border); border-radius: var(--radius-xl); cursor: pointer; transition: var(--transition-base); text-align: center; }
    .radio-card-label:hover { border-color: var(--color-primary-300); background: var(--color-primary-50); }
    .radio-card input[type="radio"]:checked+.radio-card-label { border-color: var(--color-primary); background: var(--color-primary-50); box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.1); }
    .radio-card-label .radio-icon { font-size: var(--text-2xl); width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: var(--color-bg-alt); border-radius: var(--radius-lg); transition: var(--transition-base); }
    .radio-card input[type="radio"]:checked+.radio-card-label .radio-icon { background: var(--color-primary); color: var(--color-white); }
    .radio-card-label .radio-text { font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-text); }
    .radio-card-label .radio-desc { font-size: var(--text-xs); color: var(--color-text-muted); }
    .badge { display: inline-flex; align-items: center; gap: var(--space-1); padding: var(--space-1) var(--space-3); font-size: var(--text-xs); font-weight: var(--font-semibold); border-radius: var(--radius-full); white-space: nowrap; }
    .badge-success { background: var(--color-success-bg); color: var(--color-success); border: 1px solid var(--color-success-border); }
    .badge-warning { background: var(--color-warning-bg); color: var(--color-warning); border: 1px solid var(--color-warning-border); }
    .badge-danger { background: var(--color-danger-bg); color: var(--color-danger); border: 1px solid var(--color-danger-border); }
    .badge-info { background: var(--color-info-bg); color: var(--color-info); border: 1px solid var(--color-info-border); }
    .badge-neutral { background: var(--color-bg-alt); color: var(--color-text-secondary); border: 1px solid var(--color-border); }
    .badge-dot::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .stat-card { background: var(--color-surface); border-radius: var(--radius-2xl); padding: var(--space-6); border: 1px solid var(--color-border-light); box-shadow: var(--shadow-sm); transition: var(--transition-base); position: relative; overflow: hidden; }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--color-primary-gradient); opacity: 0; transition: var(--transition-base); }
    .stat-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
    .stat-card:hover::before { opacity: 1; }
    .stat-card-icon { width: 48px; height: 48px; border-radius: var(--radius-xl); display: flex; align-items: center; justify-content: center; font-size: var(--text-xl); margin-bottom: var(--space-4); }
    .stat-card-icon.primary { background: var(--color-primary-50); color: var(--color-primary); }
    .stat-card-icon.success { background: var(--color-success-bg); color: var(--color-success); }
    .stat-card-icon.warning { background: var(--color-warning-bg); color: var(--color-warning); }
    .stat-card-icon.info { background: var(--color-info-bg); color: var(--color-info); }
    .stat-card-label { font-size: var(--text-sm); color: var(--color-text-secondary); margin-bottom: var(--space-1); }
    .stat-card-value { font-family: var(--font-heading); font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-text); }
    .stat-card-change { font-size: var(--text-xs); margin-top: var(--space-2); display: flex; align-items: center; gap: var(--space-1); }
    .modal-overlay { position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: var(--z-modal); opacity: 0; visibility: hidden; transition: var(--transition-base); padding: var(--space-4); }
    .modal-overlay.active { opacity: 1; visibility: visible; }
    .modal { background: var(--color-surface); border-radius: var(--radius-2xl); box-shadow: var(--shadow-2xl); width: 100%; max-width: 560px; max-height: 90vh; overflow-y: auto; transform: scale(0.9) translateY(20px); transition: var(--transition-base); }
    .modal-overlay.active .modal { transform: scale(1) translateY(0); }
    .modal-header { padding: var(--space-6); border-bottom: 1px solid var(--color-border-light); display: flex; align-items: center; justify-content: space-between; }
    .modal-header h3 { margin-bottom: 0; }
    .modal-close { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); color: var(--color-text-muted); transition: var(--transition-base); font-size: var(--text-lg); }
    .modal-close:hover { background: var(--color-bg-alt); color: var(--color-text); }
    .modal-body { padding: var(--space-6); }
    .modal-footer { padding: var(--space-4) var(--space-6); border-top: 1px solid var(--color-border-light); display: flex; align-items: center; justify-content: flex-end; gap: var(--space-3); }
    .toast-container { position: fixed; top: var(--space-6); right: var(--space-6); z-index: var(--z-toast); display: flex; flex-direction: column; gap: var(--space-3); pointer-events: none; }
    .toast { background: var(--color-surface); border-radius: var(--radius-xl); box-shadow: var(--shadow-xl); padding: var(--space-4) var(--space-5); display: flex; align-items: flex-start; gap: var(--space-3); min-width: 320px; max-width: 420px; pointer-events: auto; animation: slideInRight 0.4s ease, fadeIn 0.4s ease; border-left: 4px solid var(--color-primary); }
    .toast.toast-success { border-left-color: var(--color-success); }
    .toast.toast-error { border-left-color: var(--color-danger); }
    .toast.toast-warning { border-left-color: var(--color-warning); }
    .toast-icon { width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: var(--text-lg); }
    .toast-content { flex: 1; }
    .toast-title { font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-text); margin-bottom: 2px; }
    .toast-message { font-size: var(--text-xs); color: var(--color-text-secondary); margin-bottom: 0; }
    .toast-close { color: var(--color-text-muted); cursor: pointer; flex-shrink: 0; padding: var(--space-1); transition: var(--transition-fast); }
    .toast-close:hover { color: var(--color-text); }
    .toast.removing { animation: slideOutRight 0.3s ease forwards; }
    .progress-bar { width: 100%; height: 8px; background: var(--color-bg-alt); border-radius: var(--radius-full); overflow: hidden; }
    .progress-fill { height: 100%; border-radius: var(--radius-full); background: var(--color-primary-gradient); transition: width 1s ease; animation: progressBar 1.5s ease; }
    .progress-fill.success { background: linear-gradient(135deg, var(--color-success) 0%, var(--color-success-light) 100%); }
    .file-upload { border: 2px dashed var(--color-border); border-radius: var(--radius-xl); padding: var(--space-8) var(--space-6); text-align: center; cursor: pointer; transition: var(--transition-base); position: relative; }
    .file-upload:hover, .file-upload.drag-over { border-color: var(--color-primary); background: var(--color-primary-50); }
    .file-upload input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    .file-upload-icon { font-size: var(--text-4xl); color: var(--color-text-muted); margin-bottom: var(--space-3); }
    .file-upload-text { font-size: var(--text-sm); color: var(--color-text-secondary); margin-bottom: var(--space-1); }
    .file-upload-text strong { color: var(--color-primary); }
    .file-upload-hint { font-size: var(--text-xs); color: var(--color-text-muted); }
    .file-preview { display: flex; align-items: center; gap: var(--space-3); padding: var(--space-3) var(--space-4); background: var(--color-success-bg); border: 1px solid var(--color-success-border); border-radius: var(--radius-lg); margin-top: var(--space-3); }
    .file-preview-name { flex: 1; font-size: var(--text-sm); color: var(--color-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .file-preview-remove { color: var(--color-danger); cursor: pointer; padding: var(--space-1); transition: var(--transition-fast); }
    .file-preview-remove:hover { background: var(--color-danger-bg); border-radius: var(--radius-sm); }
    .empty-state { text-align: center; padding: var(--space-16) var(--space-6); }
    .empty-state-icon { font-size: 4rem; color: var(--color-text-muted); margin-bottom: var(--space-4); }
    .empty-state-title { font-size: var(--text-lg); font-weight: var(--font-semibold); color: var(--color-text); margin-bottom: var(--space-2); }
    .empty-state-text { font-size: var(--text-sm); color: var(--color-text-secondary); max-width: 400px; margin: 0 auto var(--space-6); }
    .tabs { display: flex; gap: var(--space-1); background: var(--color-bg-alt); padding: var(--space-1); border-radius: var(--radius-xl); margin-bottom: var(--space-6); }
    .tab-btn { flex: 1; padding: var(--space-3) var(--space-4); font-size: var(--text-sm); font-weight: var(--font-medium); color: var(--color-text-secondary); background: transparent; border: none; border-radius: var(--radius-lg); cursor: pointer; transition: var(--transition-base); white-space: nowrap; }
    .tab-btn:hover { color: var(--color-text); }
    .tab-btn.active { background: var(--color-white); color: var(--color-primary); box-shadow: var(--shadow-sm); font-weight: var(--font-semibold); }
    .table-container { overflow-x: auto; border-radius: var(--radius-xl); }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead { background: var(--color-bg); }
    .data-table th { padding: var(--space-3) var(--space-4); text-align: left; font-size: var(--text-xs); font-weight: var(--font-semibold); color: var(--color-text-secondary); text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap; }
    .data-table td { padding: var(--space-4); font-size: var(--text-sm); color: var(--color-text); border-top: 1px solid var(--color-border-light); vertical-align: middle; }
    .data-table tbody tr { transition: var(--transition-fast); }
    .data-table tbody tr:hover { background: var(--color-primary-50); }
    .divider { width: 100%; height: 1px; background: var(--color-border-light); margin: var(--space-6) 0; }
    .avatar { width: 40px; height: 40px; border-radius: var(--radius-full); background: var(--color-primary-gradient); color: var(--color-white); display: flex; align-items: center; justify-content: center; font-weight: var(--font-bold); font-size: var(--text-sm); flex-shrink: 0; }
    .avatar-lg { width: 64px; height: 64px; font-size: var(--text-xl); }
    .avatar-xl { width: 96px; height: 96px; font-size: var(--text-3xl); }
    .skeleton { background: linear-gradient(90deg, var(--color-bg-alt) 25%, var(--color-bg) 50%, var(--color-bg-alt) 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: var(--radius-md); }
    .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-6); gap: var(--space-4); flex-wrap: wrap; }
    .section-title { font-size: var(--text-xl); font-weight: var(--font-bold); color: var(--color-text); margin-bottom: 0; }
    .section-subtitle { font-size: var(--text-sm); color: var(--color-text-secondary); margin-top: var(--space-1); margin-bottom: 0; }

    /* ===== layout.css ===== */
    .app-layout { display: flex; min-height: 100vh; }
    .sidebar { width: var(--sidebar-width); background: var(--color-white); border-right: 1px solid var(--color-border-light); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: var(--z-fixed); transition: var(--transition-base); overflow-y: auto; }
    .sidebar-brand { padding: var(--space-6); display: flex; align-items: center; gap: var(--space-3); border-bottom: 1px solid var(--color-border-light); flex-shrink: 0; }
    .sidebar-brand-logo { width: 44px; height: 44px; background: var(--color-primary-gradient); border-radius: var(--radius-xl); display: flex; align-items: center; justify-content: center; color: var(--color-white); font-size: var(--text-xl); font-weight: var(--font-extrabold); font-family: var(--font-heading); flex-shrink: 0; }
    .sidebar-brand-text { display: flex; flex-direction: column; }
    .sidebar-brand-name { font-family: var(--font-heading); font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--color-text); line-height: 1.2; }
    .sidebar-brand-sub { font-size: var(--text-xs); color: var(--color-text-muted); }
    .sidebar-nav { padding: var(--space-4); flex: 1; }
    .sidebar-nav-label { font-size: var(--text-xs); font-weight: var(--font-semibold); color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.08em; padding: var(--space-3) var(--space-4); margin-top: var(--space-2); }
    .sidebar-nav-item { margin-bottom: var(--space-1); }
    .sidebar-nav-link { display: flex; align-items: center; gap: var(--space-3); padding: var(--space-3) var(--space-4); color: var(--color-text-secondary); border-radius: var(--radius-xl); transition: var(--transition-base); font-size: var(--text-sm); font-weight: var(--font-medium); text-decoration: none; }
    .sidebar-nav-link:hover { background: var(--color-primary-50); color: var(--color-primary); }
    .sidebar-nav-link.active { background: var(--color-primary); color: var(--color-white); font-weight: var(--font-semibold); box-shadow: var(--shadow-primary); }
    .sidebar-nav-link .nav-icon { width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: var(--text-lg); flex-shrink: 0; }
    .sidebar-nav-link .nav-text { flex: 1; }
    .sidebar-nav-link .nav-badge { background: var(--color-danger); color: var(--color-white); font-size: 10px; font-weight: var(--font-bold); padding: 2px 6px; border-radius: var(--radius-full); min-width: 20px; text-align: center; }
    .sidebar-nav-link.active .nav-badge { background: var(--color-white); color: var(--color-primary); }
    .sidebar-footer { padding: var(--space-4); border-top: 1px solid var(--color-border-light); flex-shrink: 0; }
    .sidebar-user { display: flex; align-items: center; gap: var(--space-3); padding: var(--space-3); border-radius: var(--radius-xl); transition: var(--transition-base); }
    .sidebar-user:hover { background: var(--color-bg-alt); }
    .sidebar-user-info { flex: 1; min-width: 0; }
    .sidebar-user-name { font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sidebar-user-role { font-size: var(--text-xs); color: var(--color-text-muted); }
    .sidebar-logout-btn { width: 100%; display: flex; align-items: center; gap: var(--space-3); padding: var(--space-3) var(--space-4); color: var(--color-danger); border-radius: var(--radius-xl); transition: var(--transition-base); font-size: var(--text-sm); font-weight: var(--font-medium); cursor: pointer; border: none; background: none; margin-top: var(--space-2); }
    .sidebar-logout-btn:hover { background: var(--color-danger-bg); }
    .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); z-index: calc(var(--z-fixed) - 1); opacity: 0; transition: var(--transition-base); }
    .sidebar-overlay.active { opacity: 1; }
    .main-wrapper { flex: 1; margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column; transition: var(--transition-base); }
    .top-header { background: var(--color-white); border-bottom: 1px solid var(--color-border-light); padding: 0 var(--space-8); height: var(--header-height); display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: var(--z-sticky); transition: var(--transition-base); }
    .top-header.scrolled { box-shadow: var(--shadow-md); }
    .header-left { display: flex; align-items: center; gap: var(--space-4); }
    .mobile-menu-btn { display: none; width: 40px; height: 40px; align-items: center; justify-content: center; border-radius: var(--radius-lg); color: var(--color-text); transition: var(--transition-base); font-size: var(--text-xl); cursor: pointer; border: none; background: none; }
    .mobile-menu-btn:hover { background: var(--color-bg-alt); }
    .page-title-section h1 { font-size: var(--text-xl); font-weight: var(--font-bold); margin-bottom: 0; }
    .page-title-section p { font-size: var(--text-sm); color: var(--color-text-secondary); margin-bottom: 0; }
    .header-right { display: flex; align-items: center; gap: var(--space-3); }
    .header-notification { position: relative; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); color: var(--color-text-secondary); transition: var(--transition-base); cursor: pointer; border: none; background: none; font-size: var(--text-lg); }
    .header-notification:hover { background: var(--color-bg-alt); color: var(--color-text); }
    .header-notification .notification-dot { position: absolute; top: 8px; right: 8px; width: 8px; height: 8px; background: var(--color-danger); border-radius: 50%; border: 2px solid var(--color-white); }
    .header-user-btn { display: flex; align-items: center; gap: var(--space-2); padding: var(--space-1) var(--space-3) var(--space-1) var(--space-1); border-radius: var(--radius-full); border: 1px solid var(--color-border-light); cursor: pointer; transition: var(--transition-base); background: var(--color-white); text-decoration: none; }
    .header-user-btn:hover { border-color: var(--color-primary-300); box-shadow: var(--shadow-sm); }
    .header-user-btn .avatar { width: 32px; height: 32px; font-size: var(--text-xs); }
    .header-user-btn .user-name-text { font-size: var(--text-sm); font-weight: var(--font-medium); color: var(--color-text); }
    .main-content { flex: 1; padding: var(--space-8); }
    .page-footer { padding: var(--space-6) var(--space-8); border-top: 1px solid var(--color-border-light); text-align: center; }
    .page-footer p { font-size: var(--text-xs); color: var(--color-text-muted); margin-bottom: 0; }

    /* ===== responsive.css ===== */
    @media (max-width: 1024px) {
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
      .quick-actions { grid-template-columns: repeat(2, 1fr); }
      .dashboard-grid { grid-template-columns: 1fr; }
      .profile-grid { grid-template-columns: 1fr; }
      .invoice-stats { grid-template-columns: 1fr; }
      .form-row { grid-template-columns: 1fr; }
      .bank-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
      :root { --sidebar-width: 280px; --header-height: 64px; }
      .sidebar { transform: translateX(-100%); box-shadow: none; }
      .sidebar.open { transform: translateX(0); box-shadow: var(--shadow-2xl); }
      .sidebar-overlay { display: block; pointer-events: none; }
      .sidebar-overlay.active { pointer-events: auto; }
      .main-wrapper { margin-left: 0; }
      .mobile-menu-btn { display: flex; }
      .top-header { padding: 0 var(--space-4); }
      .header-user-btn .user-name-text { display: none; }
      .main-content { padding: var(--space-5); }
      .stats-grid { grid-template-columns: 1fr 1fr; gap: var(--space-4); }
      .stat-card { padding: var(--space-4); }
      .stat-card-value { font-size: var(--text-xl); }
      .quick-actions { grid-template-columns: 1fr; gap: var(--space-4); }
      .quick-action-card { flex-direction: row; padding: var(--space-5); text-align: left; }
      .quick-action-icon { width: 52px; height: 52px; }
      .welcome-banner { padding: var(--space-6); }
      .welcome-banner h2 { font-size: var(--text-xl); }
      .transaction-item { padding: var(--space-3) var(--space-4); }
      .payment-container { max-width: 100%; }
      .payment-form-header, .payment-form-body, .payment-form-footer { padding: var(--space-5); }
      .payment-steps { padding: var(--space-4); overflow-x: auto; justify-content: flex-start; }
      .step-text { display: none; }
      .step-connector { width: 24px; }
      .amount-shortcuts { gap: var(--space-1); }
      .amount-shortcut { font-size: 11px; padding: var(--space-1) var(--space-2); }
      .payment-form-footer { flex-direction: column; }
      .payment-form-footer .btn { width: 100%; }
      .invoice-toolbar { flex-direction: column; align-items: stretch; }
      .invoice-search { max-width: 100%; }
      .tabs { overflow-x: auto; flex-wrap: nowrap; }
      .tab-btn { flex: 0 0 auto; }
      .invoice-card-main { flex-wrap: wrap; padding: var(--space-4); gap: var(--space-3); }
      .invoice-card-meta { width: 100%; justify-content: space-between; padding-top: var(--space-3); border-top: 1px solid var(--color-border-light); }
      .invoice-detail-grid { grid-template-columns: 1fr; }
      .profile-info-section { padding: 0 var(--space-5) var(--space-5); flex-direction: column; align-items: flex-start; gap: var(--space-4); }
      .profile-avatar { width: 72px; height: 72px; font-size: var(--text-2xl); }
      .profile-actions { width: 100%; }
      .profile-actions .btn { flex: 1; }
      .profile-name { font-size: var(--text-xl); }
      .tour-amounts { grid-template-columns: 1fr; }
      .login-hero { display: none; }
      .login-form-side { max-width: 100%; padding: var(--space-6); }
      .login-mobile-logo { display: block; }
      .login-form-header h2 { font-size: var(--text-2xl); }
      .modal { margin: var(--space-4); max-height: calc(100vh - var(--space-8)); }
      .toast-container { left: var(--space-4); right: var(--space-4); top: var(--space-4); }
      .toast { min-width: auto; max-width: 100%; }
      .page-footer { padding: var(--space-4) var(--space-5); }
    }
    @media (max-width: 480px) {
      html { font-size: 14px; }
      .stats-grid { grid-template-columns: 1fr; gap: var(--space-3); }
      .stat-card { display: flex; align-items: center; gap: var(--space-4); padding: var(--space-4); }
      .stat-card-icon { margin-bottom: 0; }
      .radio-group { flex-direction: column; }
      .bank-grid { grid-template-columns: 1fr 1fr; gap: var(--space-2); }
      .bank-option-label { padding: var(--space-3); }
      .success-actions { flex-direction: column; }
      .success-actions .btn { width: 100%; }
      .progress-amounts { flex-direction: column; gap: var(--space-4); }
      .welcome-banner { padding: var(--space-5); }
      .welcome-banner h2 { font-size: var(--text-lg); }
      .welcome-banner p { font-size: var(--text-sm); }
      .section-header { flex-direction: column; align-items: flex-start; }
    }
    @media (min-width: 1440px) {
      .main-content { padding: var(--space-10) var(--space-12); }
      .stats-grid { gap: var(--space-8); }
    }
  </style>

  @yield('page_styles')

  <link rel="icon"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🕌</text></svg>">
</head>

<body>
  <div class="app-layout">

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    @include('user.partials.sidebar')

    <!-- Main Wrapper -->
    <div class="main-wrapper">
      <!-- Top Header -->
      <header class="top-header">
        <div class="header-left">
          <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Buka menu navigasi">
            ☰
          </button>
          <div class="page-title-section">
            <h1>{{ $pageTitle }}</h1>
            <p>{{ $pageSubtitle }}</p>
          </div>
        </div>
        <div class="header-right">
          @php
            $headerUser = $user ?? Auth::user();
          @endphp
          <a href="{{ route('user.profile') }}" class="header-user-btn" aria-label="Profil pengguna">
            <div class="avatar" id="headerAvatar">{{ strtoupper(substr($headerUser->name, 0, 2)) }}</div>
            <span class="user-name-text" id="headerUserName">{{ explode(' ', $headerUser->name)[0] }}</span>
          </a>
        </div>
      </header>

      <!-- Main Content -->
      <main class="main-content">
        @yield('content')
      </main>

      <!-- Footer -->
      <footer class="page-footer">
        <p>© 2024 HMI Tour Travel — Sistem Record Pembayaran Tour</p>
      </footer>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('assets/js/utils.js') }}"></script>
  <script src="{{ asset('assets/js/navigation.js') }}"></script>
  @yield('page_scripts')
  <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
