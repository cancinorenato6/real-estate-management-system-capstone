<?php

namespace App\Models;

use App\Models\Agent;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'offer_type',
        'property_type',
        'title',
        'description',
        'price',
        'images',
        'province',
        'city',
        'barangay',
        'latitude',      // Add this
        'longitude',
    ];

    protected $casts = [
        'images' => 'array',
        'archived' => 'boolean',// Automatically cast images JSON to array
    ];

        public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    // public function favoredBy()
    // {
    //     return $this->belongsToMany(Client::class, 'favorites')->withTimestamps();
    // }

    public function favoredBy(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'favorites', 'property_id', 'client_id')->withTimestamps();
    }
    

 

}
