<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    use HasFactory;

    protected $table = 'tindak_lanjuts';

    // WAJIB ADA AGAR BISA DISIMPAN OTOMATIS
    protected $fillable = [
        'laporan_id',
        'instansi_nama',     // Contoh: Pemerintah Kota Gorontalo
        'isi_tindak_lanjut', // Contoh: Laporan didisposisikan ke...
        'waktu_tindak_lanjut',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}