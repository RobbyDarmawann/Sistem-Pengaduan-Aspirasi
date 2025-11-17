<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan form untuk membuat laporan baru.
     *
     * @param  string|null  $tipe
     * @return \Illuminate\View\View
     */
        public function create($tipe = 'pengaduan') // 1. Terima $tipe dari route
    {
        // 2. Kirim variabel $tipe ke view
        return view('laporan.create', [
            'tipe' => $tipe
        ]);
    }
}