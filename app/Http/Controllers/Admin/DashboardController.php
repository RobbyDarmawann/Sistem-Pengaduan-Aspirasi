<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Asumsi Anda punya model Laporan
use App\Models\Laporan; 

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data untuk stat cards
        // Ganti 'belum_disetujui', 'diproses', 'selesai' dengan status Anda
        $laporanBelumDisetujui = Laporan::where('status', 'belum_disetujui')->count();
        $laporanSedangDiproses = Laporan::where('status', 'diproses')->count();
        $laporanSelesai = Laporan::where('status', 'selesai')->count();

        // Ambil data untuk tabel (5 terbaru yang menunggu)
        $laporanTerbaru = Laporan::where('status', 'belum_disetujui')
                                  ->orderBy('created_at', 'desc')
                                  ->take(5)
                                  ->get();

        return view('admin.dashboard', compact(
            'laporanBelumDisetujui',
            'laporanSedangDiproses',
            'laporanSelesai',
            'laporanTerbaru'
        ));
    }
}