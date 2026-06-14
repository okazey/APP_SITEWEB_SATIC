<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CoursController extends Controller
{
    public function index()
    {
        $enseignant = Auth::user()->enseignant;

        $cours = $enseignant
            ? Cours::where('enseignant_id', $enseignant->id)
                   ->with('formation')
                   ->latest()
                   ->paginate(12)
            : collect();

        return view('enseignant.cours', compact('cours'));
    }

    public function create()
    {
        $enseignant = Auth::user()->enseignant;
        $formations = $enseignant
            ? $enseignant->formations
            : Formation::all();

        if ($formations->isEmpty()) {
            $formations = Formation::all();
        }

        return view('enseignant.cours-create', compact('formations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'        => 'required|string|max:255',
            'formation_id' => 'required|exists:formations,id',
            'description'  => 'nullable|string',
            'niveau'       => 'nullable|string|max:50',
            'semestre'     => 'nullable|string|max:50',
            'fichier'      => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:20480',
        ], [
            'titre.required'        => 'Le titre est obligatoire.',
            'formation_id.required' => 'Veuillez choisir une formation.',
            'fichier.mimes'         => 'Le fichier doit être PDF, Word ou PowerPoint.',
            'fichier.max'           => 'Le fichier ne doit pas dépasser 20 Mo.',
        ]);

        $enseignant = Auth::user()->enseignant;
        $fichier    = null;

        if ($request->hasFile('fichier')) {
            $fichier = $request->file('fichier')
                               ->store('cours', 'public');
        }

        Cours::create([
            'enseignant_id' => $enseignant->id,
            'formation_id'  => $request->formation_id,
            'titre'         => $request->titre,
            'description'   => $request->description,
            'niveau'        => $request->niveau,
            'semestre'      => $request->semestre,
            'fichier'       => $fichier,
            'statut'        => 'brouillon',
            'date_depot'    => now(),
        ]);

        return redirect()->route('enseignant.cours')
                         ->with('success', 'Cours déposé avec succès.');
    }

    public function edit(int $id)
    {
        $enseignant = Auth::user()->enseignant;
        $cours      = Cours::where('enseignant_id', $enseignant->id)
                           ->findOrFail($id);
        $formations = Formation::all();

        return view('enseignant.cours-edit', compact('cours', 'formations'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'titre'        => 'required|string|max:255',
            'formation_id' => 'required|exists:formations,id',
            'description'  => 'nullable|string',
            'niveau'       => 'nullable|string|max:50',
            'semestre'     => 'nullable|string|max:50',
            'fichier'      => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:20480',
        ]);

        $enseignant = Auth::user()->enseignant;
        $cours      = Cours::where('enseignant_id', $enseignant->id)
                           ->findOrFail($id);

        $data = [
            'formation_id' => $request->formation_id,
            'titre'        => $request->titre,
            'description'  => $request->description,
            'niveau'       => $request->niveau,
            'semestre'     => $request->semestre,
        ];

        if ($request->hasFile('fichier')) {
            if ($cours->fichier) {
                Storage::disk('public')->delete($cours->fichier);
            }
            $data['fichier'] = $request->file('fichier')
                                       ->store('cours', 'public');
        }

        $cours->update($data);

        return redirect()->route('enseignant.cours')
                         ->with('success', 'Cours mis à jour avec succès.');
    }

    public function publier(int $id)
    {
        $enseignant = Auth::user()->enseignant;
        $cours      = Cours::where('enseignant_id', $enseignant->id)
                           ->findOrFail($id);

        $cours->update([
            'statut'           => 'publie',
            'date_publication' => now(),
        ]);

        return back()->with('success', 'Cours publié avec succès.');
    }

    public function archiver(int $id)
    {
        $enseignant = Auth::user()->enseignant;
        $cours      = Cours::where('enseignant_id', $enseignant->id)
                           ->findOrFail($id);

        $cours->update(['statut' => 'archive']);

        return back()->with('success', 'Cours archivé.');
    }

    public function destroy(int $id)
    {
        $enseignant = Auth::user()->enseignant;
        $cours      = Cours::where('enseignant_id', $enseignant->id)
                           ->findOrFail($id);

        if ($cours->fichier) {
            Storage::disk('public')->delete($cours->fichier);
        }

        $cours->delete();

        return back()->with('success', 'Cours supprimé.');
    }
}