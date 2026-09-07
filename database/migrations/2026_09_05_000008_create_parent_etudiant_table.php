<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parent_etudiant', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('parent_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('etudiant_id')
                ->constrained('etudiants')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(
                ['parent_id', 'etudiant_id'],
                'parent_etudiant_unique'
            );

            $table->index(
                ['company_id', 'parent_id']
            );

            $table->index(
                ['company_id', 'etudiant_id']
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_etudiant');
    }
};
