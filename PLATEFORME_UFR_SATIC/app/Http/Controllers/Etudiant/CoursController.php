<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CoursController extends Controller
{
    public function index()
    {
        $etudiant = Auth::user()->etudiant;

        $cours = $etudiant
            ? Cours::where('formation_id', $etudiant->formation_id)
                   ->where('statut', 'publie')
                   ->with('enseignant.user')
                   ->latest()
                   ->paginate(12)
            : collect();

        return view('etudiant.cours', compact('cours', 'etudiant'));
    }

     public function telecharger(int $id)
{
    $etudiant = Auth::user()->etudiant;
    $cours    = Cours::findOrFail($id);

    if (!$cours->fichier) {
        return back()->with('error', 'Aucun fichier disponible pour ce cours.');
    }

    $path = storage_path('app/public/' . $cours->fichier);

    if (!file_exists($path)) {
        return back()->with('error', 'Le fichier est introuvable sur le serveur.');
    }

    return response()->download($path, $cours->titre . '.pdf');
}
}