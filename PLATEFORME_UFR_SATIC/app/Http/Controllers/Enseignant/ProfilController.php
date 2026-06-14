<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user       = Auth::user();
        $enseignant = $user->enseignant;
        return view('enseignant.profil', compact('user', 'enseignant'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom'               => 'required|string|max:100',
            'prenom'            => 'required|string|max:100',
            'photo'             => 'nullable|image|max:2048',
            'password'          => 'nullable|min:8|confirmed',
            'grade'             => 'nullable|string',
            'specialite'        => 'nullable|string|max:200',
            'biographie'        => 'nullable|string',
            'domaine_recherche' => 'nullable|string|max:200',
        ]);

        $data = [
            'nom'    => $request->nom,
            'prenom' => $request->prenom,
        ];

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')
                                     ->store('photos', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($user->enseignant) {
            $user->enseignant->update([
                'grade'             => $request->grade,
                'specialite'        => $request->specialite,
                'biographie'        => $request->biographie,
                'domaine_recherche' => $request->domaine_recherche,
            ]);
        }

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}