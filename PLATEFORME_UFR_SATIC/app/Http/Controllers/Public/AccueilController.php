<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use App\Models\Departement;
use App\Models\Partenaire;

class AccueilController extends Controller
{
    public function index()
    {
        $actualites  = Actualite::where('statut', 'publie')
                                ->latest('date_publication')
                                ->take(3)
                                ->get();

        $departements = Departement::with('formations')->get();
        $partenaires  = Partenaire::where('actif', true)->get();

        return view('public.accueil', compact(
            'actualites',
            'departements',
            'partenaires'
        ));
    }
}