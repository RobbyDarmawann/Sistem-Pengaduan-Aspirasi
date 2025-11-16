<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SuaraGO</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        html {
            scroll-behavior: smooth;
        }
        
        /* CSS untuk garis di Alur Proses */
        .timeline-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 1.25rem; /* Menyesuaikan dengan 'h-10' icon */
            left: 50%;
            width: 200%; /* Lebar garis (sesuaikan dengan 'gap-x-4' di parent) */
            height: 2px;
            background-color: #e0e0e0;
            transform: translateX(-50%);
            z-index: 1;
        }
    </style>
</head>
<body class="bg-gray-50">

    <nav class="navbar bg-[#1977B1] shadow-sm sticky top-0 z-40 transition-transform duration-300">
        <div class="container mx-auto px-5 md:px-20 flex justify-between items-center py-4">
            
            <a href="#beranda">
                <img src="{{ asset('assets/images/logo-suarago.png') }}" alt="Logo Suara Rakyat" class="h-12 md:h-14">
            </a>
            
            <ul class="hidden md:flex items-center space-x-8">
                <li><a href="#beranda" class="font-medium text-[#ffffff] hover:text-blue-400 transition-colors">Beranda</a></li>
                <li><a href="#tentang" class="font-medium text-[#ffffff] hover:text-blue-400 transition-colors">Tentang</a></li>
                <li><a href="#layanan" class="font-medium text-[#ffffff] hover:text-blue-400 transition-colors">Layanan</a></li>
                
                <li>
                    <a href="#" class="font-medium text-white flex items-center gap-2">
                        <i class="ri-user-fill"></i>
                        {{ Auth::user()->full_name ?? 'Pengguna' }}
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="font-medium text-white hover:text-blue-400 transition-colors"
                           title="Logout">
                           <i class="ri-logout-box-r-line text-xl"></i>
                        </a>
                    </form>
                </li>
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
                
                <li class="border-t border-gray-100">
                    <span class="block py-3 px-5 text-gray-800 font-semibold">
                        {{ Auth::user()->full_name ?? 'Pengguna' }}
                    </span>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="mobile-menu-link block py-3 px-5 text-red-600 hover:bg-red-50">
                            Logout
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <header id="beranda" class="bg-blue-50 min-h-screen flex items-center pt-16 md:pt-0">
        <div class="container mx-auto px-5 py-20">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10">
                <div class="hero-text order-2 md:order-1 text-center md:text-left">
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 leading-tight mb-5">
                        Layanan Aspirasi dan Pengaduan Online Publik
                    </h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Sampaikan laporan Anda langsung kepada instansi pemerintah berwenang.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="#layanan" class="inline-block py-3 px-8 rounded-full font-semibold bg-[#3996AF] text-white hover:bg-[#145D71] transition-all duration-300">
                            Lihat Selengkapnya <i class="ri-arrow-right-line"></i>
                        </a>
                        <a href="#masuk" class="inline-block py-3 px-8 rounded-full font-semibold bg-[#3996AF] text-white hover:bg-[#145D71] transition-all duration-300">
                            Buat Laporan <i class="ri-edit-line"></i>
                        </a>
                    </div>
                </div>
                <div class="hero-image order-1 md:order-2 flex justify-center">
                    <img src="{{ asset('assets/images/timbangan.png') }}" alt="Layanan Pengaduan Publik" class="w-full max-w-sm md:max-w-md h-auto rounded-full object-cover bg-gray-200">
                </div>
            </div>
        </div>
    </header>

    <main>
        <section id="layanan" class="py-20 bg-white">
            <div class="container mx-auto px-5">
                <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-12">
                    Layanan Yang Disediakan
                </h2>
                
                <div class="flex flex-col md:flex-row justify-center items-center gap-8">
                    
                    <a href="#masuk" class="block w-11/12 md:w-auto transition-all duration-300 hover:-translate-y-2">
                        <div class="card-layanan bg-white rounded-xl shadow-md w-full md:w-[420px] overflow-hidden hover:shadow-xl">
                            <img src="{{ asset('assets/images/layanan-aspirasi.jpg') }}" alt="Laporan Aspirasi" class="w-full h-64 object-cover bg-gray-200">
                            <div class="layanan-text bg-[#347ab7] p-8">
                                <h3 class="text-2xl font-semibold text-white mb-3">Laporan Aspirasi</h3>
                                <p class="text-blue-100 leading-relaxed">Sampaikan ide, gagasan, atau masukan konstruktif Anda untuk turut serta dalam perbaikan dan pengembangan layanan publik.</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="#masuk" class="block w-11/12 md:w-auto transition-all duration-300 hover:-translate-y-2">
                        <div class="card-layanan bg-white rounded-xl shadow-md w-full md:w-[420px] overflow-hidden hover:shadow-xl">
                            <img src="{{ asset('assets/images/layanan-pengaduan.png') }}" alt="Laporan Pengaduan" class="w-full h-64 object-cover bg-gray-200">
                            <div class="layanan-text bg-[#347ab7] p-8">
                                <h3 class="text-2xl font-semibold text-white mb-3">Laporan Pengaduan</h3>
                                <p class="text-blue-100 leading-relaxed">Adukan setiap permasalahan, penyimpangan, atau ketidakpuasan terhadap layanan pemerintah agar segera ditindaklanjuti.</p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </section>

        <section id="alur-proses" class="py-20 bg-gray-50">
            <div class="container mx-auto px-5">
                <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-16">
                    Alur Proses Laporan
                </h2>
                
                <div class="flex flex-col md:flex-row justify-center items-start md:gap-x-4">
                    
                    <div class="timeline-step relative flex-1 flex flex-col items-center text-center p-4">
                        <div class="relative z-10 w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-full font-bold text-lg">1</div>
                        <h3 class="font-semibold text-lg text-gray-800 mt-4 mb-2">Tulis Laporan</h3>
                        <p class="text-gray-600 text-sm max-w-xs">Laporkan keluhan atau aspirasi Anda dengan jelas dan lengkap.</p>
                    </div>

                    <div class="timeline-step relative flex-1 flex flex-col items-center text-center p-4">
                        <div class="relative z-10 w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-full font-bold text-lg">2</div>
                        <h3 class="font-semibold text-lg text-gray-800 mt-4 mb-2">Proses Verifikasi</h3>
                        <p class="text-gray-600 text-sm max-w-xs">Tim kami akan memverifikasi kebenaran dan kelengkapan laporan Anda.</p>
                    </div>

                    <div class="timeline-step relative flex-1 flex flex-col items-center text-center p-4">
                        <div class="relative z-10 w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-full font-bold text-lg">3</div>
                        <h3 class="font-semibold text-lg text-gray-800 mt-4 mb-2">Proses Tindak Lanjut</h3>
                        <p class="text-gray-600 text-sm max-w-xs">Laporan Anda akan diteruskan ke instansi terkait untuk ditindaklanjuti.</p>
                    </div>

                    <div class="timeline-step relative flex-1 flex flex-col items-center text-center p-4">
                        <div class="relative z-10 w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-full font-bold text-lg">4</div>
                        <h3 class="font-semibold text-lg text-gray-800 mt-4 mb-2">Beri Tanggapan</h3>
                        <p class="text-gray-600 text-sm max-w-xs">Anda dapat melihat tanggapan dan status laporan Anda secara berkala.</p>
                    </div>

                    <div class="timeline-step relative flex-1 flex flex-col items-center text-center p-4">
                        <div class="relative z-10 w-10 h-10 flex items-center justify-center bg-green-500 text-white rounded-full font-bold text-lg">5</div>
                        <h3 class="font-semibold text-lg text-gray-800 mt-4 mb-2">Selesai</h3>
                        <p class="text-gray-600 text-sm max-w-xs">Laporan Anda telah ditindaklanjuti dan dianggap selesai.</p>
                    </div>

                </div>
            </div>
        </section>


        <section id="tentang" class="py-20 bg-white">
            <div class="container mx-auto px-5">
                <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10">
                    <div class="tentang-text text-center md:text-left">
                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-5">Tentang</h2>
                        <p class="text-gray-600 leading-relaxed">
                            Suara Rakyat adalah platform layanan aspirasi dan pengaduan publik terintegrasi yang dirancang untuk menjembatani komunikasi antara masyarakat dengan instansi pemerintah. Kami hadir sebagai wujud komitmen untuk menciptakan tata kelola pemerintahan yang baik (good governance) yang transparan, akuntabel, dan partisipatif.
                        </p>
                    </div>
                    <div class="tentang-icon flex justify-center">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Tentang Suara Rakyat" class="w-full max-w-xs md:max-w-sm h-auto object-contain rounded-lg p-4">
                    </div>
                </div>
            </div>
        </section>

        <section id="laporan-terhangat" class="py-20 bg-gray-50">
            <div class="container mx-auto px-5">
                <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-12">
                    Laporan Terhangat
                </h2>

                <div class="max-w-3xl mx-auto space-y-6">
                    
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('assets/images/profil-pengguna.jpg') }}" alt="Avatar Pengguna">
                                <div class="ml-3">
                                    <h4 class="font-semibold text-gray-800">Nama Pengguna</h4>
                                    <span class="text-sm text-gray-500">2 jam lalu</span>
                                </div>
                            </div>
                            <p class="text-gray-700 leading-relaxed">
                                Jalan rusak di jalan palma sudah bertahun-tahun tidak diperbaiki, mohon segera ditindaklanjuti. Sangat berbahaya bagi pengendara motor... 
                                <a href="#" class="text-blue-600 hover:underline">Baca selengkapnya</a>
                            </p>
                            <div class="flex justify-end items-center gap-4 text-gray-500 mt-4 text-sm">
                                <span class="flex items-center gap-1"><i class="ri-thumb-up-line"></i> 54 Suka</span>
                                <span class="flex items-center gap-1"><i class="ri-message-2-line"></i> 5 Komentar</span>
                                <span class="flex items-center gap-1"><i class="ri-eye-line"></i> 210 Dilihat</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('assets/images/profil-admin.jpg') }}" alt="Avatar Pengguna">
                                <div class="ml-3">
                                    <h4 class="font-semibold text-gray-800">Pengguna Lain</h4>
                                    <span class="text-sm text-gray-500">5 jam lalu</span>
                                </div>
                            </div>
                            <p class="text-gray-700 leading-relaxed">
                                Mohon aspirasi untuk penambahan lampu penerangan jalan di area taman kota. Saat malam hari sangat gelap... 
                                <a href="#" class="text-blue-600 hover:underline">Baca selengkapnya</a>
                            </p>
                            <div class="flex justify-end items-center gap-4 text-gray-500 mt-4 text-sm">
                                <span class="flex items-center gap-1"><i class="ri-thumb-up-line"></i> 32 Suka</span>
                                <span class="flex items-center gap-1"><i class="ri-message-2-line"></i> 2 Komentar</span>
                                <span class="flex items-center gap-1"><i class="ri-eye-line"></i> 180 Dilihat</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <footer class="py-10 bg-gray-800 text-center">
        <div class="container mx-auto px-5">
            <p class="text-gray-300">&copy; 2025 Kelompok 5. Hak Cipta Dilindungi.</p>
        </div>
    </footer>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- Script Mobile Menu & Navbar Scroll ---
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');

            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            });

            let lastScrollTop = 0;
            const navbar = document.querySelector('.navbar');
            const navbarHeight = navbar.offsetHeight;
            const desktopBreakpoint = 768; 

            function handleNavbarVisibility() {
                let currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (window.innerWidth >= desktopBreakpoint) {
                    if (currentScrollTop <= 10) { 
                        navbar.style.transform = 'translateY(0)';
                    } else if (currentScrollTop > lastScrollTop && currentScrollTop > navbarHeight) {
                        navbar.style.transform = 'translateY(-100%)';
                    } else if (currentScrollTop < lastScrollTop) {
                        navbar.style.transform = 'translateY(0)';
                    }
                } else {
                    navbar.style.transform = 'translateY(0)';
                }
                
                lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
            }

            window.addEventListener('scroll', handleNavbarVisibility);
            window.addEventListener('resize', handleNavbarVisibility);
            
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    if (this.classList.contains('mobile-menu-link')) { }
                    
                    if (this.getAttribute('href') === '#') {
                        e.preventDefault();
                        return;
                    }

                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        e.preventDefault();
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>