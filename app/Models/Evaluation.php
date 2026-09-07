<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use BelongsToCompany;
    protected $fillable = [
        'company_id',

        'matiere_id',

        'classe_id',

        'professeur_id',

        'annee_scolaire_id',

        'nom_evaluation',

        'type_evaluation',

        'user_id',

    ];


    public function matiere()
    {
        return $this->belongsTo(
            Matiere::class
        );
    }


    public function classe()
    {
        return $this->belongsTo(
            Classe::class
        );
    }


    public function professeur()
    {
        return $this->belongsTo(
            Professeur::class,
            'professeur_id'
        );
    }


    public function anneeScolaire()
    {
        return $this->belongsTo(
            Annee_scolaire::class,
            'annee_scolaire_id'
        );
    }


    public function notes()
    {
        return $this->hasMany(
            Note::class
        );
    }


    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }
}
