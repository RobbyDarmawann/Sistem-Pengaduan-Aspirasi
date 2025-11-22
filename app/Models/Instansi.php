<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Instansi extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'instansi'; // Sesuai migrasi Anda
    protected $primaryKey = 'gid'; // Sesuai migrasi Anda
    
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'email',
        'phone_number',
        'nip',
        'instance_name', // <--- INI KUNCINYA (Harus sama dengan dropdown di form laporan)
        'address',
        // Kolom count bisa diisi nanti atau dihitung otomatis
    ];

    protected $hidden = [
        'password',
    ];
}