 <nav class="navbar bg-[#1977B1] shadow-sm sticky top-0 z-40 transition-transform duration-300">
        <div class="container mx-auto px-5 md:px-20 flex justify-between items-center py-4">
            
            <a href="#beranda">
                <img src="{{ asset('assets/images/logo-suarago.png') }}" alt="Logo Suara Rakyat" class="h-12 md:h-14">
            </a>
            
            <ul class="hidden md:flex space-x-8">
                <li><a href="#beranda" class="font-medium text-[#ffffff] hover:text-blue-400 transition-colors">Beranda</a></li>
                <li><a href="#tentang" class="font-medium text-[#ffffff] hover:text-blue-400 transition-colors">Tentang</a></li>
                <li><a href="#layanan" class="font-medium text-[#ffffff] hover:text-blue-400 transition-colors">Layanan</a></li>
                <li><a href="#masuk" class="font-medium text-[#ffffff] hover:text-blue-400 transition-colors"><i class="ri-account-circle-line"></i> Masuk</a></li>
            </ul>

            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg border-t border-gray-100">
            <ul class="flex flex-col">
                <li><a href="#beranda" class="mobile-menu-link block py-3 px-5 text-gray-600 hover:bg-blue-50">Beranda</a></li>
                <li><a href="#tentang" class="mobile-menu-link block py-3 px-5 text-gray-600 hover:bg-blue-50">Tentang</a></li>
                <li><a href="#layanan" class="mobile-menu-link block py-3 px-5 text-gray-600 hover:bg-blue-50">Layanan</a></li>
                <li><a href="#masuk" class="mobile-menu-link block py-3 px-5 text-gray-600 hover:bg-blue-50">Masuk</a></li>
            </ul>
        </div>
    </nav>