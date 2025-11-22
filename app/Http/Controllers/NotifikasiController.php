<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Ambil notifikasi user, urutkan dari terbaru
        $notifikasi = Notifikasi::where('pengguna_id', $user->id)
                                ->latest()
                                ->get();

        // Tandai semua sebagai sudah dibaca saat membuka halaman ini
        Notifikasi::where('pengguna_id', $user->id)->where('is_read', false)->update(['is_read' => true]);

        return view('notifikasi.index', compact('notifikasi'));
    }
}