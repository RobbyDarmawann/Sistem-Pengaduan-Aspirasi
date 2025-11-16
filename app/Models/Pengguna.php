<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Pastikan Anda meng-import 'Authenticatable'
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

// Pastikan Anda 'extends Authenticatable'
class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'uid';

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
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];
}