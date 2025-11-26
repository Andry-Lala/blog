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

    /**
     * Get the total amount of all validated investments for the client.
     */
    public function getTotalInvestmentsAttribute(): float
    {
        return $this->investments()
            ->where('status', 'Validé')
            ->sum('amount');
    }

    /**
     * Get the total amount of all investments (regardless of status) for the client.
     */
    public function getAllInvestmentsAttribute(): float
    {
        return $this->investments()->sum('amount');
    }

    /**
     * Get the count of validated investments for the client.
     */
    public function getValidatedInvestmentsCountAttribute(): int
    {
        return $this->investments()
            ->where('status', 'Validé')
            ->count();
    }

    /**
     * Get the count of all investments for the client.
     */
    public function getAllInvestmentsCountAttribute(): int
    {
        return $this->investments()->count();
    }
}
