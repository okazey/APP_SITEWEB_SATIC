<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    use HasFactory;

    protected $fillable = [
        'auteur_id', 'titre', 'slug', 'contenu',
        'image', 'categorie', 'statut',
        'date_publication', 'en_une',
    ];

    protected $casts = [
        'date_publication' => 'datetime',
        'en_une'           => 'boolean',
    ];

    public function auteur()
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }

    public function scopePublie($query)
    {
        return $query->where('statut', 'publie');
    }
}