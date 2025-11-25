<?php

namespace App\Http\Controllers\Instansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\TindakLanjut;
use App\Models\Komentar;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function show($id)
    {
        $laporan = Laporan::with(['pengguna', 'komentars', 'tindakLanjuts'])->findOrFail($id);
        $instansi = Auth::guard('instansi')->user();

        // Pastikan instansi hanya melihat laporan miliknya
        // PERBAIKAN: Gunakan 'instance_name'
        if ($laporan->instansi_tujuan !== $instansi->instance_name) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        $laporan->increment('jumlah_dilihat');

        return view('instansi.laporan.show', compact('laporan'));
    }

    public function storeTindakLanjut(Request $request, $id)
    {
        $request->validate(['isi_tindak_lanjut' => 'required|string']);

        $laporan = Laporan::findOrFail($id);
        $instansi = Auth::guard('instansi')->user();
        dd($instansi);
        // 1. Simpan Tindak Lanjut
        TindakLanjut::create([
            'laporan_id' => $id,
            
            // --- PERBAIKAN DI SINI (Ganti nama_instansi jadi instance_name) ---
            'instansi_nama' => $instansi->instance_name, 
            // ------------------------------------------------------------------

            'isi_tindak_lanjut' => $request->isi_tindak_lanjut,
            'waktu_tindak_lanjut' => now(),
        ]);

        // 2. Buat Notifikasi ke Pengguna
        Notifikasi::create([
            'pengguna_id' => $laporan->pengguna_id,
            'laporan_id' => $laporan->id,
            'judul' => 'Tindak Lanjut Baru',
            
            // --- PERBAIKAN DI SINI JUGA ---
            'pesan' => $instansi->instance_name . ' telah memberikan update terbaru mengenai laporan Anda.',
            // ------------------------------

            'tipe' => 'info'
        ]);

        return back()->with('success', 'Tindak lanjut berhasil dikirim.');
    }

    public function storeKomentar(Request $request, $id)
    {
        $request->validate(['isi_komentar' => 'required|string']);
        $instansi = Auth::guard('instansi')->user();

        $komentar = Komentar::create([
            'laporan_id' => $id,
            'pengguna_id' => null,
            
            // --- PERBAIKAN DI SINI JUGA ---
            'nama_pengomentar' => $instansi->instance_name, 
            // ------------------------------

            'isi_komentar' => $request->isi_komentar,
            'peran' => 'instansi',
        ]);

        return response()->json([
            'success' => true,
            'komentar' => [
                'nama' => $komentar->nama_pengomentar,
                'isi' => $komentar->isi_komentar,
                'waktu' => $komentar->created_at->diffForHumans(),
                'peran' => 'instansi'
            ]
        ]);
    }
    // ... method lainnya (selesai, dukung) tetap sama ...
    public function selesai($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->status = 'selesai';
        $laporan->save();

        Notifikasi::create([
            'pengguna_id' => $laporan->pengguna_id,
            'laporan_id' => $laporan->id,
            'judul' => 'Laporan Selesai',
            'pesan' => 'Laporan Anda telah ditandai selesai oleh instansi terkait.',
            'tipe' => 'success'
        ]);

        return redirect()->route('instansi.dashboard')->with('success', 'Laporan berhasil diselesaikan.');
    }

    public function dukung(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $sessionKey = 'liked_laporan_' . $id; 

        if ($request->session()->has($sessionKey)) {
             $laporan->decrement('jumlah_dukungan');
             $request->session()->forget($sessionKey);
             $status = 'unliked';
        } else {
             $laporan->increment('jumlah_dukungan');
             $request->session()->put($sessionKey, true);
             $status = 'liked';
        }

        return response()->json([
            'success' => true, 
            'new_count' => $laporan->jumlah_dukungan,
            'status' => $status
        ]);
    }
}