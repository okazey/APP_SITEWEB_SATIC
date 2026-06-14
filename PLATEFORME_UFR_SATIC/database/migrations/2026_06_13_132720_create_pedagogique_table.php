<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enseignant_id')->constrained()->onDelete('cascade');
            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('niveau')->nullable();
            $table->string('semestre')->nullable();
            $table->string('fichier')->nullable();
            $table->enum('statut', ['brouillon', 'publie', 'archive'])->default('brouillon');
            $table->timestamp('date_depot')->nullable();
            $table->timestamp('date_publication')->nullable();
            $table->timestamps();
        });

        Schema::create('emplois_du_temps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
            $table->foreignId('departement_id')->constrained()->onDelete('cascade');
            $table->string('semestre');
            $table->string('niveau');
            $table->string('annee_academique');
            $table->string('fichier_pdf')->nullable();
            $table->timestamp('date_publication')->nullable();
            $table->timestamps();
        });

        Schema::create('calendriers_academiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('type', ['cours', 'examens', 'conges', 'soutenances', 'autre']);
            $table->timestamps();
        });

        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calendrier_academique_id')
                  ->constrained('calendriers_academiques')
                  ->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->dateTime('date_evenement');
            $table->string('lieu')->nullable();
            $table->enum('statut', ['planifie', 'en_cours', 'termine', 'annule'])
                  ->default('planifie');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evenements');
        Schema::dropIfExists('calendriers_academiques');
        Schema::dropIfExists('emplois_du_temps');
        Schema::dropIfExists('cours');
    }
};