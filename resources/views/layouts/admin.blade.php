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
    <div class="flex h-screen">
        <aside class="w-64 bg-blue-800 text-white flex flex-col">
            <div class="flex items-center justify-center h-20 shadow-md">
                <img src="{{ asset('assets/images/logo-suarago.png') }}" alt="Logo SuaraGO" class="h-12">
            </div>
            <nav class="flex-1 overflow-y-auto">
                <ul class="py-4">
                    <li class="px-5">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-700 text-white font-semibold">
                            <i class="ri-dashboard-line text-xl"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="px-5 mt-2">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="ri-file-text-line text-xl"></i>
                            Laporan
                        </a>
                    </li>
                    <li class="px-5 mt-2">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="ri-user-line text-xl"></i>
                            Profil
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center h-20 px-8 bg-white shadow-sm">
                <div class="flex items-center gap-3">
                    <button id="menu-toggle" class="text-gray-700 md:hidden">
                        <i class="ri-menu-line text-2xl"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <div class="font-semibold text-gray-800">{{ Auth::guard('admin')->user()->full_name ?? 'Admin' }}</div>
                        <div class="text-sm text-gray-500">Admin</div>
                    </div>
                    <img src="{{ asset('assets/images/profil-admin.jpg') }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-500" title="Keluar Akun">
                            <i class="ri-logout-box-r-line text-2xl"></i>
                        </button>
                    </form>
                </div>
            </header>
            
            <main class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>