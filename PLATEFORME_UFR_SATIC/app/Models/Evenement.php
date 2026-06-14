<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendrier_academique_id', 'titre',
        'description', 'date_evenement', 'lieu', 'statut',
    ];

    protected $casts = [
        'date_evenement' => 'datetime',
    ];

    public function calendrier()
    {
        return $this->belongsTo(CalendrierAcademique::class);
    }
}