<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

class PublicLaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Query Dasar: HANYA Publik dan Anonim (Rahasia TIDAK diambil)
        // Dan statusnya bukan 'ditolak' (opsional, biasanya yang ditolak tidak ditampilkan)
        $query = Laporan::with('pengguna')
            ->whereIn('visibilitas', ['publik', 'anonim'])
            ->where('status', '!=', 'ditolak');

        // 2. Filter Pencarian (Search Bar)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi_laporan', 'like', "%{$search}%");
            });
        }

        // 3. Filter Tipe (Pengaduan/Aspirasi)
        if ($request->has('tipe') && $request->tipe != 'all') {
            $query->where('tipe_laporan', $request->tipe);
        }

        // 4. Filter Instansi
        if ($request->has('instansi') && $request->instansi != 'all') {
            $query->where('instansi_tujuan', $request->instansi);
        }

        // Urutkan terbaru dan Paginate
        $laporans = $query->latest()->paginate(9)->withQueryString(); // withQueryString agar filter tidak hilang saat ganti halaman

        // Daftar Instansi untuk Dropdown Filter
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

        return view('laporan.public_index', compact('laporans', 'listInstansi'));
    }
}