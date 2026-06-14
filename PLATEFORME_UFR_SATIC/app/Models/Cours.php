<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = [
        'enseignant_id', 'formation_id', 'titre',
        'description', 'niveau', 'semestre',
        'fichier', 'statut', 'date_depot', 'date_publication',
    ];

    protected $casts = [
        'date_depot'       => 'datetime',
        'date_publication' => 'datetime',
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function scopePublie($query)
    {
        return $query->where('statut', 'publie');
    }
}