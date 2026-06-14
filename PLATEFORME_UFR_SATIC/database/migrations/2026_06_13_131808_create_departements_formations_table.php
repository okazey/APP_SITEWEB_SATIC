<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departement_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('slug')->unique();
            $table->enum('niveau', ['Licence', 'Master', 'Doctorat']);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
        Schema::dropIfExists('departements');
    }
};