<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'departement_id',
        'nom',
        'slug',
        'niveau',
        'description',
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function enseignants()
    {
        return $this->belongsToMany(Enseignant::class, 'enseignant_formation');
    }

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }

    public function emploisDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    public function calendriers()
    {
        return $this->hasMany(CalendrierAcademique::class);
    }
}