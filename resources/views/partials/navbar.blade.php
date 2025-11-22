<nav class="navbar bg-[#1977B1] shadow-sm sticky top-0 z-40 transition-transform duration-300">
    <div class="container mx-auto px-5 md:px-20 flex justify-between items-center py-4">
        
        <a href="{{ url('/') }}">
            <img src="{{ asset('assets/images/logo-suarago.png') }}" alt="Logo Suara Rakyat" class="h-12 md:h-14">
        </a>
        
        <ul class="hidden md:flex items-center space-x-6">
            <li><a href="{{ url('/') }}#beranda" class="font-medium text-[#ffffff] hover:text-blue-200 transition-colors">Beranda</a></li>
            <li><a href="{{ url('/') }}#tentang" class="font-medium text-[#ffffff] hover:text-blue-200 transition-colors">Tentang</a></li>
            <li><a href="{{ url('/') }}#layanan" class="font-medium text-[#ffffff] hover:text-blue-200 transition-colors">Layanan</a></li>
            
            @auth
            <li class="relative ml-4">
                <a href="{{ route('notifikasi.index') }}" class="text-white hover:text-blue-200 transition flex items-center relative">
                    <i class="ri-notification-3-line text-xl"></i>
                    
                    @php
                        $unreadCount = \App\Models\Notifikasi::where('pengguna_id', Auth::id())
                                        ->where('is_read', false)
                                        ->count();
                    @endphp

                    @if($unreadCount > 0)
                        <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-[#1977B1] bg-red-500 transform translate-x-1/3 -translate-y-1/3 flex items-center justify-center">
                            </span>
                    @endif
                </a>
            </li>

                <li>
                    <a href="{{ route('profil.index') }}" class="flex items-center gap-3 text-white hover:bg-blue-600/30 px-3 py-2 rounded-lg transition-all group">
                        <div class="text-right hidden lg:block">
                            <div class="text-sm font-bold group-hover:text-blue-100">{{ Auth::user()->full_name }}</div>
                            <div class="text-xs text-blue-200">Pengguna</div>
                        </div>
                        <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('assets/images/profil-pengguna.jpg') }}" 
                             alt="Avatar" 
                             class="w-9 h-9 rounded-full object-cover border-2 border-white/50 group-hover:border-white transition">
                    </a>
                </li>

                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center justify-center w-9 h-9 rounded-lg hover:bg-red-500/20 text-red-200 hover:text-white transition-all" title="Keluar Akun">
                            <i class="ri-logout-box-r-line text-xl"></i>
                        </button>
                    </form>
                </li>

            @else
                <li class="ml-4">
                    <a href="#masuk" class="flex items-center gap-2 font-bold text-white hover:text-blue-200 transition-colors border border-white/30 px-4 py-2 rounded-full hover:bg-white/10">
                        <i class="ri-account-circle-line text-xl"></i> Masuk
                    </a>
                </li>
            @endauth
        </ul>

        <div class="md:hidden flex items-center gap-4">
            @auth
                <a href="{{ route('profil.index') }}">
                    <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('assets/images/profil-pengguna.jpg') }}" 
                         class="w-8 h-8 rounded-full border border-white object-cover">
                </a>
            @endauth

            <button id="mobile-menu-button" class="text-white focus:outline-none">
                <i class="ri-menu-line text-2xl"></i>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg border-t border-gray-100 absolute w-full left-0 z-50">
        <ul class="flex flex-col py-2">
            <li><a href="{{ url('/') }}#beranda" class="mobile-menu-link block py-3 px-6 text-gray-600 hover:bg-blue-50 font-medium">Beranda</a></li>
            <li><a href="{{ url('/') }}#tentang" class="mobile-menu-link block py-3 px-6 text-gray-600 hover:bg-blue-50 font-medium">Tentang</a></li>
            <li><a href="{{ url('/') }}#layanan" class="mobile-menu-link block py-3 px-6 text-gray-600 hover:bg-blue-50 font-medium">Layanan</a></li>
            
            <div class="border-t border-gray-100 my-2"></div>

            @auth
                <li>
                    <a href="{{ route('profil.index') }}" class="block py-3 px-6 text-[#1977B1] hover:bg-blue-50 font-bold">
                        <i class="ri-user-line mr-2"></i> Profil Saya
                    </a>
                </li>
                <li>
                    <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left py-3 px-6 text-red-600 hover:bg-red-50 font-medium">
                            <i class="ri-logout-box-line mr-2"></i> Keluar Akun
                        </button>
                    </form>
                </li>
            @else
                <li>
                    <a href="#masuk" class="mobile-menu-link block py-3 px-6 text-[#1977B1] font-bold hover:bg-blue-50">
                        <i class="ri-login-box-line mr-2"></i> Masuk Sekarang
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</nav>