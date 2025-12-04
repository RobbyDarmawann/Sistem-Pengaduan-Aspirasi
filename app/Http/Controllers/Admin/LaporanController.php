<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\TindakLanjut; 
use App\Models\Komentar;     
use App\Models\Dukungan;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with('pengguna');

        // Filter Tipe
        if ($request->filled('tipe') && $request->tipe != 'all') {
            $query->where('tipe_laporan', $request->tipe);
        }

        // Filter Status
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter Instansi
        if ($request->filled('instansi') && $request->instansi != 'all') {
            $query->where('instansi_tujuan', $request->instansi);
        }

        // Custom Ordering
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

        $query->latest();

        $laporan = $query->paginate(10);

        // List Instansi (Bisa dipindah ke config atau database nanti)
        $listInstansi = [
            "Pemerintah Provinsi Gorontalo",
            "Pemerintah Kota Gorontalo",
            "Pemerintah Kecamatan Kota Barat, Kota Gorontalo",
            "Pemerintah Kecamatan Dungingi, Kota Gorontalo",
            "Pemerintah Kecamatan Kota Selatan, Kota Gorontalo",
            "Pemerintah Kecamatan Kota Timur, Kota Gorontalo",
            "Pemerintah Kecamatan Kota Utara, Kota Gorontalo",
            "Pemerintah Kecamatan Hulonthalangi, Kota Gorontalo",
            "Pemerintah Kabupaten Gorontalo",
            "Pemerintah Kecamatan Asparaga, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Batudaa, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Batudaa Pantai, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Bilato, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Biluhu, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Boliyohuto, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Bongomeme, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Dungaliyo, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Limboto, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Limboto Barat, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Mootilango, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Pulubala, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Tabongo, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Talaga Jaya, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Telaga, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Telaga Biru, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Tibawa, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Tilango, Kabupaten Gorontalo",
            "Pemerintah Kecamatan Tolangohula, Kabupaten Gorontalo"
        ];

        return view('admin.laporan.index', compact('laporan', 'listInstansi'));
    }

    public function show($id)
    {
        $laporan = Laporan::with('pengguna')->findOrFail($id);
        return view('admin.laporan.show', compact('laporan'));
    }

    // --- FUNGSI VERIFIKASI (YANG ERROR) ---
    public function verifikasi(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($request->action === 'tolak') {
            $laporan->status = 'ditolak';
            $pesan = 'Laporan berhasil ditolak.';
        } elseif ($request->action === 'setujui') {
            $laporan->status = 'diproses';
            $pesan = 'Laporan disetujui dan diteruskan ke instansi terkait.';
            
            // Format Nama Instansi
            $instansiTujuan = ucwords(str_replace('_', ' ', $laporan->instansi_tujuan));
            
            // Buat Tindak Lanjut Otomatis
            // PASTIKAN MODEL TindakLanjut SUDAH DI-IMPORT DI ATAS
            TindakLanjut::create([
                'laporan_id' => $laporan->id,
                'instansi_nama' => 'Admin SuaraGO', 
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
        $laporan = Laporan::findOrFail($id);
        $user = Auth::guard('admin')->user(); // Ambil Admin yang login

        // Cek apakah sudah ada data di database
        $existingDukungan = Dukungan::where('laporan_id', $id)
            ->where('user_id', $user->aid) // Pakai ID Admin (aid)
            ->where('user_type', 'admin')
            ->first();

        if ($existingDukungan) {
            // KONDISI: SUDAH ADA -> HAPUS (UNLIKE)
            $existingDukungan->delete();
            $laporan->decrement('jumlah_dukungan');
            $status = 'unliked';
        } else {
            // KONDISI: BELUM ADA -> BUAT BARU (LIKE)
            Dukungan::create([
                'laporan_id' => $id,
                'user_id' => $user->aid, // ID Admin
                'user_type' => 'admin'
            ]);
            $laporan->increment('jumlah_dukungan');
            $status = 'liked';
        }

        return response()->json([
            'success' => true, 
            'new_count' => $laporan->jumlah_dukungan,
            'status' => $status
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
            'pengguna_id' => null, 
            'nama_pengomentar' => $admin->full_name,
            'isi_komentar' => $request->isi_komentar,
            'peran' => 'admin', 
        ]);

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