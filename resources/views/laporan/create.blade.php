@extends('layouts.app')

@section('title', 'Buat Laporan - SuaraGO')

@section('content')
<main class="py-10 md:py-16">
    <div class="container mx-auto px-5">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-8 md:p-12">
            
            <div class="w-full max-w-xs mx-auto bg-blue-600 text-white text-center py-3 rounded-lg text-xl font-semibold mb-8">
                Laporan
            </div>

            <form action="#" method="POST">
                @csrf
                
                <div class="flex flex-col md:flex-row justify-center gap-4 mb-8">
                    <label for="radio_pengaduan" class="flex-1">
                        <input type="radio" id="radio_pengaduan" name="tipe_laporan" value="pengaduan" class="hidden peer">
                        <div class="w-full py-3 px-6 rounded-lg border border-gray-300 text-gray-600 text-center font-semibold cursor-pointer peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition-all">
                            <i class="ri-error-warning-line mr-2"></i> Pengaduan
                        </div>
                    </label>
                    <label for="radio_aspirasi" class="flex-1">
                        <input type="radio" id="radio_aspirasi" name="tipe_laporan" value="aspirasi" class="hidden peer">
                        <div class="w-full py-3 px-6 rounded-lg border border-gray-300 text-gray-600 text-center font-semibold cursor-pointer peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition-all">
                            <i class="ri-lightbulb-flash-line mr-2"></i> Aspirasi
                        </div>
                    </label>
                </div>

                <div class="space-y-5">
                    <input type="text" name="judul" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ketik Judul Laporan Anda*" required>
                    
                    <textarea name="isi_laporan" rows="6" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ketik Isi Laporan Anda*" required></textarea>
                    
                    <div class="relative">
                        <input type="date" name="tanggal_kejadian" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Pilih Tanggal Kejadian*" required>
                        <i class="ri-calendar-line absolute top-1/2 right-4 -translate-y-1/2 text-gray-500"></i>
                    </div>

                    <select name="kategori" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Kategori Laporan Anda*</option>
                        <option value="infrastruktur">Infrastruktur</option>
                        <option value="pelayanan_publik">Pelayanan Publik</option>
                        <option value="keamanan">Keamanan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>

                    <select name="instansi_tujuan" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Ketik Instansi Tujuan*</option>
                        <option value="dinas_pu">Dinas Pekerjaan Umum</option>
                        <option value="dinas_pendidikan">Dinas Pendidikan</option>
                        <option value="kepolisian">Kepolisian</option>
                    </select>

                    <select name="lokasi_kejadian" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Ketik Lokasi Kejadian*</option>
                        <option value="gorontalo">Gorontalo</option>
                        <option value="manado">Manado</option>
                    </select>

                    <div>
                        <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="ri-upload-cloud-line mr-1"></i> Upload Lampiran (Opsional)
                        </label>
                        <input type="file" name="lampiran" id="lampiran" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-4">
                        <div class="flex gap-6">
                            <label for="anonim" class="flex items-center cursor-pointer">
                                <input type="radio" id="anonim" name="visibilitas" value="anonim" class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-gray-700">Anonim</span>
                            </label>
                            <label for="rahasia" class="flex items-center cursor-pointer">
                                <input type="radio" id="rahasia" name="visibilitas" value="rahasia" class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-2 text-gray-700">Rahasia</span>
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full md:w-auto py-3 px-10 rounded-lg font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-all">
                            Kirim
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil tipe default dari controller yang dikirim ke view
        const defaultTipe = @json($defaultTipe);

        if (defaultTipe === 'aspirasi') {
            document.getElementById('radio_aspirasi').checked = true;
        } else {
            // Default ke pengaduan jika 'pengaduan' atau null
            document.getElementById('radio_pengaduan').checked = true;
        }
    });
</script>
@endpush