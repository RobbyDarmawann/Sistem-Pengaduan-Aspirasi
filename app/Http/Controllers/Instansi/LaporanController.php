<?php

namespace App\Http\Controllers\Instansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\TindakLanjut;
use App\Models\Komentar;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use App\Models\Dukungan;

class LaporanController extends Controller
{
    public function show($id)
    {
        $laporan = Laporan::with(['pengguna', 'komentars', 'tindakLanjuts'])->findOrFail($id);
        $instansi = Auth::guard('instansi')->user();

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
        TindakLanjut::create([
            'laporan_id' => $id,
            
            'instansi_nama' => $instansi->instance_name, 

            'isi_tindak_lanjut' => $request->isi_tindak_lanjut,
            'waktu_tindak_lanjut' => now(),
        ]);

        Notifikasi::create([
            'pengguna_id' => $laporan->pengguna_id,
            'laporan_id' => $laporan->id,
            'judul' => 'Tindak Lanjut Baru',
            'pesan' => $instansi->instance_name . ' telah memberikan update terbaru mengenai laporan Anda.',
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
            'nama_pengomentar' => $instansi->instance_name, 
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
        $user = Auth::guard('instansi')->user(); // Ambil Instansi yang login

        // Cek Database
        $existingDukungan = Dukungan::where('laporan_id', $id)
            ->where('user_id', $user->gid) // Pakai ID Instansi (gid)
            ->where('user_type', 'instansi')
            ->first();

        if ($existingDukungan) {
            // UNLIKE
            $existingDukungan->delete();
            $laporan->decrement('jumlah_dukungan');
            $status = 'unliked';
        } else {
            // LIKE
            Dukungan::create([
                'laporan_id' => $id,
                'user_id' => $user->gid, // ID Instansi
                'user_type' => 'instansi'
            ]);
            $laporan->increment('jumlah_dukungan');
            $status = 'liked';
        }

        return response()->json(['success' => true, 'new_count' => $laporan->jumlah_dukungan, 'status' => $status]);
    }
}