@extends('layouts.admin')

@section('title', 'Detail Laporan')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="flex justify-center">
    <div class="w-full max-w-4xl">
        
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('admin.laporan.index') }}" class="px-4 py-2 bg-[#3282B8] text-white rounded-lg font-medium hover:bg-[#1B6CA8] transition-colors flex items-center gap-2">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
            <div class="bg-[#3282B8] text-white px-8 py-2 rounded-lg font-bold text-lg shadow-sm">
                Laporan
            </div>
            <div class="w-24"></div> 
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8 md:p-10 border border-gray-200">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block font-bold text-gray-800 mb-2">Klasifikasi</label>
                    <input type="text" value="{{ ucfirst($laporan->tipe_laporan) }}" readonly 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-700 cursor-default">
                </div>
                <div>
                    <label class="block font-bold text-gray-800 mb-2">Tanggal Dibuat</label>
                    <input type="text" value="{{ $laporan->created_at->format('d F Y, H:i') }}" readonly 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-700 cursor-default">
                </div>
            </div>

            <div class="mb-5">
                <label class="block font-bold text-gray-800 mb-2">Judul Laporan</label>
                <input type="text" value="{{ $laporan->judul }}" readonly 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-700 font-medium cursor-default">
            </div>

            <div class="mb-5">
                <label class="block font-bold text-gray-800 mb-2">Isi Laporan</label>
                <textarea rows="6" readonly 
                          class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-700 cursor-default leading-relaxed">{{ $laporan->isi_laporan }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block font-bold text-gray-800 mb-2">Nama Pelapor</label>
                    <input type="text" value="{{ $laporan->visibilitas == 'anonim' ? 'Anonim' : $laporan->pengguna->full_name }}" readonly 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-700 cursor-default">
                </div>
                <div>
                    <label class="block font-bold text-gray-800 mb-2">Instansi Tujuan</label>
                    <input type="text" value="{{ ucwords(str_replace('_', ' ', $laporan->instansi_tujuan)) }}" readonly 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-700 cursor-default">
                </div>
            </div>

            <div class="mb-8">
                <label class="block font-bold text-gray-800 mb-2">Lampiran File</label>
                @if($laporan->lampiran)
                    <div class="flex gap-4 overflow-x-auto pb-2">
                        <img src="{{ asset('storage/' . $laporan->lampiran) }}" alt="Lampiran" class="h-32 w-auto rounded-lg border border-gray-300 shadow-sm cursor-pointer hover:opacity-90 transition-opacity" onclick="window.open(this.src, '_blank')">
                    </div>
                @else
                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-500 italic">
                        Tidak ada lampiran.
                    </div>
                @endif
            </div>

            @if($laporan->status == 'belum_disetujui')
                <form id="verifikasi-form" action="{{ route('admin.laporan.verifikasi', $laporan->id) }}" method="POST" class="flex flex-col sm:flex-row justify-center gap-4 mt-10 pt-6 border-t border-gray-100">
                    @csrf
                    @method('PATCH')
                    
                    <input type="hidden" name="action" id="action-input">

                    <button type="button" onclick="konfirmasiAksi('tolak')" class="w-full sm:w-48 py-3 px-6 rounded-lg bg-[#DC2626] hover:bg-[#B91C1C] text-white font-bold text-lg shadow-md transition-all transform hover:scale-105 flex justify-center items-center gap-2">
                        <i class="ri-close-circle-line"></i> Tolak
                    </button>

                    <button type="button" onclick="konfirmasiAksi('setujui')" class="w-full sm:w-48 py-3 px-6 rounded-lg bg-[#10B981] hover:bg-[#059669] text-white font-bold text-lg shadow-md transition-all transform hover:scale-105 flex justify-center items-center gap-2">
                        <i class="ri-check-double-line"></i> Setujui
                    </button>
                </form>
            @else
                <div class="mt-8 p-4 rounded-lg text-center font-bold text-white {{ $laporan->status == 'ditolak' ? 'bg-red-500' : 'bg-green-500' }}">
                    Status Laporan: {{ strtoupper(str_replace('_', ' ', $laporan->status)) }}
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    function konfirmasiAksi(aksi) {
        let titleText = '';
        let bodyText = '';
        let confirmBtnColor = '';
        let iconType = '';

        // Tentukan isi pesan berdasarkan tombol yang ditekan
        if (aksi === 'tolak') {
            titleText = 'Tolak Laporan?';
            bodyText = 'Laporan ini akan ditandai sebagai ditolak dan tidak diteruskan.';
            confirmBtnColor = '#DC2626'; // Merah
            iconType = 'warning';
        } else {
            titleText = 'Setujui Laporan?';
            bodyText = 'Laporan akan diproses dan diteruskan ke instansi terkait.';
            confirmBtnColor = '#10B981'; // Hijau
            iconType = 'question';
        }

        // Tampilkan SweetAlert
        Swal.fire({
            title: titleText,
            text: bodyText,
            icon: iconType,
            showCancelButton: true,
            confirmButtonColor: confirmBtnColor,
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true // Tombol batal di kiri, ya di kanan
        }).then((result) => {
            if (result.isConfirmed) {
                // 1. Isi input hidden dengan aksi yang dipilih
                document.getElementById('action-input').value = aksi;
                
                // 2. Submit form secara manual
                document.getElementById('verifikasi-form').submit();
            }
        });
    }
</script>

@endsection