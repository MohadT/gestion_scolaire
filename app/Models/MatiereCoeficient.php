<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class MatiereCoeficient extends Model
{
    use BelongsToCompany;
    protected $fillable = [
        'company_id',
        'classe_id',
        'matiere_id',
        'coefficient',
        'nombre_heure',
        'user_id',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}
