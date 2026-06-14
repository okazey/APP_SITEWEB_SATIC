<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploiDuTemps extends Model
{
    use HasFactory;

    protected $table = 'emplois_du_temps';

    protected $fillable = [
        'formation_id', 'departement_id', 'semestre',
        'niveau', 'annee_academique', 'fichier_pdf', 'date_publication',
    ];

    protected $casts = [
        'date_publication' => 'datetime',
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
}