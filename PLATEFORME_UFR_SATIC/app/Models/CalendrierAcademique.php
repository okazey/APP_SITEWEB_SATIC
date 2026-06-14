<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendrierAcademique extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id', 'titre',
        'date_debut', 'date_fin', 'type',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function evenements()
    {
        return $this->hasMany(Evenement::class);
    }
}