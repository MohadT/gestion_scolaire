<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable()->index();
            $table->foreignId('etudiant_id')->constrained()->onDelete('cascade');
            $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onDelete('cascade');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('frais_scolarite', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
