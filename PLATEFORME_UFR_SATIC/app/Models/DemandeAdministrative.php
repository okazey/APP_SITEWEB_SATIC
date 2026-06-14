<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeAdministrative extends Model
{
    use HasFactory;

    // ← Ligne importante : forcer le bon nom de table
    protected $table = 'demandes_administratives';

    protected $fillable = [
        'etudiant_id', 'type_demande', 'date_soumission',
        'date_traitement', 'statut', 'motif_rejet',
        'fichier_genere', 'commentaire_etudiant',
    ];

    protected $casts = [
        'date_soumission' => 'datetime',
        'date_traitement' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function reponse()
    {
        return $this->hasOne(ReponseDemande::class, 'demande_id');
    }

    public function getLibelleTypeAttribute(): string
    {
        return match($this->type_demande) {
            'attestation_inscription' => 'Attestation d\'inscription',
            'releve_notes'            => 'Relevé de notes',
            'certificat_scolarite'    => 'Certificat de scolarité',
            default                   => 'Autre demande',
        };
    }

    public function getBadgeStatutAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'warning',
            'en_cours'   => 'info',
            'validee'    => 'success',
            'rejetee'    => 'danger',
            default      => 'secondary',
        };
    }
}