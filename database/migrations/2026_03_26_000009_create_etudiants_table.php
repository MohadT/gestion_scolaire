<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('code_etudiant')->nullable()->unique();
            $table->unsignedBigInteger('company_id')->nullable()->index();
            $table->string('photo')->nullable();
            $table->string('nom_etudiant');
            $table->string('prenom_etudiant');
            $table->string('adresse_etudiant');
            $table->string('nom_du_tuteur');
            $table->string('numero_du_tuteur');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
