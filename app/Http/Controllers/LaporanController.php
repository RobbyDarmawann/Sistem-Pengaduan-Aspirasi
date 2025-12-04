<?php

namespace App\Http\Controllers; // <--- Perhatikan Namespace ini (Tanpa \Instansi)
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Komentar;
use App\Models\Dukungan;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Menampilkan form buat laporan.
     */
    public function create($tipe = 'pengaduan')
    {
        return view('laporan.create', [
            'tipe' => $tipe
        ]);
    }

    /**
     * Menyimpan laporan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'kategori' => 'required|string',
            'instansi_tujuan' => 'required|string',
            'tipe_laporan' => 'required|in:pengaduan,aspirasi',
            'visibilitas' => 'required',
            'lampiran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal_kejadian' => 'nullable|date',
            'lokasi_kejadian' => 'nullable|string',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran-laporan', 'public');
        }

        Laporan::create([
            'pengguna_id' => Auth::id(),
            'tipe_laporan' => $request->tipe_laporan,
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'lokasi_kejadian' => $request->lokasi_kejadian,
            'kategori' => $request->kategori,
            'instansi_tujuan' => $request->instansi_tujuan,
            'visibilitas' => $request->visibilitas,
            'status' => 'belum_disetujui',
            'lampiran' => $lampiranPath,
        ]);

        return redirect('/')->with('success', 'Laporan Anda berhasil dikirim dan menunggu verifikasi.');
    }

    public function show($id)
    {
        $laporan = Laporan::with(['pengguna', 'komentars', 'tindakLanjuts'])->findOrFail($id);
        
        // Tambah jumlah dilihat setiap kali dibuka
        $laporan->increment('jumlah_dilihat');

        return view('laporan.show', compact('laporan'));
    }

    // Method KIRIM KOMENTAR
    public function storeKomentar(Request $request, $id)
    {
        $request->validate(['isi_komentar' => 'required|string|max:500']);

        $user = Auth::user();

        $komentar = Komentar::create([
            'laporan_id' => $id,
            'pengguna_id' => $user->id, // ID Pengguna yang login
            'nama_pengomentar' => $user->full_name,
            'isi_komentar' => $request->isi_komentar,
            'peran' => 'pengguna', // Penanda peran
        ]);

        return response()->json([
            'success' => true,
            'komentar' => [
                'nama' => $komentar->nama_pengomentar,
                'isi' => $komentar->isi_komentar,
                'waktu' => $komentar->created_at->diffForHumans(),
                'peran' => 'pengguna',
                // Kirim URL foto profil untuk JS
                'foto' => $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('assets/images/profil-pengguna.jpg')
            ]
        ]);
    }
    public function storeTindakLanjut(Request $request, $id)
    {
        $request->validate(['isi_tindak_lanjut' => 'required|string']);

        $laporan = Laporan::findOrFail($id);
        
        // Pastikan yang mengisi adalah pemilik laporan
        if ($laporan->pengguna_id != Auth::id()) {
            abort(403, 'Anda tidak berhak menanggapi laporan ini.');
        }

        TindakLanjut::create([
            'laporan_id' => $id,
            // Kita beri label khusus agar beda dengan Instansi
            'instansi_nama' => 'Tanggapan Pelapor', 
            'isi_tindak_lanjut' => $request->isi_tindak_lanjut,
            'waktu_tindak_lanjut' => now(),
        ]);

        return back()->with('success', 'Tanggapan tindak lanjut berhasil dikirim.');
    }
    // Method DUKUNG (Sama seperti Admin/Instansi tapi pakai Auth user)
    public function dukung(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $user = Auth::user();

        $existingDukungan = Dukungan::where('laporan_id', $id)
            ->where('user_id', $user->id)
            ->where('user_type', 'pengguna')
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
                'user_id' => $user->id,
                'user_type' => 'pengguna'
            ]);
            $laporan->increment('jumlah_dukungan');
            $status = 'liked';
        }

        return response()->json(['success' => true, 'new_count' => $laporan->jumlah_dukungan, 'status' => $status]);
    }
}