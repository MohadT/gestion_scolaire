<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use BelongsToCompany;
    protected $fillable = [
        'company_id',
        'nom_classe','effectif','prix','user_id'
    ];



    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
