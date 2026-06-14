<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Departement;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::with('formations')->get();
        return view('public.departements', compact('departements'));
    }

    public function show(string $slug)
    {
        $departement = Departement::with(['formations', 'enseignants.user'])
                                  ->where('slug', $slug)
                                  ->firstOrFail();
        return view('public.departement-detail', compact('departement'));
    }
}