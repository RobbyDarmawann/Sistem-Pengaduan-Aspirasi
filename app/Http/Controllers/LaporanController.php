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
    public function create($tipe = null)
    {
        // Set tipe default ke 'pengaduan' jika tidak ada atau tidak valid
        $defaultTipe = ($tipe == 'aspirasi') ? 'aspirasi' : 'pengaduan';

        return view('laporan.create', [
            'defaultTipe' => $defaultTipe
        ]);
    }
}