<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partenaire;

class PartenaireSeeder extends Seeder
{
    public function run(): void
    {
        $partenaires = [
            [
                'nom'      => 'Université Cheikh Anta Diop (UCAD)',
                'type'     => 'academique',
                'site_web' => 'https://ucad.sn',
                'actif'    => true,
            ],
            [
                'nom'      => 'Agence Universitaire de la Francophonie',
                'type'     => 'institutionnel',
                'site_web' => 'https://www.auf.org',
                'actif'    => true,
            ],
            [
                'nom'      => 'Sonatel',
                'type'     => 'entreprise',
                'site_web' => 'https://www.sonatel.sn',
                'actif'    => true,
            ],
            [
                'nom'      => 'Université Gaston Berger (UGB)',
                'type'     => 'academique',
                'site_web' => 'https://ugb.edu.sn',
                'actif'    => true,
            ],
        ];

        foreach ($partenaires as $p) {
            Partenaire::create($p);
        }
    }
}