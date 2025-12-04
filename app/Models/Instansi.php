<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Instansi extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'instansi';
    protected $primaryKey = 'gid'; 
    
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'email',
        'phone_number',
        'nip',
        'instance_name', 
        'address',
    ];

    protected $hidden = [
        'password',
    ];
}