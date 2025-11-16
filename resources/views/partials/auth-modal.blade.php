<div id="modal-container" class="fixed inset-0 z-50 hidden items-center justify-center p-5">
    
    <div class="modal-overlay fixed inset-0 bg-black/50"></div>

<div id="login-modal" class="relative w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="grid md:grid-cols-2">
            <div class="bg-[#347ab7] p-8 md:p-12 text-white rounded-l-2xl">
                
                <div id="login-success-message" class="hidden bg-green-500 text-white text-sm font-medium p-3 rounded-lg mb-4">
                    </div>
                
                <div id="login-general-error" class="hidden bg-red-500 text-white text-sm font-medium p-3 rounded-lg mb-4">
                    </div>

                <h2 class="text-2xl font-bold mb-8">Masukkan data akun Anda di bawah ini</h2>
                
                <form id="login-form">
                    @csrf
                    <div class="mb-5">
                        <label for="login-email" class="block mb-2 text-sm font-medium">Email, No. telp, atau username</label>
                        <input type="text" id="login-email" name="login_field" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Masukkan data Anda" required>
                        <div id="error-login-field" class="text-red-300 text-sm mt-1"></div>
                    </div>
                    
                    <div class="mb-8">
                        <label for="login-password" class="block mb-2 text-sm font-medium">Password</label>
                        <div class="relative">
                            <input type="password" 
                                   id="login-password" 
                                   name="password" 
                                   class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300 pr-10" 
                                   placeholder="Masukkan password Anda" 
                                   required>
                            
                            <i id="toggle-login-password" 
                               class="ri-eye-line absolute top-1/2 right-3 -translate-y-1/2 text-gray-800 cursor-pointer text-xl z-10"></i> 
                               </div>
                        <div id="error-password" class="text-red-300 text-sm mt-1"></div>
                    </div>
                    <button type="submit" id="login-submit-button" class="w-full py-3 px-6 rounded-lg font-semibold bg-gray-200 text-gray-800 hover:bg-gray-300 transition-colors duration-300">
                        Masuk
                    </button>
                </form>
                
                <p class="text-center text-sm mt-8">
                    Belum punya akun?
                    <button id="show-register" class="font-bold underline hover:text-blue-200">Klik di sini</button> untuk mendaftar.
                </p>
            </div>
            
            <div class="hidden md:flex flex-col items-center justify-center p-12">
                <img src="{{ asset('assets/images/timbangan.png') }}" alt="Ilustrasi" class="w-64 h-64 rounded-full object-cover mb-6 bg-gray-200">
                <h3 class="text-2xl font-bold text-gray-800 mb-2">SUARA RAKYAT</h3>
                <p class="text-gray-600 text-center">PENGADUAN DAN ASPIRASI PUBLIK</p>
            </div>
        </div>
    </div>

<div id="register-modal" class="relative w-full max-w-3xl bg-[#347ab7] text-white rounded-2xl shadow-xl hidden max-h-[90vh] flex flex-col">
        
        <div class="p-8 md:p-12 overflow-y-auto">
            <h2 class="text-2xl font-bold mb-8 text-center flex-shrink-0">Masukkan data diri Anda di bawah ini</h2>
            
            <form id="register-form">
                @csrf
                <div id="general-error" class="text-red-300 text-sm mb-4 hidden"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    
                    <div>
                        <div class="mb-4">
                            <label for="register-nik" class="block mb-2 text-sm font-medium">NIK</label>
                            <input type="text" id="register-nik" name="nik" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Masukkan NIK Anda">
                            <div id="error-nik" class="text-red-300 text-sm mt-1"></div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="register-tempat-tinggal" class="block mb-2 text-sm font-medium">Tempat Tinggal Saat ini</label>
                            <input type="text" id="register-tempat-tinggal" name="tempat_tinggal" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Masukkan tempat tinggal Anda saat ini">
                            <div id="error-tempat_tinggal" class="text-red-300 text-sm mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-3 text-sm font-medium">Jenis Kelamin</label>
                            <div class="flex gap-6 items-center">
                                <label for="jk-laki" class="flex items-center cursor-pointer">
                                    <input type="radio" id="jk-laki" name="jenis_kelamin" value="Laki-laki" class="form-radio h-4 w-4 text-blue-300 bg-gray-100 border-gray-100 focus:ring-blue-300">
                                    <span class="ml-2">Laki-laki</span>
                                </label>
                                <label for="jk-perempuan" class="flex items-center cursor-pointer">
                                    <input type="radio" id="jk-perempuan" name="jenis_kelamin" value="Perempuan" class="form-radio h-4 w-4 text-blue-300 bg-gray-100 border-gray-100 focus:ring-blue-300">
                                    <span class="ml-2">Perempuan</span>
                                </label>
                            </div>
                            <div id="error-jenis_kelamin" class="text-red-300 text-sm mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label for="register-pekerjaan" class="block mb-2 text-sm font-medium">Pekerjaan</label>
                            <input type="text" id="register-pekerjaan" name="pekerjaan" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Masukkan pekerjaan Anda">
                            <div id="error-pekerjaan" class="text-red-300 text-sm mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label for="register-username" class="block mb-2 text-sm font-medium">Username</label>
                            <input type="text" id="register-username" name="username" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Buat username Anda" required>
                            <div id="error-username" class="text-red-300 text-sm mt-1"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="mb-4">
                            <label for="register-name" class="block mb-2 text-sm font-medium">Nama Lengkap</label>
                            <input type="text" id="register-name" name="name" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Masukkan nama lengkap Anda" required>
                            <div id="error-name" class="text-red-300 text-sm mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label for="register-tanggal-lahir" class="block mb-2 text-sm font-medium">Tanggal Lahir</label>
                            <input type="date" id="register-tanggal-lahir" name="tanggal_lahir" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
                            <div id="error-tanggal_lahir" class="text-red-300 text-sm mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label for="register-telepon" class="block mb-2 text-sm font-medium">Nomor Telepon Aktif</label>
                            <input type="tel" id="register-telepon" name="telepon" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Masukkan nomor telepon Anda" required>
                            <div id="error-telepon" class="text-red-300 text-sm mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label for="register-email" class="block mb-2 text-sm font-medium">Email</label>
                            <input type="email" id="register-email" name="email" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Masukkan email Anda" required>
                            <div id="error-email" class="text-red-300 text-sm mt-1"></div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="register-password" class="block mb-2 text-sm font-medium">Password</label>
                            <div class="relative">
                                <input type="password" 
                                       id="register-password" 
                                       name="password" 
                                       class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300 pr-10" 
                                       placeholder="Buat password Anda" 
                                       required>
                                
                                <i id="toggle-register-password" 
                                   class="ri-eye-line absolute top-1/2 right-3 -translate-y-1/2 text-gray-800 cursor-pointer text-xl z-10"></i>
                                   </div>
                            <div id="error-password" class="text-red-300 text-sm mt-1"></div>
                        </div>
                        </div>
                </div> <div class="mt-6 flex items-center">
                    <input type="checkbox" id="register-terms" name="terms" class="form-checkbox h-4 w-4 rounded bg-gray-100 border-gray-100 text-blue-300 focus:ring-blue-300" required>
                    <label for="register-terms" class="ml-2 block text-sm text-white">
                        Saya telah membaca dan menyetujui <a href="#" class="font-bold underline hover:text-blue-200">Syarat dan Ketentuan Layanan</a>
                    </label>
                </div>
                <div id="error-terms" class="text-red-300 text-sm mt-1"></div>

                <button type="submit" id="register-submit-button" class="w-full mt-6 py-3 px-6 rounded-lg font-semibold bg-gray-200 text-gray-800 hover:bg-gray-300 transition-colors duration-300">
                    Daftar
                </button>
            </form>

            <p class="text-center text-sm mt-8">
                Sudah punya akun?
                <button id="show-login" class="font-bold underline hover:text-blue-200">Klik di sini</button> untuk masuk dengan Akun Anda.
            </p>
        </div>
    </div> </div>