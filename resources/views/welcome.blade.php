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

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/landing.js'])

    {{-- CSS KHUSUS UNTUK TIMELINE --}}
    <style>
        .timeline-container {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        @media (min-width: 768px) {
            .timeline-container::before {
                content: '';
                position: absolute;
                top: 3rem;
                left: 10%;
                width: 80%;
                height: 4px;
                background-color: #e5e7eb;
                z-index: 1;
            }
        }
        .timeline-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 0 0.5rem;
            width: 20%;
            position: relative;
            z-index: 2;
        }
        .timeline-icon-wrapper {
            position: relative;
            z-index: 2;
            width: 6rem;
            height: 6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background-color: #f9fafb; /* bg-gray-50 */
            padding: 0.5rem;
        }
        .timeline-icon-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        @media (max-width: 767px) {
            .timeline-container {
                min-width: 0;
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
                padding-left: 1rem;
                justify-content: flex-start;
            }
            .timeline-container::before {
                content: '';
                position: absolute;
                top: 1.25rem;
                bottom: 1.25rem;
                left: 2.25rem;
                width: 4px;
                height: auto;
                background-color: #e5e7eb;
                z-index: 1;
            }
            .timeline-step {
                flex-direction: row;
                align-items: center;
                text-align: left;
                width: 100%;
                padding: 0;
                gap: 1.5rem;
            }
            .timeline-step:last-child { padding-bottom: 0; }
            .timeline-icon-wrapper { width: 2.5rem; height: 2.5rem; flex-shrink: 0; }
            .timeline-step h3 { margin-top: 0; font-size: 1rem; line-height: 1.2; }
            .timeline-step p { max-w-none; font-size: 0.875rem; }
        }
    </style>
</head>
<body class="bg-gray-50">
    
    {{-- 1. Navbar --}}
    @include('partials.navbar')

    {{-- 2. Alert --}}
    @include('partials.alert')

    {{-- 3. Header Hero --}}
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
                        
                        @auth
                            <a href="{{ route('laporan.create', ['tipe' => 'pengaduan']) }}" class="inline-block py-3 px-8 rounded-full font-semibold bg-[#3996AF] text-white hover:bg-[#145D71] transition-all duration-300">
                                Buat Laporan <i class="ri-edit-line"></i>
                            </a>
                        @else
                            <a href="#masuk" class="inline-block py-3 px-8 rounded-full font-semibold bg-[#3996AF] text-white hover:bg-[#145D71] transition-all duration-300">
                                Buat Laporan <i class="ri-edit-line"></i>
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="hero-image order-1 md:order-2 flex justify-center">
                    <img src="{{ asset('assets/images/timbangan.png') }}" alt="Layanan Pengaduan Publik" class="w-full max-w-sm md:max-w-md h-auto rounded-full object-cover bg-gray-200">
                </div>
            </div>
        </div>
    </header>

    <main>
        {{-- Section Tentang --}}
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

        {{-- Section Masuk (Hanya Tampil Jika Belum Login) --}}
        @guest
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
                            <a href="{{ route('admin.login') }}" class="inline-block py-3 px-7 rounded-full font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-all duration-300">
                                Masuk
                            </a>
                        </div>
                        <div class="card-masuk bg-white rounded-xl shadow-md p-8 w-full md:w-96 text-center transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <img src="{{ asset('assets/images/profil-instansi.jpg') }}" alt="Instansi" class="w-24 h-24 rounded-full mx-auto mb-5 object-cover bg-gray-200">
                            <h3 class="text-2xl font-semibold mb-3 text-gray-800">Instansi</h3>
                            <p class="text-gray-600 mb-6">Terima dan tindak lanjuti laporan yang relevan, kelola data internal, dan berikan respon resmi kepada publik.</p>
                            <a href="{{ route('instansi.login') }}" class="inline-block py-3 px-7 rounded-full font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-all duration-300">
                                    Masuk
                                </a>
                        </div>
                    </div>
                </div> 
            </div>
        </section>
        @endguest

        {{-- Section Layanan --}}
        <section id="layanan" class="py-20 bg-white">
            <div class="container mx-auto px-5">
                <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-12">
                    Layanan Yang Disediakan
                </h2>
                
                <div class="flex flex-col md:flex-row justify-center items-center gap-8">
                    @auth
                        <a href="{{ route('laporan.create', ['tipe' => 'aspirasi']) }}" class="block w-11/12 md:w-auto transition-all duration-300 hover:-translate-y-2">
                    @else
                        <a href="#masuk" class="block w-11/12 md:w-auto transition-all duration-300 hover:-translate-y-2">
                    @endauth
                        <div class="card-layanan bg-white rounded-xl shadow-md w-full md:w-[420px] overflow-hidden hover:shadow-xl">
                            <img src="{{ asset('assets/images/layanan-aspirasi.jpg') }}" alt="Laporan Aspirasi" class="w-full h-64 object-cover bg-gray-200">
                            <div class="layanan-text bg-[#347ab7] p-8">
                                <h3 class="text-2xl font-semibold text-white mb-3">Laporan Aspirasi</h3>
                                <p class="text-blue-100 leading-relaxed">Sampaikan ide, gagasan, atau masukan konstruktif Anda untuk turut serta dalam perbaikan dan pengembangan layanan publik.</p>
                            </div>
                        </div>
                    </a>
                    
                    @auth
                        <a href="{{ route('laporan.create', ['tipe' => 'pengaduan']) }}" class="block w-11/12 md:w-auto transition-all duration-300 hover:-translate-y-2">
                    @else
                        <a href="#masuk" class="block w-11/12 md:w-auto transition-all duration-300 hover:-translate-y-2">
                    @endauth
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

        {{-- SECTION ALUR PROSES (BARU) --}}
        <section id="alur-proses" class="py-20 bg-gray-50">
            <div class="container mx-auto px-5 timeline-container-wrapper">
                <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-16">
                    Alur Proses Laporan
                </h2>
                
                <div class="timeline-container">
                    <div class="timeline-step">
                        <div class="timeline-icon-wrapper bg-teal-100">
                            <img src="{{ asset('assets/images/icon-tahapan-1.png') }}" alt="Tulis Laporan">
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mt-4 mb-2">Tulis Laporan Anda</h3>
                            <p class="text-gray-600 text-sm">Laporkan keluhan atau aspirasi anda dengan jelas dan lengkap.</p>
                        </div>
                    </div>

                    <div class="timeline-step">
                        <div class="timeline-icon-wrapper bg-red-100">
                            <img src="{{ asset('assets/images/icon-tahapan-2.png') }}" alt="Proses Verifikasi">
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mt-4 mb-2">Proses Verifikasi</h3>
                            <p class="text-gray-600 text-sm">Dalam 3 hari, laporan Anda akan diverifikasi dan diteruskan kepada instansi berwenang.</p>
                        </div>
                    </div>

                    <div class="timeline-step">
                        <div class="timeline-icon-wrapper bg-yellow-100">
                            <img src="{{ asset('assets/images/icon-tahapan-3.png') }}" alt="Proses Tindak Lanjut">
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mt-4 mb-2">Proses Tindak Lanjut</h3>
                            <p class="text-gray-600 text-sm">Dalam 5 hari, instansi akan menindaklanjuti dan membalas laporan Anda.</p>
                        </div>
                    </div>

                    <div class="timeline-step">
                        <div class="timeline-icon-wrapper bg-green-100">
                            <img src="{{ asset('assets/images/icon-tahapan-4.png') }}" alt="Beri Tanggapan">
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mt-4 mb-2">Beri Tanggapan</h3>
                            <p class="text-gray-600 text-sm">Anda dapat menanggapi kembali balasan yang diberikan oleh instansi dalam waktu 10 hari.</p>
                        </div>
                    </div>

                    <div class="timeline-step">
                        <div class="timeline-icon-wrapper bg-blue-100">
                            <img src="{{ asset('assets/images/icon-tahapan-5.png') }}" alt="Selesai">
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mt-4 mb-2">Selesai</h3>
                            <p class="text-gray-600 text-sm">Laporan Anda akan terus ditindaklanjuti hingga terselesaikan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section Laporan Terhangat --}}
        <section id="laporan-terhangat" class="py-20 bg-white">
            <div class="container mx-auto w-full px-5 md:px-20">
                <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-12">
                    Laporan Terhangat
                </h2>
                
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($laporanTerhangat as $laporan)
                <a href="{{ route('laporan.show', $laporan->id) }}" class="block group relative -top-[20px] hover:top-[-25px] transition-all duration-300">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full flex flex-colhover:shadow-md transition-shadow">
                        
                        <div class="p-4 flex items-center gap-3 border-b border-gray-50">
                            <img src="{{ $laporan->visibilitas == 'anonim' ? asset('assets/images/logo-icon.png') : ($laporan->pengguna->profile_photo_path ? asset('storage/'.$laporan->pengguna->profile_photo_path) : asset('assets/images/profil-pengguna.jpg')) }}" 
                                 class="w-9 h-9 rounded-full object-cover border border-gray-100">
                            <div class="flex-1 truncate">
                                <h4 class="text-sm font-bold text-gray-800 truncate">
                                    {{ $laporan->visibilitas == 'anonim' ? 'Anonim' : explode(' ', $laporan->pengguna->full_name)[0] }}
                                </h4>
                                <p class="text-xs text-gray-400">{{ $laporan->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                @if($laporan->tipe_laporan == 'pengaduan')
                                    <span class="text-[10px] font-bold bg-red-50 text-red-600 px-2 py-0.5 rounded border border-red-100">PENGADUAN</span>
                                @else
                                    <span class="text-[10px] font-bold bg-blue-50 text-blue-600 px-2 py-0.5 rounded border border-blue-100">ASPIRASI</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="font-bold text-base text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                                {{ $laporan->judul }}
                            </h3>
                            <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed mb-3 flex-1">
                                {{ $laporan->isi_laporan }}
                            </p>
                            
                            <div class="flex items-center gap-1 text-xs text-gray-500 bg-gray-50 p-1.5 rounded w-fit max-w-full mt-auto">
                                <i class="ri-building-4-line flex-shrink-0"></i>
                                <span class="truncate">{{ $laporan->instansi_tujuan }}</span>
                            </div>
                        </div>

                        <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center text-xs text-gray-500">
                            <div class="flex gap-3 items-center">
                                <span class="flex items-center gap-1 text-blue-600 font-bold bg-blue-50 px-1.5 py-0.5 rounded" title="Dilihat">
                                    <i class="ri-eye-fill"></i> {{ number_format($laporan->jumlah_dilihat) }}
                                </span>
                                <span class="flex items-center gap-1" title="Dukungan">
                                    <i class="ri-thumb-up-line"></i> {{ $laporan->jumlah_dukungan }}
                                </span>
                                <span class="flex items-center gap-1" title="Komentar">
                                    <i class="ri-chat-1-line"></i> {{ $laporan->komentars_count }}
                                </span>
                            </div>
                            
                            <div>
                                @if($laporan->status == 'selesai')
                                    <span class="font-bold text-green-600 flex items-center gap-1"><i class="ri-checkbox-circle-fill"></i> Selesai</span>
                                @elseif($laporan->status == 'diproses')
                                    <span class="font-bold text-yellow-600 flex items-center gap-1"><i class="ri-loader-4-fill"></i> Diproses</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <i class="ri-fire-line text-4xl text-gray-300 mb-3 block"></i>
                    <p class="text-gray-500 font-medium">Belum ada laporan yang cukup hangat untuk ditampilkan.</p>
                    <p class="text-sm text-gray-400 mt-1">Jadilah yang pertama berpartisipasi!</p>
                </div>
            @endforelse
        </div>
            </div>
        </section>
    </main>

    {{-- Footer & Modal --}}
    @include('partials.footer')
    @include('partials.auth-modal')

</body>
</html>