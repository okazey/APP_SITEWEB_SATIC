<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Actualite;

class ActualiteController extends Controller
{
    public function index()
    {
        $actualites = Actualite::where('statut', 'publie')
                               ->latest('date_publication')
                               ->paginate(9);
        return view('public.actualites', compact('actualites'));
    }

    public function show(string $slug)
    {
        $actualite = Actualite::where('slug', $slug)
                              ->where('statut', 'publie')
                              ->firstOrFail();

        $recentes = Actualite::where('statut', 'publie')
                             ->where('id', '!=', $actualite->id)
                             ->latest('date_publication')
                             ->take(3)
                             ->get();

        return view('public.actualite-detail', compact('actualite', 'recentes'));
    }
}