<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'type',        // etudiant | enseignant | pats | administrateur
        'etat_compte', // actif | inactif | suspendu
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Nom complet
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    // Relations
    public function etudiant()
    {
        return $this->hasOne(Etudiant::class);
    }

    public function enseignant()
    {
        return $this->hasOne(Enseignant::class);
    }

    public function pats()
    {
        return $this->hasOne(Pats::class);
    }

    public function administrateur()
    {
        return $this->hasOne(Administrateur::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Helpers
    public function isEtudiant(): bool   { return $this->type === 'etudiant'; }
    public function isEnseignant(): bool { return $this->type === 'enseignant'; }
    public function isPats(): bool       { return $this->type === 'pats'; }
    public function isAdmin(): bool      { return $this->type === 'administrateur'; }
}