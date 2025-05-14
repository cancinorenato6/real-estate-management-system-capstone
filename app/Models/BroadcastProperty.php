<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BroadcastProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'description',
        'status',
        'claimed_by_agent_id',
        'claimed_at',
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'claimed_by_agent_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'broadcast_id');
    }

    // Check if the broadcast is open (not claimed)
    public function isOpen()
    {
        return $this->status === 'open';
    }

    // Claim the broadcast by an agent
    public function claim($agent_id)
    {
        if ($this->isOpen()) {
            $this->update([
                'status' => 'claimed',
                'claimed_by_agent_id' => $agent_id,
                'claimed_at' => now(),
            ]);
            return true;
        }
        return false;
    }
}