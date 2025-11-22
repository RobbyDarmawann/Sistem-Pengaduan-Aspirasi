<?php

namespace App\Http\Controllers\Instansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;

class DashboardController extends Controller
{
  public function index()
    {
        // 1. Ambil data Instansi
        $instansi = Auth::guard('instansi')->user();

        // 2. Query Dasar (Laporan yang tujuannya ke instansi ini)
        $query = Laporan::where('instansi_tujuan', $instansi->instance_name);

        // 3. Hitung Statistik (LENGKAPI SEMUA KEY DI SINI)
        $stats = [
            // --- KARTU MERAH (Belum Ditindaklanjut) ---
            // Kita anggap status 'diproses' dari admin = baru masuk di instansi (belum disentuh)
            'aspirasi_belum' => (clone $query)->where('tipe_laporan', 'aspirasi')->where('status', 'diproses')->count(),
            'laporan_belum'  => (clone $query)->where('tipe_laporan', 'pengaduan')->where('status', 'diproses')->count(),

            // --- KARTU KUNING (Sedang Ditindaklanjut) ---
            // Saat ini kita set 0 dulu atau sama dengan diproses jika belum ada status khusus
            // Agar tidak error, kita wajib mendefinisikan key ini
            'aspirasi_proses' => 0, 
            'laporan_proses'  => 0,

            // --- KARTU HIJAU (Sudah Ditindaklanjut/Selesai) ---
            'aspirasi_selesai' => (clone $query)->where('tipe_laporan', 'aspirasi')->where('status', 'selesai')->count(),
            'laporan_selesai'  => (clone $query)->where('tipe_laporan', 'pengaduan')->where('status', 'selesai')->count(),
        ];

        // 4. Ambil Daftar Laporan & Aspirasi untuk Tabel
        $daftarLaporan = (clone $query)->where('tipe_laporan', 'pengaduan')
                                       ->whereIn('status', ['diproses', 'selesai'])
                                       ->latest()->get();

        $daftarAspirasi = (clone $query)->where('tipe_laporan', 'aspirasi')
                                        ->whereIn('status', ['diproses', 'selesai'])
                                        ->latest()->get();

        return view('instansi.dashboard', compact('instansi', 'stats', 'daftarLaporan', 'daftarAspirasi'));
    }
}