<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\Departement;

class PersonnelController extends Controller
{
    public function index()
    {
        $enseignants  = Enseignant::with(['user', 'departement'])
                                  ->get();
        $departements = Departement::all();

        return view('public.personnel', compact('enseignants', 'departements'));
    }
}