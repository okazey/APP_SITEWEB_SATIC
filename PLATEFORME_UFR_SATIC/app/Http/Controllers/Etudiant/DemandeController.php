<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\DemandeAdministrative;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    public function index()
    {
        $etudiant = Auth::user()->etudiant;

        $demandes = $etudiant
            ? $etudiant->demandes()->latest()->paginate(10)
            : collect();

        return view('etudiant.demandes', compact('demandes'));
    }

    public function create()
    {
        return view('etudiant.demandes-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_demande'        => 'required|in:attestation_inscription,releve_notes,certificat_scolarite,autre',
            'commentaire_etudiant' => 'nullable|string|max:500',
        ], [
            'type_demande.required' => 'Veuillez choisir un type de demande.',
            'type_demande.in'       => 'Type de demande invalide.',
        ]);

        $etudiant = Auth::user()->etudiant;

        if (!$etudiant) {
            return back()->with('error', 'Profil étudiant introuvable.');
        }

        DemandeAdministrative::create([
            'etudiant_id'          => $etudiant->id,
            'type_demande'         => $request->type_demande,
            'commentaire_etudiant' => $request->commentaire_etudiant,
            'statut'               => 'en_attente',
            'date_soumission'      => now(),
        ]);

        // Notification
        Notification::create([
            'user_id'    => Auth::id(),
            'message'    => 'Votre demande de ' . $this->libelleType($request->type_demande) . ' a été soumise avec succès.',
            'type'       => 'succes',
            'date_envoi' => now(),
        ]);

        return redirect()->route('etudiant.demandes')
                         ->with('success', 'Votre demande a été soumise avec succès.');
    }

    public function show(int $id)
    {
        $etudiant = Auth::user()->etudiant;
        $demande  = DemandeAdministrative::where('etudiant_id', $etudiant->id)
                                         ->with('reponse.pats.user')
                                         ->findOrFail($id);

        return view('etudiant.demande-detail', compact('demande'));
    }

    private function libelleType(string $type): string
    {
        return match($type) {
            'attestation_inscription' => 'attestation d\'inscription',
            'releve_notes'            => 'relevé de notes',
            'certificat_scolarite'    => 'certificat de scolarité',
            default                   => 'document administratif',
        };
    }
}