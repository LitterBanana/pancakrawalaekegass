@extends('user.layouts.auth')

@section('title', 'Login — HMI Tour Travel')
@section('description', 'Login ke sistem HMI Tour Travel - Record Pembayaran Tour')

@section('content')
  <!-- Mobile Logo (only shows on mobile) -->
  <div class="login-mobile-logo">

    <h2>HMI Tour Travel</h2>
  </div>

  <!-- Form Header -->
  <div class="login-form-header">
    <h2>Selamat Datang</h2>
    <p>Masuk ke akun Anda untuk melanjutkan</p>
  </div>

  @if($errors->any())
  <div class="login-error" role="alert" style="display: flex;">
    ⚠ {{ $errors->first() }}
  </div>
  @endif

  <!-- Login Form -->
  <form action="{{ route('login') }}" method="POST" class="login-form">
    @csrf
    <div class="form-group">
      <label for="loginEmail" class="form-label">Email</label>
      <input
        type="email"
        name="email"
        id="loginEmail"
        class="form-input"
        placeholder="Masukkan email Anda"
        autocomplete="email"
        required
        aria-required="true"
        value="{{ old('email') }}"
      >
    </div>

    <div class="form-group">
      <label for="loginPassword" class="form-label">Password</label>
      <div class="input-group">
        <input
          type="password"
          name="password"
          id="loginPassword"
          class="form-input"
          placeholder="Masukkan password Anda"
          autocomplete="current-password"
          required
          aria-required="true"
        >
        <button type="button" id="togglePassword" class="password-toggle" aria-label="Tampilkan password">
          👁
        </button>
      </div>
    </div>

    <div class="login-form-options">
      <label class="remember-me">
        <input type="checkbox" name="remember" id="rememberMe">
        Ingat saya
      </label>
      <a href="#" class="forgot-password">Lupa Password?</a>
    </div>

    <button type="submit" class="btn btn-primary btn-full login-btn">
      Masuk
    </button>
  </form>

  <!-- Footer -->
  <div class="login-form-footer">
    <p>© 2024 HMI Tour Travel. All rights reserved.</p>
  </div>
@endsection
