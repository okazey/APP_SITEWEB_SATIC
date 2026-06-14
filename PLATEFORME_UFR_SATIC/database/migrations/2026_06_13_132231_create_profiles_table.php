<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('formation_id')->constrained()->onDelete('restrict');
            $table->string('matricule')->unique();
            $table->enum('niveau', ['L1', 'L2', 'L3', 'M1', 'M2']);
            $table->timestamps();
        });

        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('departement_id')->constrained()->onDelete('restrict');
            $table->enum('grade', [
                'Professeur',
                'Maître de conférences',
                'Assistant',
                'Vacataire'
            ]);
            $table->string('specialite')->nullable();
            $table->text('biographie')->nullable();
            $table->string('domaine_recherche')->nullable();
            $table->timestamps();
        });

        Schema::create('pats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('fonction');
            $table->string('service');
            $table->timestamps();
        });

        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('niveau_admin', [
                'super_admin',
                'admin',
                'moderateur'
            ])->default('admin');
            $table->timestamps();
        });

        Schema::create('enseignant_formation', function (Blueprint $table) {
            $table->foreignId('enseignant_id')->constrained()->onDelete('cascade');
            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
            $table->primary(['enseignant_id', 'formation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enseignant_formation');
        Schema::dropIfExists('administrateurs');
        Schema::dropIfExists('pats');
        Schema::dropIfExists('enseignants');
        Schema::dropIfExists('etudiants');
    }
};