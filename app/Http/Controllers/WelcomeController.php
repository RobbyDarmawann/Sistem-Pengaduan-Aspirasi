<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil laporan yang statusnya 'selesai' atau 'diproses' 
        // DAN visibilitasnya 'publik' atau 'anonim' (bukan rahasia)
        // Urutkan dari yang terbaru, ambil 5 data
        $laporanTerhangat = Laporan::with('pengguna')
            ->whereIn('status', ['diproses', 'selesai'])
            ->whereIn('visibilitas', ['publik', 'anonim'])
            ->latest()
            ->take(5)
            ->get();

        return view('welcome', compact('laporanTerhangat'));
    }
}