<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'code_utilisateur',
        'adresse',
        'email',
        'telephone',
        'username',
        'password',
        'role',
        'statut',
        'date_naissance',
        'lieu_naissance',
        'nationalite',
        'profession',
        'piece_identite',
        'numero_piece',
        'date_delivrance',
        'lieu_delivrance',
        'notes',
        'date_validation',
        'valide_par',
        'theme',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'statut' => 'boolean',
            'date_naissance' => 'date',
            'date_delivrance' => 'date',
            'date_validation' => 'datetime',
        ];
    }

    /**
     * Get the investments for the user.
     */
    public function investments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Investment::class);
    }

    /**
     * Check if user is admin.
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->role === 'administrateur';
    }

    /**
     * Get the user who validated this client.
     */
    public function validatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    /**
     * Get the clients validated by this user.
     */
    public function validatedClients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'valide_par');
    }
}
