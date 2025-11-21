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
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-[#0F4C75] text-white flex flex-col flex-shrink-0 transition-all duration-300">
            <div class="flex items-center gap-3 px-6 h-20 bg-[#0B3C5D]">
                <i class="ri-voiceprint-line text-3xl"></i>
                <h1 class="text-xl font-bold tracking-wide">Suara Rakyat</h1>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-6">
                <ul class="space-y-2 px-4">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-[#3282B8] text-white' : 'text-blue-100 hover:bg-[#1B6CA8] hover:text-white' }} transition-colors">
                            <i class="ri-dashboard-line text-xl"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.laporan.index') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.laporan.*') ? 'bg-[#3282B8] text-white' : 'text-blue-100 hover:bg-[#1B6CA8] hover:text-white' }} transition-colors">
                            <i class="ri-file-list-3-line text-xl"></i>
                            <span class="font-medium">Laporan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-[#1B6CA8] hover:text-white transition-colors">
                            <i class="ri-user-settings-line text-xl"></i>
                            <span class="font-medium">Profil</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="bg-white shadow-sm h-20 flex items-center justify-between px-8 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-gray-600 hover:text-gray-900">
                        <i class="ri-menu-line text-2xl"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-800">@yield('title')</h2>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-bold text-gray-900">{{ Auth::guard('admin')->user()->full_name }}</div>
                        <div class="text-xs text-gray-500">Administrator</div>
                    </div>
                    <div class="relative group">
                        <button class="flex items-center gap-2 focus:outline-none">
                            <img src="{{ asset('assets/images/profil-admin.jpg') }}" alt="Admin" class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block hover:block border border-gray-100 z-50">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="ri-logout-box-line mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 bg-gray-100">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>