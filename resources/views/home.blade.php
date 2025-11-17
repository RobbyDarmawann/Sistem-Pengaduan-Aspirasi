@extends('layouts.app')

@section('title', 'Dashboard - SuaraGO')
@push('styles')
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
@endpush


@section('content')
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
                        <a href="{{ route('laporan.create', ['tipe' => 'pengaduan']) }}" class="inline-block py-3 px-8 rounded-full font-semibold bg-[#3996AF] text-white hover:bg-[#145D71] transition-all duration-300">
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
                    
                    <a href="{{ route('laporan.create', ['tipe' => 'aspirasi']) }}" class="block w-11/12 md:w-auto transition-all duration-300 hover:-translate-y-2">
                        <div class="card-layanan bg-white rounded-xl shadow-md w-full md:w-[420px] overflow-hidden hover:shadow-xl">
                            <img src="{{ asset('assets/images/layanan-aspirasi.jpg') }}" alt="Laporan Pengaduan" class="w-full h-64 object-cover bg-gray-200">
                            <div class="layanan-text bg-[#347ab7] p-8">
                                <h3 class="text-2xl font-semibold text-white mb-3">Laporan Aspirasi</h3>
                                <p class="text-blue-100 leading-relaxed">Sampaikan ide, gagasan, atau masukan konstruktif untuk turut serta dalam perbaikan dan pengembangan layanan publik yang baik.</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('laporan.create', ['tipe' => 'pengaduan']) }}" class="block w-11/12 md:w-auto transition-all duration-300 hover:-translate-y-2">
                        <div class="card-layanan bg-white rounded-xl shadow-md w-full md:w-[420px] overflow-hidden hover:shadow-xl">
                            <img src="{{ asset('assets/images/layanan-pengaduan.png') }}" alt="Laporan Pengaduan" class="w-full h-64 object-cover bg-gray-200">
                            <div class="layanan-text bg-[#347ab7] p-8">
                                <h3 class="text-2xl font-semibold text-white mb-3">Laporan Pengaduan</h3>
                                <p class="text-blue-100 leading-relaxed">Adukan setiap permasalahan, penyimpangan, atau ketidakpuasan anda terhadap layanan pemerintah agar segera ditindaklanjuti.</p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </section>

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
            <div class="container mx-auto w-full px-5 md:px-20">
                <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-12">
                    Laporan Terhangat
                </h2>
                <div class="space-y-6">
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
                </div>
            </div>
        </section>
    </main>
@endsection