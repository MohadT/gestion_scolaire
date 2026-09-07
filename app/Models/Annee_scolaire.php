<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Annee_scolaire extends Model
{
    use BelongsToCompany;
    protected $fillable = [
        'company_id',
        'nom_annee_scolaire', 'user_id'
    ];

    // la relation avec les inscriptions
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    // la relation avec les utilisateurs (user_id)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // la relation avec les evaluations
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    // la relation avec les emplois du temps
    public function emploi_du_temps()
    {
        return $this->hasMany(Emploidutemps::class);
    }
}
