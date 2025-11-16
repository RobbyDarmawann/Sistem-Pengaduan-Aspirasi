document.addEventListener('DOMContentLoaded', function() {
            
            // --- Script Mobile Menu & Navbar Scroll (TETAP SAMA) ---
            // ... (Kode ini tidak perlu diubah) ...
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');
            if (mobileMenuButton) { mobileMenuButton.addEventListener('click', () => { mobileMenu.classList.toggle('hidden'); }); }
            mobileMenuLinks.forEach(link => { link.addEventListener('click', () => { if (!mobileMenu.classList.contains('hidden')) { mobileMenu.classList.add('hidden'); } }); });
            let lastScrollTop = 0; const navbar = document.querySelector('.navbar'); const navbarHeight = navbar.offsetHeight; const desktopBreakpoint = 768;
            function handleNavbarVisibility() { let currentScrollTop = window.pageYOffset || document.documentElement.scrollTop; if (window.innerWidth >= desktopBreakpoint) { if (currentScrollTop <= 10) { navbar.style.transform = 'translateY(0)'; } else if (currentScrollTop > lastScrollTop && currentScrollTop > navbarHeight) { navbar.style.transform = 'translateY(-100%)'; } else if (currentScrollTop < lastScrollTop) { navbar.style.transform = 'translateY(0)'; } } else { navbar.style.transform = 'translateY(0)'; } lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop; }
            window.addEventListener('scroll', handleNavbarVisibility); window.addEventListener('resize', handleNavbarVisibility);
            document.querySelectorAll('a[href^="#"]').forEach(anchor => { anchor.addEventListener('click', function (e) { if (this.classList.contains('mobile-menu-link')) { } if (this.getAttribute('href') === '#') { e.preventDefault(); return; } const targetId = this.getAttribute('href'); const targetElement = document.querySelector(targetId); if (targetElement) { e.preventDefault(); targetElement.scrollIntoView({ behavior: 'smooth' }); } }); });
            // --- AKHIR DARI SCRIPT YANG TIDAK BERUBAH ---


            // ================================================
            // --- SCRIPT LOGIC MODAL (LOGIN & REGISTER) ---
            // ================================================

            // Variabel Global Modal
            const modalContainer = document.getElementById('modal-container');
            const loginModal = document.getElementById('login-modal');
            const registerModal = document.getElementById('register-modal');
            const openLoginButtons = document.querySelectorAll('.open-login-modal');
            const overlay = document.querySelector('.modal-overlay');
            const showRegisterButton = document.getElementById('show-register');
            const showLoginButton = document.getElementById('show-login');
            const body = document.body;

            // Variabel Form Register
            const registerForm = document.getElementById('register-form');
            const registerButton = document.getElementById('register-submit-button');
            const registerGeneralError = document.getElementById('general-error');
            const loginSuccessMessage = document.getElementById('login-success-message'); 

            // Variabel Form Login (BARU)
            const loginForm = document.getElementById('login-form');
            const loginButton = document.getElementById('login-submit-button');
            const loginGeneralError = document.getElementById('login-general-error');

            const toggleLoginPassword = document.getElementById('toggle-login-password');
            const loginPasswordInput = document.getElementById('login-password');

            function setupPasswordToggle(toggleId, inputId) {
                const toggleButton = document.getElementById(toggleId);
                const passwordInput = document.getElementById(inputId);

                if (toggleButton && passwordInput) {
                    toggleButton.addEventListener('click', function() {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);
                        
                        this.classList.toggle('ri-eye-line');
                        this.classList.toggle('ri-eye-off-line');
                    });
                }
            }

            // Terapkan fungsi ke kedua form
            setupPasswordToggle('toggle-login-password', 'login-password');
            setupPasswordToggle('toggle-register-password', 'register-password');

            // --- Fungsi Utility Modal ---

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

            function switchToLogin(message) {
                if (registerModal) registerModal.classList.add('hidden');
                if (loginModal) loginModal.classList.remove('hidden');
                if (loginSuccessMessage) {
                    if (message) {
                        loginSuccessMessage.textContent = message;
                        loginSuccessMessage.classList.remove('hidden');
                    } else {
                        loginSuccessMessage.classList.add('hidden');
                    }
                }
            }

            // --- Event Listeners Modal ---

            openLoginButtons.forEach(button => {
                button.addEventListener('click', openModal);
            });

            if (overlay) {
                overlay.addEventListener('click', closeModal);
            }

            if (showRegisterButton) {
                showRegisterButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    loginModal.classList.add('hidden');
                    registerModal.classList.remove('hidden');
                    clearAllErrors();
                });
            }
            
            if (showLoginButton) {
                showLoginButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    switchToLogin(''); // Pindah ke login (tanpa pesan)
                });
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modalContainer && !modalContainer.classList.contains('hidden')) {
                    closeModal();
                }
            });


            // --- LOGIKA AJAX FORM LOGIN (BARU) ---
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (loginButton) {
                        loginButton.disabled = true;
                        loginButton.textContent = 'Masuk...';
                    }
                    clearAllErrors();

                    const formData = new FormData(loginForm);
                    
                    fetch('{{ route("login") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': formData.get('_token')
                        }
                    })
                    .then(response => response.json().then(data => ({ status: response.status, body: data })))
                    .then(data => {
                        if (data.status === 200 && data.body.success) {
                            // SUKSES LOGIN
                            // Redirect ke halaman home
                            window.location.href = data.body.redirect_url;
                        } else {
                            // Ini untuk error yang tidak terduga
                            throw data.body.errors || { general: ['Terjadi kesalahan.'] };
                        }
                    })
                    .catch(error => {
                        // GAGAL LOGIN (Error 422 atau lainnya)
                        if (loginButton) {
                            loginButton.disabled = false;
                            loginButton.textContent = 'Masuk';
                        }

                        if (error.login_field) {
                            document.getElementById('error-login-field').textContent = error.login_field[0];
                        } else {
                            // Tampilkan error umum jika bukan error validasi
                            if(loginGeneralError) {
                                loginGeneralError.textContent = 'Username atau password salah.';
                                loginGeneralError.classList.remove('hidden');
                            }
                        }
                    });
                });
            }


            // --- LOGIKA AJAX FORM REGISTER (TETAP SAMA) ---
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
                        switchToLogin(data.message); // Pindah ke modal login dgn pesan sukses
                    })
                    .catch(errors => {
                        if (registerButton) {
                            registerButton.disabled = false;
                            registerButton.textContent = 'Daftar';
                        }
                        if (errors) {
                            displayErrors(errors);
                        } else {
                            if (registerGeneralError) {
                                registerGeneralError.textContent = 'Terjadi kesalahan. Silakan coba lagi nanti.';
                                registerGeneralError.classList.remove('hidden');
                            }
                        }
                    });
                });
            }

            // --- Fungsi Bantuan Error ---
            function displayErrors(errors) {
                for (const field in errors) {
                    const errorElement = document.getElementById(`error-${field}`);
                    if (errorElement) {
                        errorElement.textContent = errors[field][0];
                    }
                }
                if (errors.general) {
                     if(registerGeneralError) {
                        registerGeneralError.textContent = errors.general[0];
                        registerGeneralError.classList.remove('hidden');
                     }
                }
            }

            function clearAllErrors() {
                document.querySelectorAll('[id^="error-"]').forEach(el => el.textContent = '');
                if (registerGeneralError) registerGeneralError.classList.add('hidden');
                if (loginGeneralError) loginGeneralError.classList.add('hidden');
                if (loginSuccessMessage) loginSuccessMessage.classList.add('hidden');
            }

            const alertMessage = document.getElementById('alert-message');
            if (alertMessage) {
                setTimeout(() => {
                    alertMessage.style.transition = 'opacity 0.5s ease';
                    alertMessage.style.opacity = '0';
                    setTimeout(() => alertMessage.remove(), 500);
                }, 3000); // Tampilkan selama 3 detik
            }

        });