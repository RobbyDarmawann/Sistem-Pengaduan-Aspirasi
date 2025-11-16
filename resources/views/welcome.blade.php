<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Aspirasi dan Pengaduan Online Publik</title>
    
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
        
        /* Style untuk mencegah scroll body saat modal aktif */
        body.modal-open {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">

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

       <section id="masuk" class="py-20 bg-gray-50"> <div class="container mx-auto px-5">
                
                <div class="bg-[#347ab7] rounded-3xl shadow-xl p-8 md:p-12">

                    <h2 class="text-3xl lg:text-4xl font-bold text-center text-white mb-12">
                        Masuk Sebagai Pengguna, Admin, Instansi?
                    </h2>
                    
                    <div class="flex flex-col md:flex-row justify-center gap-8">
                        
                        <div class="card-masuk bg-white rounded-xl shadow-md p-8 w-full md:w-96 text-center transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <img src="{{ asset('assets/images/profil-pengguna.jpg') }}" alt="Pengguna" class="w-24 h-24 rounded-full mx-auto mb-5 object-cover bg-gray-200">
                            <h3 class="text-2xl font-semibold mb-3 text-gray-800">Pengguna</h3>
                            <p class="text-gray-600 mb-6">Akses dan sampaikan laporan atau aspirasi Anda, serta pantau status dan tanggapan secara transparan.</p>
                            <button class="open-login-modal inline-block py-3 px-7 rounded-full font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-all duration-300">
                                Masuk
                            </button>
                        </div>
                        
                        <div class="card-masuk bg-white rounded-xl shadow-md p-8 w-full md:w-96 text-center transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <img src="{{ asset('assets/images/profil-admin.jpg') }}" alt="Admin" class="w-24 h-24 rounded-full mx-auto mb-5 object-cover bg-gray-200">
                            <h3 class="text-2xl font-semibold mb-3 text-gray-800">Admin</h3>
                            <p class="text-gray-600 mb-6">Kelola laporan dan aspirasi yang masuk, atur pengguna, serta pantau kinerja sistem secara menyeluruh.</p>
                            <button class="open-login-modal inline-block py-3 px-7 rounded-full font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-all duration-300">
                                Masuk
                            </button>
                        </div>
                        
                        <div class="card-masuk bg-white rounded-xl shadow-md p-8 w-full md:w-96 text-center transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <img src="{{ asset('assets/images/profil-instansi.jpg') }}" alt="Instansi" class="w-24 h-24 rounded-full mx-auto mb-5 object-cover bg-gray-200">
                            <h3 class="text-2xl font-semibold mb-3 text-gray-800">Instansi</h3>
                            <p class="text-gray-600 mb-6">Terima dan tindak lanjuti laporan yang relevan, kelola data internal, dan berikan respon resmi kepada publik.</p>
                            <button class="open-login-modal inline-block py-3 px-7 rounded-full font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-all duration-300">
                                Masuk
                            </button>
                        </div>
                    </div>
                </div> 
            </div>
        </section>

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
</main>

    <footer class="py-10 bg-gray-800 text-center">
        <div class="container mx-auto px-5">
            <p class="text-gray-300">&copy; 2025 Kelompok 5. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    @include('partials.auth-modal')


    <script>
        // ... (SEMUA KODE JAVASCRIPT ANDA YANG SUDAH ADA TETAP DI SINI) ...
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

            // --- SCRIPT LOGIC MODAL ---
            const modalContainer = document.getElementById('modal-container');
            const loginModal = document.getElementById('login-modal');
            const registerModal = document.getElementById('register-modal');
            
            const openLoginButtons = document.querySelectorAll('.open-login-modal');
            const overlay = document.querySelector('.modal-overlay');
            
            const showRegisterButton = document.getElementById('show-register');
            const showLoginButton = document.getElementById('show-login');
            const body = document.body;
            const registerForm = document.getElementById('register-form');
            const registerButton = document.getElementById('register-submit-button');
            const generalError = document.getElementById('general-error');
            const loginSuccessMessage = document.getElementById('login-success-message');

            function openModal() {
                if (!modalContainer) return; 
                modalContainer.classList.remove('hidden');
                modalContainer.classList.add('flex');
                if (loginModal) loginModal.classList.remove('hidden');
                if (registerModal) registerModal.classList.add('hidden');
                body.classList.add('modal-open');
                clearAllErrors();
            }

            function closeModal() {
                if (!modalContainer) return;
                modalContainer.classList.add('hidden');
                modalContainer.classList.remove('flex');
                body.classList.remove('modal-open');
            }

            openLoginButtons.forEach(button => {
                button.addEventListener('click', openModal);
            });

            if (overlay) {
                overlay.addEventListener('click', closeModal);
            }

            if (showRegisterButton && loginModal && registerModal) {
                showRegisterButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    loginModal.classList.add('hidden');
                    registerModal.classList.remove('hidden');
                    clearAllErrors();
                });
            }
            
            function switchToLogin(message) {
                if (registerModal) registerModal.classList.add('hidden');
                if (loginModal) loginModal.classList.remove('hidden');
                
                if (loginSuccessMessage) {
                    loginSuccessMessage.textContent = message;
                    loginSuccessMessage.classList.remove('hidden');
                }
            }

            if (showLoginButton && loginModal && registerModal) {
                showLoginButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    switchToLogin(''); 
                    if(loginSuccessMessage) loginSuccessMessage.classList.add('hidden');
                });
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modalContainer && !modalContainer.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // --- FUNGSI AJAX REGISTER ---
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (registerButton) {
                        registerButton.disabled = true;
                        registerButton.textContent = 'Mendaftar...';
                    }
                    clearAllErrors();

                    const formData = new FormData(registerForm);
                    
                    fetch('{{ route("register") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': formData.get('_token')
                        }
                    })
                    .then(response => {
                        return response.json().then(data => {
                            if (!response.ok) {
                                throw data.errors || { general: ['Terjadi kesalahan.'] };
                            }
                            return data;
                        });
                    })
                    .then(data => {
                        if (registerButton) {
                            registerButton.disabled = false;
                            registerButton.textContent = 'Daftar';
                        }
                        registerForm.reset();
                        switchToLogin(data.message);
                    })
                    .catch(errors => {
                        if (registerButton) {
                            registerButton.disabled = false;
                            registerButton.textContent = 'Daftar';
                        }
                        if (errors) {
                            displayErrors(errors);
                        } else {
                            if (generalError) {
                                generalError.textContent = 'Terjadi kesalahan. Silakan coba lagi nanti.';
                                generalError.classList.remove('hidden');
                            }
                        }
                    });
                });
            }

            function displayErrors(errors) {
                for (const field in errors) {
                    const errorElement = document.getElementById(`error-${field}`);
                    if (errorElement) {
                        errorElement.textContent = errors[field][0];
                    }
                }
                if (errors.general) {
                     if(generalError) {
                        generalError.textContent = errors.general[0];
                        generalError.classList.remove('hidden');
                     }
                }
            }

            function clearAllErrors() {
                const errorElements = document.querySelectorAll('[id^="error-"]');
                errorElements.forEach(el => el.textContent = '');
                if (generalError) generalError.classList.add('hidden');
                if (loginSuccessMessage) loginSuccessMessage.classList.add('hidden');
            }

        });
    </script>
</body>
</html>