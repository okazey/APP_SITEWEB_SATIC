<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'departement_id',
        'grade',
        'specialite',
        'biographie',
        'domaine_recherche',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'enseignant_formation');
    }

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}