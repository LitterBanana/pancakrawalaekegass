<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Member') &mdash; HMI Tour Travel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Animations moved to app.css -->
    @stack('styles')
</head>

<body class="font-sans bg-gray-50 text-gray-900 m-0 p-0 min-h-screen">
    <!-- Sidebar Overlay (mobile) -->
    <div class="hidden fixed inset-0 bg-black/50 z-40 lg:hidden" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar Container -->
        <div id="sidebarContainer" class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
            @include('layouts.partials.user_sidebar')
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64 flex flex-col min-h-screen transition-all duration-300">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <ion-icon name="menu-outline" class="text-2xl"></ion-icon>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 font-display m-0">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-sm text-gray-500 hidden sm:block m-0">@yield('page-description', 'Member Panel')</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @php $headerUser = $user ?? Auth::user(); @endphp
                    <a href="{{ route('user.profile') }}" class="flex items-center gap-3 hover:bg-gray-50 p-2 rounded-lg transition-colors">
                        <div class="hidden md:block text-right">
                            <div class="text-sm font-bold text-gray-900">{{ explode(' ', trim($headerUser->name))[0] }}</div>
                            <div class="text-xs text-gray-500">{{ ucfirst($headerUser->role ?? 'Member') }}</div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-maroon-primary to-red-700 text-white flex items-center justify-center font-bold shadow-md shadow-maroon-primary/20">
                            {{ strtoupper(substr(explode(' ', trim($headerUser->name))[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', trim($headerUser->name))[1] ?? '', 0, 1)) }}
                        </div>
                    </a>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 p-4 lg:p-8 overflow-x-hidden">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-8 text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} HMI Tour Travel &mdash; Sistem Record Pembayaran Tour</p>
            </footer>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarContainer');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebarContainer');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    </script>
    @stack('scripts')
</body>

</html>
