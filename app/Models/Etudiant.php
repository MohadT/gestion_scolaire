<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use BelongsToCompany;
    protected $fillable = [
        'company_id',
        'code_etudiant',
        'photo',
        'nom_etudiant',
        'prenom_etudiant',
        'adresse_etudiant',
        'nom_du_tuteur',
        'numero_du_tuteur',
        'user_id',
    ];


    /**
     * Inscriptions de l'étudiant
     */
    public function inscriptions()
    {
        return $this->hasMany(
            Inscription::class,
            'etudiant_id'
        );
    }


    /**
     * Classes de l'étudiant
     *
     * Relation via la table inscriptions.
     */
    public function classes()
    {
        return $this->belongsToMany(
            Classe::class,
            'inscriptions',
            'etudiant_id',
            'classe_id'
        )
        ->withTimestamps();
    }


    /**
     * Notes de l'étudiant
     */
    public function notes()
    {
        return $this->hasMany(
            Note::class,
            'etudiant_id'
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

    /**
     * Comptes parents rattachés à cet étudiant.
     */
    public function parents()
    {
        return $this->belongsToMany(
            User::class,
            'parent_etudiant',
            'etudiant_id',
            'parent_id'
        )->withPivot('company_id')->withTimestamps();
    }
}
