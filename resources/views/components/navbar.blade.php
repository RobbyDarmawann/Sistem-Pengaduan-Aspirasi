<nav class="navbar bg-[#1977B1] shadow-sm sticky top-0 z-40 transition-transform duration-300">
    <div class="container mx-auto px-5 md:px-20 flex justify-between items-center py-4">
        
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo-suarago.png') }}" alt="Logo Suara Rakyat" class="h-12 md:h-14">
        </a>
        
        <ul class="hidden md:flex items-center space-x-6">
            <li><a href="{{ route('home') }}#beranda" class="font-medium text-[#ffffff] hover:text-blue-400 transition-colors">Beranda</a></li>
            <li><a href="{{ route('home') }}#tentang" class="font-medium text-[#ffffff] hover:text-blue-400 transition-colors">Tentang</a></li>
            <li><a href="{{ route('home') }}#layanan" class="font-medium text-[#ffffff] hover:text-blue-400 transition-colors">Layanan</a></li>
            
            <li class="relative">
                <button id="notification-toggle" class="text-white hover:text-blue-400 transition-colors">
                    <i class="ri-notification-3-line text-2xl"></i>
                </button>
                <div id="notification-dropdown" class="hidden absolute top-full left-1/2 -translate-x-1/2 mt-4 w-80 sm:w-96 bg-white rounded-lg shadow-xl overflow-hidden z-50">
                    </div>
            </li>

            <li class="relative">
                <button id="profile-toggle" class="flex items-center gap-2 font-medium text-white hover:text-blue-400 transition-colors">
                    <img src="{{ asset('assets/images/profil-pengguna.jpg') }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                    <span>{{ Auth::user()->full_name ?? 'Pengguna' }}</span>
                </button>
                <div id="profile-dropdown" class="hidden absolute top-full left-1/2 -translate-x-1/2 mt-4 w-48 bg-white rounded-lg shadow-xl overflow-hidden z-50">
                    <a href="#" class="flex items-center justify-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="ri-user-line text-lg text-gray-500"></i>
                        <span>Lihat Profil</span>
                    </a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-2 w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                            <i class="ri-logout-box-line text-lg"></i>
                            <span>Keluar Akun</span>
                        </button>
                    </form>
                </div>
            </li>
        </ul>

        <div class="md:hidden">
            <button id="mobile-menu-button" class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg border-t border-gray-100">
         <ul class="flex flex-col">
            <li><a href="{{ route('home') }}#beranda" class="mobile-menu-link block py-3 px-5 text-gray-600 hover:bg-blue-50">Beranda</a></li>
            <li><a href="{{ route('home') }}#tentang" class="mobile-menu-link block py-3 px-5 text-gray-600 hover:bg-blue-50">Tentang</a></li>
            <li><a href="{{ route('home') }}#layanan" class="mobile-menu-link block py-3 px-5 text-gray-600 hover:bg-blue-50">Layanan</a></li>
            
            <li class="border-t border-gray-100">
                <div class="flex items-center gap-3 py-3 px-5">
                    <img src="{{ asset('assets/images/profil-pengguna.jpg') }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                    <span class="text-gray-800 font-semibold">
                        {{ Auth::user()->full_name ?? 'Pengguna' }}
                    </span>
                </div>
            </li>
            <li>
                <a href="#" class="mobile-menu-link block py-3 px-5 text-gray-600 hover:bg-blue-50">Lihat Profil</a>
            </li>
            <li>
                <form id="mobile-logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-menu-link block w-full text-left py-3 px-5 text-red-600 hover:bg-red-50">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>