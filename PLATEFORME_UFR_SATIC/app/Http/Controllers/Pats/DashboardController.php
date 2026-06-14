<?php

namespace App\Http\Controllers\Pats;

use App\Http\Controllers\Controller;
use App\Models\DemandeAdministrative;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pats = $user->pats;

        $totalDemandes    = DemandeAdministrative::count();
        $enAttente        = DemandeAdministrative::where('statut', 'en_attente')->count();
        $enCours          = DemandeAdministrative::where('statut', 'en_cours')->count();
        $validees         = DemandeAdministrative::where('statut', 'validee')->count();
        $rejetees         = DemandeAdministrative::where('statut', 'rejetee')->count();

        $dernieresDemandes = DemandeAdministrative::with('etudiant.user')
                                                  ->latest()
                                                  ->take(8)
                                                  ->get();

        return view('pats.dashboard', compact(
            'pats',
            'totalDemandes',
            'enAttente',
            'enCours',
            'validees',
            'rejetees',
            'dernieresDemandes'
        ));
    }
}