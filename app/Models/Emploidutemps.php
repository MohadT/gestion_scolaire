<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Emploidutemps extends Model
{
    use BelongsToCompany;
    protected $fillable = [
        'company_id',
        'annee_scolaire_id',
        'classe_id',
        'prof_id',
        'matiere_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'user_id',
    ];


    /**
     * Année scolaire
     */
    public function anneeScolaire()
    {
        return $this->belongsTo(
            Annee_scolaire::class,
            'annee_scolaire_id'
        );
    }


    /**
     * Classe
     */
    public function classe()
    {
        return $this->belongsTo(
            Classe::class,
            'classe_id'
        );
    }


    /**
     * Professeur
     */
    public function professeur()
    {
        return $this->belongsTo(
            Professeur::class,
            'prof_id'
        );
    }


    /**
     * Matière
     */
    public function matiere()
    {
        return $this->belongsTo(
            Matiere::class,
            'matiere_id'
        );
    }


    /**
     * Utilisateur propriétaire
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
