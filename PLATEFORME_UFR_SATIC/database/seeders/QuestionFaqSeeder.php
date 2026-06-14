<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuestionFaq;

class QuestionFaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question'  => 'Comment s\'inscrire à l\'UFR SATIC ?',
                'reponse'   => 'Les inscriptions se font en ligne sur le portail CAMPUSEN ou directement à la scolarité entre juillet et septembre.',
                'categorie' => 'inscription',
            ],
            [
                'question'  => 'Quels sont les départements de l\'UFR SATIC ?',
                'reponse'   => 'L\'UFR SATIC comprend 4 départements : TIC, Mathématiques, Physique et Chimie.',
                'categorie' => 'general',
            ],
            [
                'question'  => 'Comment obtenir mon attestation d\'inscription ?',
                'reponse'   => 'Connectez-vous à votre espace étudiant, allez dans Demandes administratives et sélectionnez Attestation d\'inscription.',
                'categorie' => 'documents',
            ],
            [
                'question'  => 'Où trouver l\'emploi du temps ?',
                'reponse'   => 'Les emplois du temps sont disponibles dans votre espace étudiant, section Emploi du temps.',
                'categorie' => 'general',
            ],
            [
                'question'  => 'Quand ont lieu les examens ?',
                'reponse'   => 'Le calendrier des examens est publié dans la section Calendrier académique de votre espace étudiant.',
                'categorie' => 'examens',
            ],
            [
                'question'  => 'Comment contacter la scolarité ?',
                'reponse'   => 'Vous pouvez contacter la scolarité via le formulaire de contact du portail ou vous rendre directement au bureau de la scolarité.',
                'categorie' => 'general',
            ],
        ];

        foreach ($faqs as $faq) {
            QuestionFaq::create($faq);
        }
    }
}