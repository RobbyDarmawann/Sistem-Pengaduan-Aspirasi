<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Instansi') - SuaraGO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet"/>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    
    <div class="flex h-screen overflow-hidden">
        
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden transition-opacity"></div>

        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-72 bg-[#145D71] text-white flex flex-col z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-xl">
            
            <div class="flex items-center gap-3 px-6 h-20 bg-[#0F4C5C] border-b border-[#0F4C5C]/50 flex-shrink-0">
                <img src="{{ asset('assets/images/logo-icon.png') }}" alt="Logo" class="w-8 h-8 object-contain brightness-200">
                <h1 class="text-xl font-bold tracking-wide">Instansi</h1>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
                
                <a href="{{ route('instansi.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('instansi.dashboard') ? 'bg-[#3996AF] text-white shadow-md' : 'text-blue-100 hover:bg-[#2C7A90] hover:text-white' }}">
                    <i class="ri-dashboard-line text-xl"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('instansi.dashboard') }}#section-pengaduan" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-[#2C7A90] hover:text-white transition-colors group">
                    <i class="ri-file-warning-line text-xl group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Laporan Pengaduan</span>
                </a>

                <a href="{{ route('instansi.dashboard') }}#section-aspirasi" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-[#2C7A90] hover:text-white transition-colors group">
                    <i class="ri-lightbulb-line text-xl group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Laporan Aspirasi</span>
                </a>

                <a href="{{ route('instansi.profil.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('instansi.profil.*') ? 'bg-[#3996AF] text-white shadow-md' : 'text-blue-100 hover:bg-[#2C7A90] hover:text-white' }}">
                    <i class="ri-user-settings-line text-xl"></i>
                    <span class="font-medium">Profil</span>
                </a>

            </nav>

            <div class="p-4 bg-[#0F4C5C] border-t border-[#0F4C5C]/50 text-center">
                <p class="text-xs text-blue-200">&copy; 2025 SuaraGO</p>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50">
            
            <header class="bg-white shadow-sm h-20 flex items-center justify-between px-6 lg:px-10 flex-shrink-0 z-10">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-600 hover:text-[#145D71] focus:outline-none">
                        <i class="ri-menu-line text-2xl"></i>
                    </button>
                    <h2 class="text-lg lg:text-xl font-bold text-gray-800">@yield('title')</h2>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('instansi.profil.index') }}" class="flex items-center gap-3 group cursor-pointer">
                        <img src="{{ Auth::guard('instansi')->user()->foto_profil ? asset('storage/' . Auth::guard('instansi')->user()->foto_profil) : asset('assets/images/logo-icon.png') }}" 
                             class="w-10 h-10 rounded-full object-cover bg-gray-100 border border-gray-200 group-hover:border-[#145D71] transition">
                        
                        <div class="hidden md:block text-left">
                            <div class="text-sm font-bold text-gray-800 leading-tight group-hover:text-[#145D71] transition">
                                {{ Auth::guard('instansi')->user()->full_name }}
                            </div>
                            <div class="text-xs text-gray-500 font-medium">
                                Instansi
                            </div>
                        </div>
                    </a>
                    </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 lg:p-10 scroll-smooth">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>
</body>
</html>