<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    
    // --- PERUBAHAN DI SINI ---
    // Kita hapus semua referensi ke 'uid'
    // Laravel akan otomatis menggunakan 'id' sebagai Primary Key
    protected $primaryKey = 'id'; 
    public $incrementing = true; // Kembali ke default
    protected $keyType = 'int';   // Kembali ke default
    // --- AKHIR PERUBAHAN ---

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'gender',
        'email',
        'birthday',
        'phone_number',
        'nik',
        'job',
        'domicile',
        'address',
        'report_count',
        'aspiration_count',
        'birth_place',      // <-- PASTIKAN INI ADA
        'profile_photo_path', // <-- WAJIB ADA
        'cover_photo_path',   // <-- WAJIB ADA
        'show_aspirasi',      // <-- WAJIB ADA
        'show_pengaduan',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];
}