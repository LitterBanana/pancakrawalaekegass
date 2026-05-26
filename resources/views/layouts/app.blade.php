<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <title>@yield('title', 'Hijrah Madani Istiqomah Tour - Travel Umrah & Haji Amanah')</title>
    <meta name="description" content="@yield('meta_description', 'Hijrah Madani Istiqomah Tour (HMI Tour) menyediakan paket Umrah dan Haji Plus dengan pelayanan, fasilitas nyaman, dan harga hemat. Teman perjalanan ibadah Anda.')">
    <meta name="keywords" content="@yield('meta_keywords', 'hijrah madani istiqomah tour, hmi tour, travel umrah, paket umrah, haji plus, wisata halal, tour muslim, travel umrah terpercaya, travel umrah bogor')">
    <meta name="author" content="Hijrah Madani Istiqomah Tour">
    <meta name="google-site-verification" content="8fQrH-aDZA4ra94bWGQAXlQjVlQLXEDqLOCdEHpArKY" />
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Hijrah Madani Istiqomah Tour">
    <meta property="og:title" content="@yield('title', 'Hijrah Madani Istiqomah Tour - Travel Umrah & Haji')">
    <meta property="og:description" content="@yield('meta_description', 'Solusi perjalanan ibadah Anda bersama Hijrah Madani Istiqomah Tour.')">
    <meta property="og:image" content="@yield('meta_image', asset('assets/images/hero.webp'))">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body id="top" class="bg-white overflow-x-hidden">
    @if (session('success'))
        <div class="bg-green-600 text-white text-center p-4 font-bold text-lg fixed top-0 w-full z-[9999]">
            {{ session('success') }}
        </div>
    @endif

    <header class="header-sticky absolute top-0 left-0 w-full pt-[61px] sm:pt-[83px] z-40" data-header>
        <div class="nav-overlay" data-overlay></div>

        {{-- Header Top --}}
        <div class="header-top-bar absolute top-0 left-0 w-full border-b border-white/10 py-4 z-10">
            <div class="max-w-[580px] sm:max-w-[580px] md:max-w-[800px] lg:max-w-[1050px] xl:max-w-[1180px] mx-auto px-4 grid grid-cols-3 items-center">
                {{-- Helpline --}}
                <a href="https://wa.me/+6285695170953" class="flex items-center gap-2.5 justify-start">
                    <div class="bg-maroon-deep p-1.5 sm:p-3.5 rounded-full text-white">
                        <ion-icon name="call-outline" style="--ionicon-stroke-width: 40px;"></ion-icon>
                    </div>
                    <div class="hidden md:block text-white text-[13px]">
                        <p class="font-medium">Pertanyaan Lebih Lanjut:</p>
                        <p>(+62) 856 9517 0953</p>
                    </div>
                </a>

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="mx-auto">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Hijrah Madani Istiqomah Tour" class="max-w-[100px] sm:max-w-none">
                </a>

                {{-- Buttons --}}
                <div class="justify-self-end flex items-center gap-2.5 text-white">
                    <button class="text-[20px] sm:text-[30px] text-inherit" aria-label="Search">
                        <ion-icon name="search"></ion-icon>
                    </button>
                    <button class="text-[30px] sm:text-[40px] text-inherit lg:hidden" aria-label="Open Menu" data-nav-open-btn>
                        <ion-icon name="menu-outline"></ion-icon>
                    </button>
                </div>
            </div>
        </div>

        {{-- Header Bottom --}}
        <div class="header-bottom-bar border-b border-white/10 lg:border-b-0">
            <div class="max-w-[580px] sm:max-w-[580px] md:max-w-[800px] lg:max-w-[1050px] xl:max-w-[1180px] mx-auto px-4 flex justify-between items-center py-4 lg:py-0">
                {{-- Social --}}
                <ul class="flex items-center gap-1.5 md:gap-2.5">
                    <li>
                        <a href="#" class="social-link-item text-white p-2 border border-white/30 rounded-full text-[15px] transition-all duration-300 ease-in-out hover:bg-white/20">
                            <ion-icon name="logo-facebook"></ion-icon>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/hmitour/" class="social-link-item text-white p-2 border border-white/30 rounded-full text-[15px] transition-all duration-300 ease-in-out hover:bg-white/20">
                            <ion-icon name="logo-instagram"></ion-icon>
                        </a>
                    </li>
                </ul>

                {{-- Navbar --}}
                <nav class="mobile-nav" data-navbar>
                    <div class="relative flex items-center justify-center p-10 lg:hidden">
                        <a href="{{ url('/') }}" class="logo">
                            <img src="{{ asset('assets/images/side-logo.png') }}" alt="Logo Hijrah Madani Istiqomah Tour" class="w-[150px]">
                        </a>
                        <button class="absolute right-5 text-[20px] text-maroon-primary" aria-label="Close Menu" data-nav-close-btn>
                            <ion-icon name="close-outline" style="--ionicon-stroke-width: 80px;"></ion-icon>
                        </button>
                    </div>
                    <ul class="border-t border-black/10 lg:border-t-0 lg:flex lg:justify-center lg:items-center">
                        <li class="border-b border-black/10 lg:border-b-0">
                            <a href="{{ url('/') }}" class="nav-link-item block py-4 px-5 text-jet lg:text-white font-medium text-[15px] lg:text-[16px] lg:font-normal uppercase lg:py-5 lg:px-4 transition-all duration-300 ease-in-out hover:text-maroon-primary" data-nav-link>Home</a>
                        </li>
                        <li class="border-b border-black/10 lg:border-b-0">
                            <a href="{{ route('about') }}" class="nav-link-item block py-4 px-5 text-jet lg:text-white font-medium text-[15px] lg:text-[16px] lg:font-normal uppercase lg:py-5 lg:px-4 transition-all duration-300 ease-in-out hover:text-maroon-primary">About Us</a>
                        </li>
                        <li class="border-b border-black/10 lg:border-b-0">
                            <a href="/#faq" class="nav-link-item block py-4 px-5 text-jet lg:text-white font-medium text-[15px] lg:text-[16px] lg:font-normal uppercase lg:py-5 lg:px-4 transition-all duration-300 ease-in-out hover:text-maroon-primary" data-nav-link>Ketentuan</a>
                        </li>
                        <li class="border-b border-black/10 lg:border-b-0">
                            <a href="/#package" class="nav-link-item block py-4 px-5 text-jet lg:text-white font-medium text-[15px] lg:text-[16px] lg:font-normal uppercase lg:py-5 lg:px-4 transition-all duration-300 ease-in-out hover:text-maroon-primary" data-nav-link>Packages</a>
                        </li>
                        <li class="border-b border-black/10 lg:border-b-0">
                            <a href="/#gallery" class="nav-link-item block py-4 px-5 text-jet lg:text-white font-medium text-[15px] lg:text-[16px] lg:font-normal uppercase lg:py-5 lg:px-4 transition-all duration-300 ease-in-out hover:text-maroon-primary" data-nav-link>Gallery</a>
                        </li>
                        @auth
                            @if(Auth::user()->role === 'leader')
                                <li class="border-b border-black/10 lg:border-b-0">
                                    <a href="{{ route('leader.dashboard') }}" class="nav-link-item block py-4 px-5 text-jet lg:text-white font-medium text-[15px] lg:text-[16px] lg:font-normal uppercase lg:py-5 lg:px-4 transition-all duration-300 ease-in-out hover:text-maroon-primary" data-nav-link>Leader Dashboard</a>
                                </li>
                            @endif
                        @endauth
                        <li class="border-b border-black/10 lg:border-b-0">
                            <a href="https://wa.me/+6285695170953" class="nav-link-item block py-4 px-5 text-jet lg:text-white font-medium text-[15px] lg:text-[16px] lg:font-normal uppercase lg:py-5 lg:px-4 transition-all duration-300 ease-in-out hover:text-maroon-primary" data-nav-link>Contact Us</a>
                        </li>
                        @auth
                            <li class="border-b border-black/10 lg:border-b-0">
                                <form action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="nav-link-item btn-auth block w-full text-left py-3 px-5 text-white bg-gray-700 rounded-full text-[15px] lg:text-[16px] font-medium uppercase lg:py-4 lg:px-4 transition-all duration-300 ease-in-out hover:bg-gray-800 cursor-pointer">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            <li class="border-b border-black/10 lg:border-b-0">
                                <a href="{{ route('login') }}" class="nav-link-item btn-auth block w-full text-left py-3 px-5 text-white bg-maroon-primary rounded-full text-[15px] lg:text-[16px] font-medium uppercase lg:py-4 lg:px-4 transition-all duration-300 ease-in-out hover:bg-maroon-700 cursor-pointer">
                                    Login
                                </a>
                            </li>
                        @endauth
                    </ul>
                </nav>

                <a href="{{ route('packages.index') }}" class="text-white uppercase text-sm sm:text-base border-2 border-white rounded-full py-1 px-5 sm:py-1.5 sm:px-5 transition-all duration-300 ease-in-out hover:bg-white/10">Lihat Paket</a>
            </div>
        </div>
    </header>

    <main>
        <article>
            @yield('content')
        </article>
    </main>

    <footer>
        {{-- Footer Top --}}
        <div class="batik-overlay batik-overlay-sm bg-gunmetal py-[60px] xl:py-[100px] text-gainsboro overflow-hidden relative">
            <div class="container-inner max-w-[580px] sm:max-w-[580px] md:max-w-[800px] lg:max-w-[1050px] xl:max-w-[1180px] mx-auto px-4 relative z-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Brand --}}
                <div class="mb-4">
                    <a href="{{ url('/') }}" class="mb-5 block">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Hijrah Madani Istiqomah Tour Footer" class="w-[180px]">
                    </a>
                    <p class="text-sm leading-7">
                        Hijrah Madani Istiqomah adalah travel umrah terpercaya dan resmi berizin, siap melayani perjalanan ibadah Anda dengan amanah.
                    </p>
                </div>

                {{-- Contact --}}
                <div class="mb-4">
                    <h4 class="contact-title-underline text-white mb-8 font-montserrat font-medium">Contact Us</h4>
                    <p class="text-sm mb-5 max-w-[200px] text-slate-300">
                        Kami siap membantu Anda
                    </p>
                    <ul class="p-0">
                        <li class="flex items-center gap-2.5 mb-4">
                            <ion-icon name="call-outline" class="text-[#5a8bd4] text-[20px] shrink-0" style="--ionicon-stroke-width: 40px;"></ion-icon>
                            <a href="https://wa.me/+6285695170953" class="text-slate-300 text-sm no-underline hover:text-white transition-colors">(+62) 856 9517 0953</a>
                        </li>
                        <li class="flex items-center gap-2.5 mb-4">
                            <ion-icon name="mail-outline" class="text-[#5a8bd4] text-[20px] shrink-0"></ion-icon>
                            <a href="mailto:hijrahmadaniistiqomah@gmail.com" class="text-slate-300 text-sm no-underline hover:text-white transition-colors">hijrahmadaniistiqomah@gmail.com</a>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <ion-icon name="location-outline" class="text-[#5a8bd4] text-[20px] shrink-0 mt-1"></ion-icon>
                            <address>
                                <a href="https://share.google/jOaWMKHbGaMrfu6rt" class="not-italic text-slate-300 leading-relaxed text-sm no-underline hover:text-white transition-colors">
                                    Ruko Bumi Serpong Indah, Jl. Intan 1 No.25<br>
                                    Blok R1, Cibinong, Gunung Sindur, Bogor<br>
                                    Regency, West Java 16340
                                </a>
                            </address>
                        </li>
                    </ul>
                </div>

                {{-- Subscribe Form --}}
                <div class="sm:col-span-2 lg:col-span-1">
                    <p class="text-sm mb-5">
                        Berlangganan untuk mendapatkan informasi terbaru dari kami
                    </p>
                    <form action="" class="md:flex md:items-center md:gap-5 lg:flex-col">
                        <input type="email" name="email" class="bg-white text-sm py-4 px-5 rounded-full mb-2.5 md:mb-0 lg:mb-2.5 w-full" placeholder="Enter Your Email" required>
                        <button type="submit" class="text-white uppercase text-sm border-2 border-white rounded-full py-2 px-5 transition-all duration-300 ease-in-out hover:bg-white/10 w-full md:w-max lg:w-full">Langganan</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Footer Bottom --}}
        <div class="bg-maroon-primary border-t border-white/10 py-5 text-center relative z-10">
            <div class="max-w-full mx-auto px-4">
                <p class="text-slate-300 text-sm m-0">
                    &copy; {{ date('Y') }} <a href="{{ url('/') }}" class="text-white no-underline"><strong>Hijrah Madani Istiqomah Tour</strong></a>. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <a href="#top" class="go-top-btn fixed bottom-4 right-4 w-9 h-9 bg-maroon-primary text-white grid place-items-center text-lg rounded-md shadow-lg" data-go-top>
        <ion-icon name="chevron-up-outline"></ion-icon>
    </a>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        // Hide success message after 5 seconds
        const successMessage = document.querySelector('.bg-green-600');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000); // 5 seconds
        }
    </script>
</body>

</html>