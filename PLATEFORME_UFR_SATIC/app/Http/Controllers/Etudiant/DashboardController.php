<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user     = Auth::user();
        $etudiant = $user->etudiant;

        $totalCours = 0;
        $demandesEnAttente = 0;
        $demandesValidees  = 0;
        $notifications     = 0;

        if ($etudiant) {
            $totalCours = \App\Models\Cours::where('formation_id', $etudiant->formation_id)
                                           ->where('statut', 'publie')
                                           ->count();

            $demandesEnAttente = $etudiant->demandes()
                                          ->where('statut', 'en_attente')
                                          ->count();

            $demandesValidees  = $etudiant->demandes()
                                          ->where('statut', 'validee')
                                          ->count();
        }

        $notifications = $user->notifications()->where('lu', false)->count();

        $derniersCours = $etudiant
            ? \App\Models\Cours::where('formation_id', $etudiant->formation_id)
                               ->where('statut', 'publie')
                               ->latest()
                               ->take(5)
                               ->get()
            : collect();

        $dernieresNotifs = $user->notifications()
                                ->latest()
                                ->take(5)
                                ->get();

        return view('etudiant.dashboard', compact(
            'etudiant',
            'totalCours',
            'demandesEnAttente',
            'demandesValidees',
            'notifications',
            'derniersCours',
            'dernieresNotifs'
        ));
    }
}