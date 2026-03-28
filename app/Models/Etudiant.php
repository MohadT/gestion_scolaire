<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = [
        'nom_etudiant',
        'prenom_etudiant',
        'address_etudiant',
        'nom_tuteur',
        'numero_tuteur'
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
