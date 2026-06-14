<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user      = Auth::user();
        $enseignant = $user->enseignant;

        $totalCours    = 0;
        $coursPublies  = 0;
        $coursArchives = 0;
        $coursBrouillon = 0;
        $derniersCours  = collect();

        if ($enseignant) {
            $totalCours     = Cours::where('enseignant_id', $enseignant->id)->count();
            $coursPublies   = Cours::where('enseignant_id', $enseignant->id)->where('statut', 'publie')->count();
            $coursArchives  = Cours::where('enseignant_id', $enseignant->id)->where('statut', 'archive')->count();
            $coursBrouillon = Cours::where('enseignant_id', $enseignant->id)->where('statut', 'brouillon')->count();
            $derniersCours  = Cours::where('enseignant_id', $enseignant->id)
                                   ->with('formation')
                                   ->latest()
                                   ->take(5)
                                   ->get();
        }

        return view('enseignant.dashboard', compact(
            'enseignant',
            'totalCours',
            'coursPublies',
            'coursArchives',
            'coursBrouillon',
            'derniersCours'
        ));
    }
}