<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'User'; 
    protected $primaryKey = 'userid';
    
    public $timestamps = false; 

    protected $fillable = [
        'password_hash',
        'role',
        'login_key',
        'is_active',
        'referend_id',
    ];

    protected $hidden = [
        'password_hash',
    ];
}
