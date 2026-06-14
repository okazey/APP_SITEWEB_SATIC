<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user     = Auth::user();
        $etudiant = $user->etudiant;
        return view('etudiant.profil', compact('user', 'etudiant'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom'      => 'required|string|max:100',
            'prenom'   => 'required|string|max:100',
            'photo'    => 'nullable|image|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'nom.required'    => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'photo.image'     => 'Le fichier doit être une image.',
            'photo.max'       => 'L\'image ne doit pas dépasser 2 Mo.',
            'password.min'    => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $data = [
            'nom'    => $request->nom,
            'prenom' => $request->prenom,
        ];

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}