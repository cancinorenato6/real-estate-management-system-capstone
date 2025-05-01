<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Property;

class Client extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_number',
        'username',
        'password',
        'profile_pic'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}