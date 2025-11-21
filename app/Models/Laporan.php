<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'pengguna_id',
        'tipe_laporan',
        'judul',
        'isi_laporan',
        'tanggal_kejadian',
        'lokasi_kejadian',
        'kategori',
        'instansi_tujuan',
        'status',
        'visibilitas',
        'lampiran',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
    ];

    /**
     * Relasi: Setiap Laporan dimiliki oleh satu Pengguna
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}