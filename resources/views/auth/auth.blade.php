@extends('layouts.auth')
@section('title', 'Login Admin — HMI Tour Travel')

@section('content')
    <!-- Mobile Logo -->
    <div class="lg:hidden text-center mb-8">
        <div
            class="w-16 h-16 bg-maroon-primary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-lg shadow-maroon-primary/30">
            <ion-icon name="compass-outline" class="text-white"></ion-icon>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 font-display tracking-tight">HMI Tour Travel</h2>
    </div>

    <!-- Header Text -->
    <div class="mb-10 text-center lg:text-left">
        <h2 id="pageTitle" class="text-3xl font-bold text-gray-900 mb-3 font-display">Selamat Datang!</h2>
        <p id="pageSubtitle" class="text-gray-500 font-light">Masuk ke dashboard admin untuk mengelola sistem.</p>
    </div>

    <!-- Tabs for Login/Register -->
    <div class="mb-6">
        <div class="flex border-b border-gray-200">
            <button id="loginTab"
                class="py-2 px-4 text-maroon-primary border-b-2 border-maroon-primary font-semibold transition-colors">Login</button>
            <button id="registerTab"
                class="py-2 px-4 text-gray-500 border-b-2 border-transparent font-semibold hover:text-maroon-primary transition-colors">Register</button>
        </div>
    </div>

    <!-- Login Form -->
    <div id="loginForm">
        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Input Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <ion-icon name="mail-outline" class="text-gray-400 text-lg"></ion-icon>
                    </div>
                    <input type="email" name="email" required placeholder="Masukkan email Anda"
                        class="w-full pl-11 pr-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-maroon-primary focus:border-transparent focus:bg-white transition-all shadow-sm">
                </div>
            </div>

            <!-- Input Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <ion-icon name="lock-closed-outline" class="text-gray-400 text-lg"></ion-icon>
                    </div>
                    <input type="password" id="loginPassword" name="password" required placeholder="••••••••"
                        class="w-full pl-11 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-maroon-primary focus:border-transparent focus:bg-white transition-all shadow-sm">
                    <button type="button" id="togglePassword"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-maroon-primary transition-colors focus:outline-none p-1">
                        <ion-icon name="eye-outline" class="text-xl" id="eyeIcon"></ion-icon>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 mt-4 bg-maroon-primary text-white font-bold rounded-xl shadow-[0_8px_20px_-6px_rgba(128,0,0,0.5)] hover:shadow-[0_12px_25px_-6px_rgba(128,0,0,0.6)] hover:-translate-y-0.5 hover:bg-maroon-800 active:translate-y-0 transition-all duration-200 flex justify-center items-center gap-2 uppercase tracking-wider text-sm">
                <span>Masuk ke Sistem</span>
                <ion-icon name="arrow-forward-outline" class="text-xl"></ion-icon>
            </button>
        </form>
    </div>

    <!-- Register Form -->
    <div id="registerForm" class="hidden">
        <form action="{{ route('register') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Input Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <ion-icon name="person-outline" class="text-gray-400 text-lg"></ion-icon>
                    </div>
                    <input type="text" name="name" required placeholder="Masukkan nama lengkap"
                        class="w-full pl-11 pr-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-maroon-primary focus:border-transparent focus:bg-white transition-all shadow-sm">
                </div>
            </div>

            <!-- Input Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <ion-icon name="mail-outline" class="text-gray-400 text-lg"></ion-icon>
                    </div>
                    <input type="email" name="email" required placeholder="Masukkan email Anda"
                        class="w-full pl-11 pr-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-maroon-primary focus:border-transparent focus:bg-white transition-all shadow-sm">
                </div>
            </div>

            <!-- Input Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <ion-icon name="lock-closed-outline" class="text-gray-400 text-lg"></ion-icon>
                    </div>
                    <input type="password" id="registerPassword" name="password" required placeholder="••••••••"
                        class="w-full pl-11 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-maroon-primary focus:border-transparent focus:bg-white transition-all shadow-sm">
                    <button type="button" id="toggleRegisterPassword"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-maroon-primary transition-colors focus:outline-none p-1">
                        <ion-icon name="eye-outline" class="text-xl" id="registerEyeIcon"></ion-icon>
                    </button>
                </div>
            </div>

            <!-- Input Confirm Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <ion-icon name="lock-closed-outline" class="text-gray-400 text-lg"></ion-icon>
                    </div>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                        class="w-full pl-11 pr-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-maroon-primary focus:border-transparent focus:bg-white transition-all shadow-sm">
                </div>
            </div>

            <!-- Input Referral Code -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Referral (Opsional)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <ion-icon name="gift-outline" class="text-gray-400 text-lg"></ion-icon>
                    </div>
                    <input type="text" name="referral_code" placeholder="Masukkan kode referral jika ada"
                        class="w-full pl-11 pr-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-maroon-primary focus:border-transparent focus:bg-white transition-all shadow-sm">
                </div>
                <p class="text-xs text-gray-500 mt-1">Dapatkan kode referral dari leader untuk keuntungan khusus.</p>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 mt-4 bg-maroon-primary text-white font-bold rounded-xl shadow-[0_8px_20px_-6px_rgba(128,0,0,0.5)] hover:shadow-[0_12px_25px_-6px_rgba(128,0,0,0.6)] hover:-translate-y-0.5 hover:bg-maroon-800 active:translate-y-0 transition-all duration-200 flex justify-center items-center gap-2 uppercase tracking-wider text-sm">
                <span>Daftar Akun</span>
                <ion-icon name="person-add-outline" class="text-xl"></ion-icon>
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div class="mt-12 text-center">
        <p class="text-sm text-gray-400 font-medium">
            &copy; <span id="year">2026</span> HMI Tour Travel. All rights reserved.
        </p>
    </div>
@endsection

@push('scripts')
    <script>
        // Set Year Automatically (for preview)
        document.getElementById('year').textContent = new Date().getFullYear();

        // Toggle Password Visibility for Login
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('loginPassword');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const isPassword = passwordInput.getAttribute('type') === 'password';

                // Ubah tipe input
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

                // Ubah icon dan tambahkan animasi kecil
                eyeIcon.setAttribute('name', isPassword ? 'eye-off-outline' : 'eye-outline');
                eyeIcon.style.transform = 'scale(0.8)';
                setTimeout(() => eyeIcon.style.transform = 'scale(1)', 100);
            });
        }

        // Toggle Password Visibility for Register
        const toggleRegisterBtn = document.getElementById('toggleRegisterPassword');
        const registerPasswordInput = document.getElementById('registerPassword');
        const registerEyeIcon = document.getElementById('registerEyeIcon');

        if (toggleRegisterBtn) {
            toggleRegisterBtn.addEventListener('click', () => {
                const isPassword = registerPasswordInput.getAttribute('type') === 'password';

                // Ubah tipe input
                registerPasswordInput.setAttribute('type', isPassword ? 'text' : 'password');

                // Ubah icon dan tambahkan animasi kecil
                registerEyeIcon.setAttribute('name', isPassword ? 'eye-off-outline' : 'eye-outline');
                registerEyeIcon.style.transform = 'scale(0.8)';
                setTimeout(() => registerEyeIcon.style.transform = 'scale(1)', 100);
            });
        }

        // Tab Switching
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        loginTab.addEventListener('click', () => {
            loginTab.classList.add('text-maroon-primary', 'border-maroon-primary');
            loginTab.classList.remove('text-gray-500', 'border-transparent');
            registerTab.classList.remove('text-maroon-primary', 'border-maroon-primary');
            registerTab.classList.add('text-gray-500', 'border-transparent');
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            
            document.getElementById('pageTitle').innerText = 'Selamat Datang!';
            document.getElementById('pageSubtitle').innerText = 'Masuk ke dashboard admin untuk mengelola sistem.';
        });

        registerTab.addEventListener('click', () => {
            registerTab.classList.add('text-maroon-primary', 'border-maroon-primary');
            registerTab.classList.remove('text-gray-500', 'border-transparent');
            loginTab.classList.remove('text-maroon-primary', 'border-maroon-primary');
            loginTab.classList.add('text-gray-500', 'border-transparent');
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
            
            document.getElementById('pageTitle').innerText = 'Buat Akun Baru';
            document.getElementById('pageSubtitle').innerText = 'Daftarkan diri Anda untuk mengakses sistem.';
        });
    </script>
@endpush