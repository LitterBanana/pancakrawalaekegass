<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Leader') &mdash; HMI Tour Travel</title>
    <meta name="description" content="@yield('description', 'Sistem Manajemen Leader HMI Tour Travel')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css'])

    @stack('styles')
</head>

<body class="font-sans bg-gray-50 text-gray-900 m-0 p-0 min-h-screen">
    <!-- Sidebar Overlay (mobile) -->
    <div class="hidden fixed inset-0 bg-black/50 z-40 lg:hidden" id="sidebarOverlay" onclick="closeSidebar()"></div>

    @include('layouts.partials.leader_sidebar')

    <!-- Main Wrapper -->
    <div class="lg:ml-[260px] min-h-screen flex flex-col">
        <!-- Top Header -->
        <header class="h-[64px] bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button class="lg:hidden bg-transparent border-none text-xl cursor-pointer p-2 text-gray-900" onclick="toggleSidebar()">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-gray-900 m-0">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-sm text-gray-500 m-0 hidden sm:block">@yield('page-description', '')</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if(Auth::user()->referral_code)
                    <div class="text-xs bg-red-50 text-[#8B1A1A] px-3 py-1.5 rounded-md font-semibold font-mono flex items-center gap-2">
                        <svg class="w-4 h-4 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        {{ Auth::user()->referral_code }}
                    </div>
                @endif
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-6 w-full max-w-full overflow-x-hidden">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-sm mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            
            const overlay = document.getElementById('sidebarOverlay');
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                overlay.classList.add('block');
            } else {
                overlay.classList.add('hidden');
                overlay.classList.remove('block');
            }
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            
            const overlay = document.getElementById('sidebarOverlay');
            overlay.classList.add('hidden');
            overlay.classList.remove('block');
        }
    </script>
</body>

</html>
