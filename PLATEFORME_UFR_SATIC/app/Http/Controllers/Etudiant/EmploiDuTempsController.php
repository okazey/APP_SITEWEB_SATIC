<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\EmploiDuTemps;
use Illuminate\Support\Facades\Auth;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $etudiant = Auth::user()->etudiant;

        $emplois = $etudiant
            ? EmploiDuTemps::where('formation_id', $etudiant->formation_id)
                           ->latest()
                           ->get()
            : collect();

        return view('etudiant.emploi-du-temps', compact('emplois', 'etudiant'));
    }
}