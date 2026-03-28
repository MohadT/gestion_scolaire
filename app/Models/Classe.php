<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = [
        'nom_classe',
    ];

    public function etudiants()
    {
        return $this->hasMany(etudiant::class);
    }
}
