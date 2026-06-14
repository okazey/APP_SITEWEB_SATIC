<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionFaq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question', 'reponse', 'categorie', 'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];
}