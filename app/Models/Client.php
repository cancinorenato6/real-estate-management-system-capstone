<?php

namespace App\Models;

use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



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

    //     public function favorites()
    // {
    //     return $this->belongsToMany(Property::class, 'favorites')->withTimestamps();
    // }

    //     public function favorites()
    // {
    //     return $this->belongsToMany(Property::class, 'client_property', 'client_id', 'property_id');
    // }

    // public function favorites(): BelongsToMany
    // {
    //     return $this->belongsToMany(Property::class, 'client_property', 'client_id', 'property_id');
    // }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'favorites', 'client_id', 'property_id')->withTimestamps();
    }


}