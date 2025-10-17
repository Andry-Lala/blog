<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends User
{
    use HasFactory;

    protected $table = 'users';

    /**
     * Scope a query to only include clients.
     */
    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    /**
     * Scope a query to only include verified clients.
     */
    public function scopeVerified($query)
    {
        return $query->where('statut', true);
    }

    /**
     * Scope a query to only include unverified clients.
     */
    public function scopeUnverified($query)
    {
        return $query->where('statut', false);
    }

    /**
     * Check if the client is verified.
     */
    public function isVerified(): bool
    {
        return $this->statut === true;
    }

    /**
     * Verify the client.
     */
    public function verify(): void
    {
        $this->statut = true;
        $this->save();
    }

    /**
     * Unverify the client.
     */
    public function unverify(): void
    {
        $this->statut = false;
        $this->save();
    }
}
