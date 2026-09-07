<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use BelongsToCompany;
    protected $fillable = [
        'company_id',
        'etudiant_id',
        'classe_id',
        'annee_scolaire_id',
        'frais_scolarite',
        'user_id',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(Annee_scolaire::class, 'annee_scolaire_id');
    }
}
