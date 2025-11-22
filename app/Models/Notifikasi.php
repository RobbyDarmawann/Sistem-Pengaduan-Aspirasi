<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengguna_id', 'laporan_id', 'judul', 'pesan', 'tipe', 'is_read'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}