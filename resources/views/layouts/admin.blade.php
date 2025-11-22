<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SuaraGO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet"/>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* Custom Scrollbar untuk Sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 5px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: #0B3C5D; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #3282B8; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    
    <div class="flex h-screen overflow-hidden">
        
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden transition-opacity"></div>

        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-64 bg-[#0F4C75] text-white flex flex-col z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-xl">
            <div class="flex items-center gap-3 px-6 h-20 bg-[#0B3C5D] border-b border-[#0B3C5D] flex-shrink-0">
                <img src="{{ asset('assets/images/logo icon.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                <h1 class="text-xl font-bold tracking-wide">Suara Rakyat</h1>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-6 sidebar-scroll">
                <ul class="space-y-2 px-4">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#3282B8] text-white shadow-md' : 'text-blue-100 hover:bg-[#1B6CA8] hover:text-white' }}">
                            <i class="ri-dashboard-line text-xl"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-[#3282B8] text-white shadow-md' : 'text-blue-100 hover:bg-[#1B6CA8] hover:text-white' }}">
                            <i class="ri-file-list-3-line text-xl"></i>
                            <span class="font-medium">Laporan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.profil.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.profil.*') ? 'bg-[#3282B8] text-white shadow-md' : 'text-blue-100 hover:bg-[#1B6CA8] hover:text-white' }}">
                            <i class="ri-user-settings-line text-xl"></i>
                            <span class="font-medium">Profil</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <header class="bg-white shadow-sm h-20 flex items-center justify-between px-4 lg:px-8 flex-shrink-0 z-10 relative">
                
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-600 hover:text-[#0F4C75] focus:outline-none">
                        <i class="ri-menu-line text-2xl"></i>
                    </button>
                    <h2 class="text-lg lg:text-xl font-bold text-gray-800 truncate">@yield('title')</h2>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.profil.index') }}" class="group flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                        <img src="{{ Auth::guard('admin')->user()->profile_photo_path ? asset('storage/' . Auth::guard('admin')->user()->profile_photo_path) : asset('assets/images/profil-admin.jpg') }}" 
                             alt="Admin" class="w-9 h-9 lg:w-10 lg:h-10 rounded-full object-cover border-2 border-gray-200 group-hover:border-blue-300">
                        
                        <div class="text-left hidden sm:block">
                            <div class="text-sm font-bold text-gray-800 leading-tight group-hover:text-blue-600">
                                {{ Auth::guard('admin')->user()->full_name }}
                            </div>
                            <div class="text-xs text-gray-500 font-medium">Administrator</div>
                        </div>
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 lg:p-8 bg-gray-100 scroll-smooth">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                // Buka Sidebar
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                // Tutup Sidebar
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>
</body>
</html>