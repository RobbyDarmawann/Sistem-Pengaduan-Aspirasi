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
        
        <aside class="w-64 bg-[#0F4C75] text-white flex flex-col flex-shrink-0 transition-all duration-300 shadow-xl z-20">
            <div class="flex items-center gap-3 px-6 h-20 bg-[#0B3C5D] border-b border-[#0B3C5D]">
                <img src="{{ asset('assets/images/logo icon.png') }}" alt="Logo Suara Rakyat" class="w-10 h-10 object-contain">
                
                <h1 class="text-xl font-bold tracking-wide">Suara Rakyat</h1>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-6">
                <ul class="space-y-2 px-4">
                    
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#3282B8] text-white shadow-md' : 'text-blue-100 hover:bg-[#1B6CA8] hover:text-white' }}">
                            <i class="ri-dashboard-line text-xl"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.laporan.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-[#3282B8] text-white shadow-md' : 'text-blue-100 hover:bg-[#1B6CA8] hover:text-white' }}">
                            <i class="ri-file-list-3-line text-xl"></i>
                            <span class="font-medium">Laporan</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.profil.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.profil.*') ? 'bg-[#3282B8] text-white shadow-md' : 'text-blue-100 hover:bg-[#1B6CA8] hover:text-white' }}">
                            <i class="ri-user-settings-line text-xl"></i>
                            <span class="font-medium">Profil</span>
                        </a>
                    </li>

                </ul>
            </nav>

            <div class="p-4 bg-[#0B3C5D]">
                <p class="text-xs text-center text-blue-300">&copy; 2025 SuaraGO Admin</p>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
            
            <header class="bg-white shadow-sm h-20 flex items-center justify-between px-8 flex-shrink-0 z-10 relative">
                
                <div class="flex items-center gap-4">
                    <h2 class="text-xl font-bold text-gray-800 tracking-tight">@yield('title')</h2>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.profil.index') }}" class="group flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                        
                        <img src="{{ asset('assets/images/profil-admin.jpg') }}" alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 group-hover:border-blue-300 transition-colors">
                        
                        <div class="text-left hidden sm:block">
                            <div class="text-sm font-bold text-gray-800 leading-tight group-hover:text-blue-600 transition-colors">
                                {{ Auth::guard('admin')->user()->full_name ?? 'Admin' }}
                            </div>
                            <div class="text-xs text-gray-500 font-medium">
                                Administrator
                            </div>
                        </div>
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 bg-gray-100 scroll-smooth">
                @yield('content')
            </main>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
        });
    @endif
</script>
</body>
</html>