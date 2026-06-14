<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departement;
use App\Models\Formation;

class DepartementSeeder extends Seeder
{
    public function run(): void
    {
        // Département TIC
        $tic = Departement::create([
            'nom'         => 'Département TIC',
            'slug'        => 'tic',
            'description' => 'Technologies de l\'Information et de la Communication',
        ]);

        Formation::create([
            'departement_id' => $tic->id,
            'nom'            => 'D2A – Développement d\'Applications et Administration ',
            'slug'           => 'd2a',
            'niveau'         => 'Licence',
            'description'    => 'Formation en développement logiciel et applications web',
        ]);

        Formation::create([
            'departement_id' => $tic->id,
            'nom'            => 'SRT – Systèmes et Réseaux Télécommunications',
            'slug'           => 'srt',
            'niveau'         => 'Licence',
            'description'    => 'Formation en réseaux et télécommunications',
        ]);

        // Département Mathématiques
        $maths = Departement::create([
            'nom'         => 'Département Mathématiques',
            'slug'        => 'mathematiques',
            'description' => 'Sciences Mathématiques et Informatiques',
        ]);

        Formation::create([
            'departement_id' => $maths->id,
            'nom'            => 'MPCI – Maths, Physique, Chimie, Informatique',
            'slug'           => 'mpci',
            'niveau'         => 'Licence',
            'description'    => 'Formation pluridisciplinaire sciences fondamentales',
        ]);

        // Département Physique
        Departement::create([
            'nom'         => 'Département Physique',
            'slug'        => 'physique',
            'description' => 'Sciences Physiques',
        ]);

        // Département Chimie
        Departement::create([
            'nom'         => 'Département Chimie',
            'slug'        => 'chimie',
            'description' => 'Sciences Chimiques',
        ]);
    }
}