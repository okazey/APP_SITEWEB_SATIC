<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actualites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auteur_id')->constrained('users')->onDelete('cascade');
            $table->string('titre');
            $table->string('slug')->unique();
            $table->longText('contenu');
            $table->string('image')->nullable();
            $table->string('categorie')->nullable();
            $table->enum('statut', ['brouillon', 'publie'])->default('brouillon');
            $table->timestamp('date_publication')->nullable();
            $table->boolean('en_une')->default(false);
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->enum('type', [
                'guide_lmd', 'charte_examens',
                'calendrier', 'formulaire', 'autre'
            ]);
            $table->string('fichier');
            $table->string('categorie')->nullable();
            $table->timestamp('date_publication')->nullable();
            $table->boolean('publie')->default(true);
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('slug')->unique();
            $table->longText('contenu')->nullable();
            $table->boolean('publie')->default(false);
            $table->string('menu')->nullable();
            $table->timestamps();
        });

        Schema::create('partenaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('logo')->nullable();
            $table->string('site_web')->nullable();
            $table->enum('type', ['academique', 'institutionnel', 'entreprise'])
                  ->default('academique');
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email');
            $table->string('sujet');
            $table->text('message');
            $table->boolean('lu')->default(false);
            $table->boolean('repondu')->default(false);
            $table->timestamps();
        });

        Schema::create('questions_faq', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('reponse');
            $table->enum('categorie', [
                'general', 'inscription', 'examens',
                'documents', 'formations', 'autre'
            ])->default('general');
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions_faq');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('partenaires');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('actualites');
    }
};