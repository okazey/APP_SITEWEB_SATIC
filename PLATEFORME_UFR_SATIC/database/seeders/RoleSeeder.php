<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        // ── Permissions ──────────────────────────────────────
        $permissions = [
            // Utilisateurs
            'voir utilisateurs',
            'creer utilisateur',
            'modifier utilisateur',
            'supprimer utilisateur',

            // Contenu
            'voir actualites',
            'creer actualite',
            'modifier actualite',
            'supprimer actualite',

            // Pages
            'voir pages',
            'creer page',
            'modifier page',
            'supprimer page',

            // Documents
            'voir documents',
            'telecharger document',
            'uploader document',
            'supprimer document',

            // Cours
            'voir cours',
            'deposer cours',
            'publier cours',
            'modifier cours',
            'archiver cours',

            // Demandes
            'soumettre demande',
            'voir demandes',
            'traiter demande',
            'valider demande',
            'rejeter demande',

            // Admin
            'acceder admin',
            'gerer roles',
            'voir statistiques',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // ── Rôles ─────────────────────────────────────────────

        // Super Admin → toutes les permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'voir utilisateurs', 'creer utilisateur', 'modifier utilisateur',
            'creer actualite', 'modifier actualite', 'supprimer actualite',
            'creer page', 'modifier page',
            'uploader document', 'supprimer document',
            'voir demandes', 'traiter demande', 'valider demande', 'rejeter demande',
            'acceder admin', 'voir statistiques',
        ]);

        // Enseignant
        $enseignant = Role::firstOrCreate(['name' => 'enseignant']);
        $enseignant->givePermissionTo([
            'voir cours', 'deposer cours', 'publier cours',
            'modifier cours', 'archiver cours',
            'voir documents', 'telecharger document',
        ]);

        // Étudiant
        $etudiant = Role::firstOrCreate(['name' => 'etudiant']);
        $etudiant->givePermissionTo([
            'voir cours',
            'telecharger document',
            'soumettre demande',
        ]);

        // PATS
        $pats = Role::firstOrCreate(['name' => 'pats']);
        $pats->givePermissionTo([
            'voir demandes', 'traiter demande',
            'valider demande', 'rejeter demande',
            'voir documents', 'uploader document',
        ]);
    }
}