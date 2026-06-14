<?php

namespace App\Http\Controllers\Pats;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pats = $user->pats;
        return view('pats.profil', compact('user', 'pats'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom'      => 'required|string|max:100',
            'prenom'   => 'required|string|max:100',
            'photo'    => 'nullable|image|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = [
            'nom'    => $request->nom,
            'prenom' => $request->prenom,
        ];

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($user->pats) {
            $user->pats->update([
                'fonction' => $request->fonction,
                'service'  => $request->service,
            ]);
        }

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}