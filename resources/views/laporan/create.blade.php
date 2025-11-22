@extends('layouts.app')

@section('title', 'Buat Laporan - SuaraGO')

@section('content')
<main class="py-10 md:py-16">
    <div class="container mx-auto px-5">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-8 md:p-12">
            
            <div class="w-full max-w-xs mx-auto bg-blue-600 text-white text-center py-3 rounded-lg text-xl font-semibold mb-8">
                <span id="form-title">Laporan Pengaduan</span>
            </div>

            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data"> 
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
                    
                    <div id="tanggal-kejadian-wrapper" class="relative">
                        <input type="text" id="tanggal-kejadian-input" name="tanggal_kejadian" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Pilih Tanggal Kejadian*" required>
                        <i class="ri-calendar-line absolute top-1/2 right-4 -translate-y-1/2 text-gray-500"></i>
                    </div>

                    <select name="kategori" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Kategori Laporan Anda*</option>
                        <option value="Agama">Agama</option>
                        <option value="Ekonomi & Keuangan">Ekonomi & Keuangan</option>
                        <option value="Energi dan Sumber Daya Alam">Energi dan Sumber Daya Alam</option>
                        <option value="Kesehatan">Kesehatan</option>
                        <option value="Kekerasan di Satuan Pendidikan">Kekerasan di Satuan Pendidikan</option>
                        <option value="Kependudukan">Kependudukan</option>
                        <option value="Kesetaraan Gender & Sosial Inklusif">Kesetaraan Gender & Sosial Inklusif</option>
                        <option value="Ketenagakerjaan">Ketenagakerjaan</option>
                        <option value="Ketentraman, Ketertiban Umum & Perlindungan Masyarakat">Ketentraman, Ketertiban Umum</option>
                        <option value="Lingkungan Hidup & Kehutanan">Lingkungan Hidup & Kehutanan</option>
                        <option value="Pekerjaan Umum & Penataan Ruang">Pekerjaan Umum & Penataan Ruang</option>
                        <option value="Pembangunan Desa, Daerah Tertinggal">Pembangunan Desa, Daerah Tertinggal</option>
                        <option value="Pemulihan Ekonomi Nasional">Pemulihan Ekonomi Nasional</option>
                        <option value="Pendidikan & Kebudayaan">Pendidikan & Kebudayaan</option>
                        <option value="Perairan">Perairan</option>
                        <option value="Perhubungan">Perhubungan</option>
                        <option value="Perlindungan Konsumen">Perlindungan Konsumen</option>
                        <option value="Pertanian & Peternakan">Pertanian & Peternakan</option>
                        <option value="Politik & Hukum">Politik & Hukum</option>
                        <option value="Program Makan Bergizi Gratis">Program Makan Bergizi Gratis</option>
                        <option value="Sosial Kesejahteraan">Sosial Kesejahteraan</option>
                        <option value="Teknologi Informasi dan Komunikasi">Teknologi Informasi dan Komunikasi</option>
                    </select>

                    <div class="relative">
                        <input type="hidden" name="instansi_tujuan" id="instansi_input" required>
                        
                        <button type="button" onclick="toggleDropdown()" id="instansi_btn" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-500 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 flex justify-between items-center">
                            <span>Pilih Instansi Tujuan*</span>
                            <i class="ri-arrow-down-s-line"></i>
                        </button>

                        <div id="instansi_list" class="hidden absolute z-10 w-full bg-white border border-gray-200 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto">
                            
                            <div class="px-4 py-2 bg-gray-50 font-bold text-xs text-gray-500 uppercase">Provinsi & Kota</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Provinsi Gorontalo')">Pemerintah Provinsi Gorontalo</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Kota Gorontalo')">Pemerintah Kota Gorontalo</div>

                            <div class="px-4 py-2 bg-gray-50 font-bold text-xs text-gray-500 uppercase border-t">Kecamatan Kota Gorontalo</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Kecamatan Kota Barat, Kota Gorontalo')">Pemerintah Kecamatan Kota Barat</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Kecamatan Dungingi, Kota Gorontalo')">Pemerintah Kecamatan Dungingi</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Kecamatan Kota Selatan, Kota Gorontalo')">Pemerintah Kecamatan Kota Selatan</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Kecamatan Kota Timur, Kota Gorontalo')">Pemerintah Kecamatan Kota Timur</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Kecamatan Kota Utara, Kota Gorontalo')">Pemerintah Kecamatan Kota Utara</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Kecamatan Hulonthalangi, Kota Gorontalo')">Pemerintah Kecamatan Hulonthalangi</div>

                            <div class="px-4 py-2 bg-gray-50 font-bold text-xs text-gray-500 uppercase border-t">Kabupaten Gorontalo</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Kabupaten Gorontalo')">Pemerintah Kabupaten Gorontalo</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Kecamatan Limboto, Kabupaten Gorontalo')">Pemerintah Kecamatan Limboto</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Kecamatan Telaga, Kabupaten Gorontalo')">Pemerintah Kecamatan Telaga</div>
                            <div class="option-item px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm" onclick="selectInstansi('Pemerintah Kecamatan Tibawa, Kabupaten Gorontalo')">Pemerintah Kecamatan Tibawa</div>
                        </div>
                    </div>

                    <div id="lokasi-kejadian-wrapper">
                        <select name="lokasi_kejadian" id="lokasi-kejadian-input" class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Pilih Lokasi Kejadian*</option>
                            <optgroup label="Kota Gorontalo">
                                <option value="Kecamatan Kota Barat, Kota Gorontalo">Kecamatan Kota Barat</option>
                                <option value="Kecamatan Dungingi, Kota Gorontalo">Kecamatan Dungingi</option>
                                </optgroup>
                            <optgroup label="Kabupaten Gorontalo">
                                <option value="Kecamatan Limboto, Kabupaten Gorontalo">Kecamatan Limboto</option>
                                </optgroup>
                        </select>
                    </div>

                    <div>
                        <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="ri-upload-cloud-line mr-1"></i> Upload Lampiran (Opsional)
                        </label>
                        <input type="file" name="lampiran" id="lampiran" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Opsi Privasi Laporan:</label>
                        
                        <div class="flex flex-col gap-3">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="check_anonim" class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                                <div class="ml-3">
                                    <span class="block text-sm font-bold text-gray-800">Anonim</span>
                                    <span class="block text-xs text-gray-500">Nama Anda tidak akan ditampilkan ke publik.</span>
                                </div>
                            </label>

                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="check_rahasia" class="w-5 h-5 text-red-600 rounded focus:ring-red-500 border-gray-300">
                                <div class="ml-3">
                                    <span class="block text-sm font-bold text-gray-800">Rahasia</span>
                                    <span class="block text-xs text-gray-500">Laporan Anda tidak akan bisa dilihat oleh publik (Hanya Anda, Admin & Instansi).</span>
                                </div>
                            </label>
                        </div>

                        <input type="hidden" name="visibilitas" id="visibilitas_input" value="publik">
                    </div>

                    <button type="submit" class="w-full mt-6 py-3 px-10 rounded-lg font-bold bg-blue-600 text-white hover:bg-blue-700 transition-all shadow-md">
                        Kirim Laporan
                    </button>

                </div>
            </form>

        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // --- LOGIKA CUSTOM DROPDOWN INSTANSI ---
    function toggleDropdown() {
        const list = document.getElementById('instansi_list');
        list.classList.toggle('hidden');
    }

    function selectInstansi(value) {
        // Set value ke input hidden
        document.getElementById('instansi_input').value = value;
        
        // Ubah teks tombol
        const btn = document.getElementById('instansi_btn');
        btn.querySelector('span').textContent = value;
        btn.classList.remove('text-gray-500');
        btn.classList.add('text-gray-800', 'font-medium'); // Ubah warna teks jadi gelap

        // Tutup dropdown
        document.getElementById('instansi_list').classList.add('hidden');
    }

    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function(e) {
        const btn = document.getElementById('instansi_btn');
        const list = document.getElementById('instansi_list');
        if (!btn.contains(e.target) && !list.contains(e.target)) {
            list.classList.add('hidden');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // --- LOGIKA VISIBILITAS (CHECKBOX) ---
        const checkAnonim = document.getElementById('check_anonim');
        const checkRahasia = document.getElementById('check_rahasia');
        const inputVisibilitas = document.getElementById('visibilitas_input');

        function updateVisibilitas() {
            if (checkRahasia.checked) {
                // Jika Rahasia dicentang, prioritas tertinggi (otomatis hidden dari publik)
                // Kita bisa set value jadi 'rahasia'
                inputVisibilitas.value = 'rahasia';
            } else if (checkAnonim.checked) {
                // Jika cuma Anonim
                inputVisibilitas.value = 'anonim';
            } else {
                // Jika tidak ada yang dicentang
                inputVisibilitas.value = 'publik';
            }
            console.log("Visibilitas set to: " + inputVisibilitas.value);
        }

        checkAnonim.addEventListener('change', updateVisibilitas);
        checkRahasia.addEventListener('change', updateVisibilitas);


        // --- LOGIKA TIPE LAPORAN (Show/Hide Tanggal & Lokasi) ---
        const radioAspirasi = document.getElementById('radio_aspirasi');
        const radioPengaduan = document.getElementById('radio_pengaduan');
        const formTitle = document.getElementById('form-title');
        const tanggalWrapper = document.getElementById('tanggal-kejadian-wrapper');
        const tanggalInput = document.getElementById('tanggal-kejadian-input');
        const lokasiWrapper = document.getElementById('lokasi-kejadian-wrapper');
        const lokasiInput = document.getElementById('lokasi-kejadian-input');

        const defaultTipe = @json($tipe ?? 'pengaduan');

        function updateFormTipe() {
            if (radioAspirasi.checked) {
                tanggalWrapper.style.display = 'none';
                tanggalInput.required = false;
                lokasiWrapper.style.display = 'none';
                lokasiInput.required = false;
                formTitle.textContent = 'Laporan Aspirasi';
            } else {
                tanggalWrapper.style.display = 'block';
                tanggalInput.required = true;
                lokasiWrapper.style.display = 'block';
                lokasiInput.required = true;
                formTitle.textContent = 'Laporan Pengaduan';
            }
        }

        if (defaultTipe === 'aspirasi') {
            radioAspirasi.checked = true;
        } else {
            radioPengaduan.checked = true;
        }
        updateFormTipe();

        radioAspirasi.addEventListener('change', updateFormTipe);
        radioPengaduan.addEventListener('change', updateFormTipe);

        // Placeholder tanggal fix
        tanggalInput.addEventListener('focus', function() { this.type = 'date'; });
        tanggalInput.addEventListener('blur', function() { if (this.value === '') { this.type = 'text'; } });
        tanggalInput.dispatchEvent(new Event('blur'));
    });
</script>
@endpush