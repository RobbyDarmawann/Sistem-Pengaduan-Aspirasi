<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SuaraGO')</title>
    
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
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">

    <x-navbar />
    
    <main>
        @yield('content')
    </main>

    <x-footer />

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
            if (mobileMenuLinks.length) {
                mobileMenuLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                    });
                });
            }
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
            
            // Smooth scroll untuk link HASH
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
            
            // --- LOGIKA DROPDOWN NAVBAR ---
            const notifToggle = document.getElementById('notification-toggle');
            const notifDropdown = document.getElementById('notification-dropdown');
            const profileToggle = document.getElementById('profile-toggle');
            const profileDropdown = document.getElementById('profile-dropdown');
            if (notifToggle) {
                notifToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notifDropdown.classList.toggle('hidden');
                    if (profileDropdown) profileDropdown.classList.add('hidden');
                });
            }
            if (profileToggle) {
                profileToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                    if (notifDropdown) notifDropdown.classList.add('hidden');
                });
            }
            window.addEventListener('click', function(e) {
                if (notifDropdown && !notifDropdown.contains(e.target) && !notifToggle.contains(e.target)) {
                    notifDropdown.classList.add('hidden');
                }
                if (profileDropdown && !profileDropdown.contains(e.target) && !profileToggle.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });

            // --- LOGIKA LOGOUT AJAX ---
            const logoutForm = document.getElementById('logout-form');
            const mobileLogoutForm = document.getElementById('mobile-logout-form');
            function showToast(message, type = 'success') {
                const toastId = 'dynamic-toast-message';
                let toastMessage = document.getElementById(toastId);
                if (toastMessage) toastMessage.remove(); 
                const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
                toastMessage = document.createElement('div');
                toastMessage.id = toastId;
                toastMessage.className = `fixed top-24 right-5 z-[100] text-white py-3 px-5 rounded-lg shadow-lg ${bgColor}`;
                toastMessage.textContent = message;
                document.body.appendChild(toastMessage);
                setTimeout(() => {
                    toastMessage.style.transition = 'opacity 0.5s ease';
                    toastMessage.style.opacity = '0';
                    setTimeout(() => toastMessage.remove(), 500);
                }, 2000);
            }
            const handleLogout = (e) => {
                e.preventDefault(); 
                const form = e.target.closest('form');
                const formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': formData.get('_token') }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        if (profileDropdown) profileDropdown.classList.add('hidden');
                        if (mobileMenu) mobileMenu.classList.add('hidden');
                        setTimeout(() => { window.location.href = '/'; }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error logging out:', error);
                    showToast('Gagal keluar, silakan coba lagi.', 'error');
                });
            };
            if (logoutForm) {
                logoutForm.addEventListener('submit', handleLogout);
            }
            if (mobileLogoutForm) {
                mobileLogoutForm.addEventListener('submit', handleLogout);
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>