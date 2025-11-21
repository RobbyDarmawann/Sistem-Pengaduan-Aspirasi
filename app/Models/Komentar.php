<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentars'; // Nama tabel (opsional jika sudah plural)

    // INI YANG WAJIB ADA
    protected $fillable = [
        'laporan_id',
        'pengguna_id',
        'nama_pengomentar',
        'isi_komentar',
        'peran',
    ];

    // Relasi balik ke laporan (opsional tapi bagus ada)
    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}