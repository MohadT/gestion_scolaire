<?php

namespace App\Models;

use App\Models\Emploidutemps;
use App\Models\User;
use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    use BelongsToCompany;
    protected $fillable = [
        'company_id',
        'nom_prof',
        'prenom_prof',
        'addresse',
        'telephone',
        'profession',
        'user_id',
    ];

    /**
     * Emplois du temps du professeur
     */
    public function emploisDuTemps()
    {
        return $this->hasMany(
            Emploidutemps::class,
            'prof_id'
        );
    }

    /**
     * Utilisateur propriétaire
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
