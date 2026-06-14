<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Pats;
use App\Models\Administrateur;
use App\Models\Formation;
use App\Models\Departement;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $formation   = Formation::where('slug', 'd2a')->first();
        $departement = Departement::where('slug', 'tic')->first();

        // ── Super Administrateur ──────────────────────────────
        $superAdmin = User::create([
            'nom'         => 'Administrateur',
            'prenom'      => 'Super',
            'email'       => 'admin@uadb.edu.sn',
            'password'    => Hash::make('Admin@2024'),
            'type'        => 'administrateur',
            'etat_compte' => 'actif',
        ]);
        Administrateur::create([
            'user_id'      => $superAdmin->id,
            'niveau_admin' => 'super_admin',
        ]);
        $superAdmin->assignRole('super_admin');

        // ── Enseignant ────────────────────────────────────────
        $userEns = User::create([
            'nom'         => 'Diallo',
            'prenom'      => 'Moussa',
            'email'       => 'm.diallo@uadb.edu.sn',
            'password'    => Hash::make('Enseignant@2024'),
            'type'        => 'enseignant',
            'etat_compte' => 'actif',
        ]);
        Enseignant::create([
            'user_id'           => $userEns->id,
            'departement_id'    => $departement->id,
            'grade'             => 'Maître de conférences',
            'specialite'        => 'Génie Logiciel',
            'domaine_recherche' => 'Intelligence Artificielle',
        ]);
        $userEns->assignRole('enseignant');

        // ── PATS ──────────────────────────────────────────────
        $userPats = User::create([
            'nom'         => 'Ndiaye',
            'prenom'      => 'Fatou',
            'email'       => 'f.ndiaye@uadb.edu.sn',
            'password'    => Hash::make('Pats@2024'),
            'type'        => 'pats',
            'etat_compte' => 'actif',
        ]);
        Pats::create([
            'user_id'  => $userPats->id,
            'fonction' => 'Chef de scolarité',
            'service'  => 'Scolarité',
        ]);
        $userPats->assignRole('pats');

        // ── Étudiant ──────────────────────────────────────────
        $userEtu = User::create([
            'nom'         => 'Sow',
            'prenom'      => 'Ibrahima',
            'email'       => 'i.sow@etudiant.uadb.edu.sn',
            'password'    => Hash::make('Etudiant@2024'),
            'type'        => 'etudiant',
            'etat_compte' => 'actif',
        ]);
        Etudiant::create([
            'user_id'      => $userEtu->id,
            'formation_id' => $formation->id,
            'matricule'    => 'UADB-2024-001',
            'niveau'       => 'L2',
        ]);
        $userEtu->assignRole('etudiant');
    }
}