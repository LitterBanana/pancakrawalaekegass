<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@yield('description', 'Login ke sistem HMI Tour Travel - Record Pembayaran Tour')">
  <title>@yield('title', 'Login — HMI Tour Travel')</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600&display=swap"
    rel="stylesheet">

  <!-- Tailwind CSS -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Favicon -->
  <link rel="icon"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🕌</text></svg>">
</head>

<body class="font-sans bg-gray-50 text-gray-800 antialiased selection:bg-maroon-primary selection:text-white">

  <div class="flex min-h-screen">

    <!-- ================= HERO SIDE (Kiri) ================= -->
    <section class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden group">
      <!-- Gambar Background -->
      <img src="{{ asset('img/Umroh bareng ibu dan zahro.jpeg') }}" alt="Umroh HMI Tour"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-100 mix-blend-overlay group-hover:scale-105 transition-transform duration-1000 ease-in-out">

      <!-- Gradient Overlay -->
      <div class="absolute inset-0 bg-black/60"></div>
      <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-slate-900/50"></div>

      <!-- Content -->
      <div class="relative z-10 flex flex-col justify-end p-12 lg:p-20 w-full">
        <div class="max-w-xl">
          <h1
            class="text-4xl lg:text-5xl font-extrabold text-white mb-6 leading-tight font-display tracking-tight drop-shadow-lg">
            Hijrah Madani Istiqomah <br>
            <span class="text-maroon-primary bg-white px-3 py-1 rounded-lg mt-2 inline-block shadow-lg">Tour Travel</span>
          </h1>
          <p class="text-gray-200 text-lg leading-relaxed font-light drop-shadow">
            Perjalanan ibadah yang penuh berkah bersama HMI Tour Travel.
          </p>
        </div>
      </div>
    </section>

    <!-- ================= FORM SIDE (Kanan) ================= -->
    <section
      class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 lg:p-24 bg-white relative overflow-y-auto">

      <!-- Dekorasi Latar Belakang -->
      <div
        class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-maroon-primary/5 blur-3xl pointer-events-none">
      </div>
      <div
        class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-blue-500/5 blur-3xl pointer-events-none">
      </div>

      <div class="w-full max-w-[420px] relative z-10">
        @yield('content')
      </div>
    </section>
  </div>

  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

  @stack('scripts')
</body>

</html>