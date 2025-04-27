<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Agent extends Authenticatable
{
    use Notifiable;

    protected $guard = 'agent';

    protected $fillable = [
        'prc_id',
        'name',
        'age',
        'birthday',
        'contactno',  
        'address', 
        'email',
        'profile_pic',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    
}
