<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReponseDemande extends Model
{
    use HasFactory;

    protected $table = 'reponses_demandes';

    protected $fillable = [
        'demande_id', 'pats_id',
        'date_reponse', 'commentaire',
    ];

    protected $casts = [
        'date_reponse' => 'datetime',
    ];

    public function demande()
    {
        return $this->belongsTo(DemandeAdministrative::class);
    }

    public function pats()
    {
        return $this->belongsTo(Pats::class);
    }
}