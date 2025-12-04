<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

class WelcomeController extends Controller
{
    public function index()
    {
        // LOGIKA LAPORAN TERHANGAT (Berdasarkan View Terbanyak)
        $laporanTerhangat = Laporan::with('pengguna', 'komentars') // Load relasi
            ->whereIn('status', ['diproses', 'selesai']) // Hanya yang sudah diproses/selesai
            ->whereIn('visibilitas', ['publik', 'anonim']) // Hanya yang publik/anonim
            ->orderBy('jumlah_dilihat', 'desc') // <--- URUTKAN DARI VIEW TERBANYAK
            ->take(5) // Ambil 5 saja
            ->get();

        return view('welcome', compact('laporanTerhangat'));
    }
}