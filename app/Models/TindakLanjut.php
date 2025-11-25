<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    use HasFactory;

    protected $table = 'tindak_lanjuts'; // Pastikan nama tabel benar (jamak)

    protected $fillable = [
        'laporan_id',
        'instansi_nama',     // <--- WAJIB ADA
        'isi_tindak_lanjut', // <--- WAJIB ADA
        'waktu_tindak_lanjut',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}