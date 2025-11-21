<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;

class LaporanController extends Controller
{
public function index(Request $request)
    {
        $query = Laporan::with('pengguna');

        // 1. Filter berdasarkan Tipe (Jika dipilih)
        if ($request->has('tipe') && $request->tipe != 'all') {
            $query->where('tipe_laporan', $request->tipe);
        }

        // 2. Filter berdasarkan Status (Jika dipilih)
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // 3. Custom Ordering (Urutan Prioritas)
        // Kita ingin urutan: Belum Disetujui (1) -> Diproses (2) -> Selesai (3) -> Ditolak (4)
        // Kita gunakan orderByRaw dengan CASE statement (Support SQLite & MySQL)
        $query->orderByRaw("
            CASE status
                WHEN 'belum_disetujui' THEN 1
                WHEN 'diproses' THEN 2
                WHEN 'disetujui' THEN 2 
                WHEN 'selesai' THEN 3
                WHEN 'ditolak' THEN 4
                ELSE 5
            END ASC
        ");

        // Urutkan berdasarkan tanggal terbaru juga (sebagai prioritas kedua)
        $query->latest();

        $laporan = $query->paginate(10);

        return view('admin.laporan.index', compact('laporan'));
    }

    public function show($id)
    {
        // Cari laporan berdasarkan ID, jika tidak ada tampilkan 404
        $laporan = Laporan::with('pengguna')->findOrFail($id);

        return view('admin.laporan.show', compact('laporan'));
    }

    /**
     * Memproses Persetujuan atau Penolakan Laporan.
     */
    public function verifikasi(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        // Validasi aksi yang dikirim dari tombol
        if ($request->action === 'tolak') {
            $laporan->status = 'ditolak';
            $pesan = 'Laporan berhasil ditolak.';
        } elseif ($request->action === 'setujui') {
            $laporan->status = 'diproses'; // Status naik ke 'diproses' (diteruskan ke instansi)
            $pesan = 'Laporan disetujui dan diteruskan ke instansi terkait.';
        } else {
            return back()->with('error', 'Aksi tidak valid.');
        }

        $laporan->save();

        return redirect()->route('admin.laporan.index')->with('success', $pesan);
    }
}