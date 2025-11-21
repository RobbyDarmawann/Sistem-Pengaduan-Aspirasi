<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\TindakLanjut;
use App\Models\Komentar; // <--- JANGAN LUPA IMPORT INI
use Illuminate\Support\Facades\Auth;

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

    public function verifikasi(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($request->action === 'tolak') {
            $laporan->status = 'ditolak';
            $pesan = 'Laporan berhasil ditolak.';
        } elseif ($request->action === 'setujui') {
            $laporan->status = 'diproses';
            $pesan = 'Laporan disetujui dan diteruskan ke instansi terkait.';
            $instansiTujuan = ucwords(str_replace('_', ' ', $laporan->instansi_tujuan));
            
            TindakLanjut::create([
                'laporan_id' => $laporan->id,
                'instansi_nama' => 'Admin SuaraGO', // Atau nama Instansi Pusat
                'isi_tindak_lanjut' => "Laporan telah diverifikasi dan didisposisikan ke {$instansiTujuan} untuk segera ditindaklanjuti.",
                'waktu_tindak_lanjut' => now(),
            ]);
        } else {
            return back()->with('error', 'Aksi tidak valid.');
        }

        $laporan->save();

        return redirect()->route('admin.laporan.index')->with('success', $pesan);
    }

    public function showProgres($id)
    {
        $laporan = Laporan::with(['pengguna', 'komentars', 'tindakLanjuts'])->findOrFail($id);
        $laporan->increment('jumlah_dilihat');

        return view('admin.laporan.progres', compact('laporan'));
    }

    public function selesai($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->status = 'selesai';
        $laporan->save();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan telah diselesaikan!');
    }

    public function dukung(Request $request, $id)
    {
        // 1. Ambil data laporan
        $laporan = Laporan::findOrFail($id);
        
        // 2. Tentukan key session unik untuk user & laporan ini
        $sessionKey = 'liked_laporan_' . $id;

        // 3. Logika Toggle (Cek apakah sudah ada di session)
        if ($request->session()->has($sessionKey)) {
            // KONDISI: SUDAH MENDUKUNG -> BATALKAN DUKUNGAN (UNLIKE)
            $laporan->decrement('jumlah_dukungan');
            $request->session()->forget($sessionKey); // Hapus session
            $status = 'unliked';
        } else {
            // KONDISI: BELUM MENDUKUNG -> BERIKAN DUKUNGAN (LIKE)
            $laporan->increment('jumlah_dukungan');
            $request->session()->put($sessionKey, true); // Buat session
            $status = 'liked';
        }

        // 4. Kembalikan respon JSON dengan status baru & jumlah terbaru
        return response()->json([
            'success' => true, 
            'new_count' => $laporan->jumlah_dukungan,
            'status' => $status // Kirim info status ke JS ('liked' atau 'unliked')
        ]);
    }

    public function storeKomentar(Request $request, $id)
    {
        $request->validate([
            'isi_komentar' => 'required|string|max:500',
        ]);

        $admin = Auth::guard('admin')->user();

        $komentar = Komentar::create([
            'laporan_id' => $id,
            'pengguna_id' => null, // Karena ini admin, bukan pengguna biasa
            'nama_pengomentar' => $admin->full_name, // Nama Admin
            'isi_komentar' => $request->isi_komentar,
            'peran' => 'admin', // Penanda bahwa ini komentar admin
        ]);

        // Kembalikan data komentar baru ke JavaScript
        return response()->json([
            'success' => true,
            'komentar' => [
                'nama' => $komentar->nama_pengomentar,
                'isi' => $komentar->isi_komentar,
                'waktu' => $komentar->created_at->diffForHumans(),
                'peran' => 'admin'
            ]
        ]);
    }
}