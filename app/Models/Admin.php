<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = 'admin';

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}

