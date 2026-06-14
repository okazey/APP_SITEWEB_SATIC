<?php

namespace App\Http\Controllers\Pats;

use App\Http\Controllers\Controller;
use App\Models\DemandeAdministrative;
use App\Models\Notification;
use App\Models\ReponseDemande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DemandeController extends Controller
{
    public function index()
    {
        $statut    = request('statut', '');
        $recherche = request('recherche', '');

        $demandes = DemandeAdministrative::with('etudiant.user')
            ->when($statut, fn($q) => $q->where('statut', $statut))
            ->when($recherche, function ($q) use ($recherche) {
                $q->whereHas('etudiant.user', function ($q2) use ($recherche) {
                    $q2->where('nom', 'like', "%$recherche%")
                       ->orWhere('prenom', 'like', "%$recherche%");
                })->orWhereHas('etudiant', function ($q2) use ($recherche) {
                    $q2->where('matricule', 'like', "%$recherche%");
                });
            })
            ->latest()
            ->paginate(15);

        return view('pats.demandes', compact('demandes', 'statut', 'recherche'));
    }

    public function show(int $id)
    {
        $demande = DemandeAdministrative::with([
            'etudiant.user',
            'etudiant.formation',
            'reponse.pats.user',
        ])->findOrFail($id);

        return view('pats.demande-detail', compact('demande'));
    }

    public function traiter(int $id)
    {
        $demande = DemandeAdministrative::findOrFail($id);

        $demande->update([
            'statut'          => 'en_cours',
            'date_traitement' => now(),
        ]);

        // Notifier l'étudiant
        Notification::create([
            'user_id'    => $demande->etudiant->user_id,
            'message'    => 'Votre demande de ' . $demande->libelle_type . ' est en cours de traitement.',
            'type'       => 'info',
            'date_envoi' => now(),
        ]);

        return back()->with('success', 'Demande prise en charge.');
    }

    public function valider(Request $request, int $id)
    {
        $request->validate([
            'commentaire' => 'nullable|string|max:500',
        ]);

        $demande = DemandeAdministrative::findOrFail($id);
        $pats    = Auth::user()->pats;

        $demande->update([
            'statut'          => 'validee',
            'date_traitement' => now(),
        ]);

        ReponseDemande::updateOrCreate(
            ['demande_id' => $demande->id],
            [
                'pats_id'      => $pats->id,
                'commentaire'  => $request->commentaire ?? 'Demande validée.',
                'date_reponse' => now(),
            ]
        );

        // Notifier l'étudiant
        Notification::create([
            'user_id'    => $demande->etudiant->user_id,
            'message'    => 'Votre demande de ' . $demande->libelle_type . ' a été validée. Vous pouvez la télécharger.',
            'type'       => 'succes',
            'date_envoi' => now(),
        ]);

        return back()->with('success', 'Demande validée avec succès.');
    }

    public function rejeter(Request $request, int $id)
    {
        $request->validate([
            'motif_rejet' => 'required|string|max:500',
        ], [
            'motif_rejet.required' => 'Le motif de rejet est obligatoire.',
        ]);

        $demande = DemandeAdministrative::findOrFail($id);
        $pats    = Auth::user()->pats;

        $demande->update([
            'statut'          => 'rejetee',
            'motif_rejet'     => $request->motif_rejet,
            'date_traitement' => now(),
        ]);

        ReponseDemande::updateOrCreate(
            ['demande_id' => $demande->id],
            [
                'pats_id'      => $pats->id,
                'commentaire'  => 'Demande rejetée : ' . $request->motif_rejet,
                'date_reponse' => now(),
            ]
        );

        // Notifier l'étudiant
        Notification::create([
            'user_id'    => $demande->etudiant->user_id,
            'message'    => 'Votre demande de ' . $demande->libelle_type . ' a été rejetée. Motif : ' . $request->motif_rejet,
            'type'       => 'alerte',
            'date_envoi' => now(),
        ]);

        return back()->with('success', 'Demande rejetée.');
    }

    public function genererPdf(int $id)
    {
        $demande = DemandeAdministrative::with([
            'etudiant.user',
            'etudiant.formation.departement',
        ])->findOrFail($id);

        if ($demande->statut !== 'validee') {
            return back()->with('error', 'Seules les demandes validées peuvent être générées en PDF.');
        }

        $pdf = Pdf::loadView('pats.pdf.' . str_replace('_', '-', $demande->type_demande), [
            'demande' => $demande,
        ]);

        $filename = $demande->type_demande . '_' . $demande->etudiant->matricule . '.pdf';

        // Sauvegarder le fichier généré
        $path = 'documents/' . $filename;
        \Storage::disk('public')->put($path, $pdf->output());

        $demande->update(['fichier_genere' => $path]);

        return $pdf->download($filename);
    }
}