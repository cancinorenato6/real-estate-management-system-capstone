<?php

namespace App\Models;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'images' => 'array', // Automatically cast images JSON to array
    ];

    public function agent()
{
    return $this->belongsTo(Agent::class);
}
}
