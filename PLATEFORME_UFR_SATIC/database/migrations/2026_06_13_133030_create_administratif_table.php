<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes_administratives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained()->onDelete('cascade');
            $table->enum('type_demande', [
                'attestation_inscription',
                'releve_notes',
                'certificat_scolarite',
                'autre'
            ]);
            $table->timestamp('date_soumission')->useCurrent();
            $table->timestamp('date_traitement')->nullable();
            $table->enum('statut', [
                'en_attente', 'en_cours', 'validee', 'rejetee'
            ])->default('en_attente');
            $table->text('motif_rejet')->nullable();
            $table->string('fichier_genere')->nullable();
            $table->text('commentaire_etudiant')->nullable();
            $table->timestamps();
        });

        Schema::create('reponses_demandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_id')
                  ->constrained('demandes_administratives')
                  ->onDelete('cascade');
            $table->foreignId('pats_id')->constrained('pats')->onDelete('cascade');
            $table->timestamp('date_reponse')->useCurrent();
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->timestamp('date_envoi')->useCurrent();
            $table->boolean('lu')->default(false);
            $table->enum('type', ['info', 'succes', 'alerte', 'erreur'])->default('info');
            $table->string('lien')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('reponses_demandes');
        Schema::dropIfExists('demandes_administratives');
    }
};