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

    {{-- Memanggil CSS dan JS utama, termasuk landing.js yang baru --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/landing.js'])

    {{-- Tag <style>...</style> sudah dipindahkan ke app.css --}}
</head>
<body class="bg-gray-50">

    {{-- 1. Memanggil Navbar dari file partial --}}
    @include('partials.navbar')

    {{-- 2. Memanggil Alert dari file partial --}}
    @include('partials.alert')

    {{-- 3. Konten Utama Halaman (Header) --}}
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

    {{-- 4. Konten Utama Halaman (Main) --}}
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

        <section id="masuk" class="py-20 bg-gray-50"> 
            <div class="container mx-auto px-5">
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

    {{-- 5. Memanggil Footer dari file partial --}}
    @include('partials.footer')

    {{-- 6. Memanggil Modal dari file partial --}}
    @include('partials.auth-modal')

    {{-- Tag <script>...</script> sudah dipindahkan ke landing.js --}}
</body>
</html>