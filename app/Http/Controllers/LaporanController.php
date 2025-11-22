<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class LaporanController extends Controller
{
    public function create($tipe = 'pengaduan')
    {
        return view('laporan.create', ['tipe' => $tipe]);
    }

    // --- TAMBAHKAN FUNGSI INI ---
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'kategori' => 'required|string',
            'instansi_tujuan' => 'required|string',
            'tipe_laporan' => 'required|in:pengaduan,aspirasi',
            'visibilitas' => 'required',
            'lampiran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
            // Tanggal & Lokasi wajib jika tipe = pengaduan
            'tanggal_kejadian' => 'required_if:tipe_laporan,pengaduan|nullable|date',
            'lokasi_kejadian' => 'required_if:tipe_laporan,pengaduan|nullable|string',
        ]);

        // 2. Upload Lampiran (Jika ada)
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran-laporan', 'public');
        }

        // 3. Simpan ke Database
        Laporan::create([
            'pengguna_id' => Auth::id(), // ID user yang sedang login
            'tipe_laporan' => $request->tipe_laporan,
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'lokasi_kejadian' => $request->lokasi_kejadian,
            'kategori' => $request->kategori,
            'instansi_tujuan' => $request->instansi_tujuan,
            'visibilitas' => $request->visibilitas,
            'status' => 'belum_disetujui', // Default status
            'lampiran' => $lampiranPath,
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect('/')->with('success', 'Laporan Anda berhasil dikirim dan menunggu verifikasi.');
    }
}