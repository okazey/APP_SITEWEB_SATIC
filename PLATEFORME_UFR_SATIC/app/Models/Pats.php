<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pats extends Model
{
    use HasFactory;

    protected $table = 'pats';

    protected $fillable = [
        'user_id',
        'fonction',
        'service',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reponses()
    {
        return $this->hasMany(ReponseDemande::class);
    }
}