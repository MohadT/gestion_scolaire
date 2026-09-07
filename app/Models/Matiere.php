<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use BelongsToCompany;
    protected $fillable = [
        'company_id',
        'nom_matiere',
   
        'user_id',
    ];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function emploidutemps()
    {
        return $this->hasMany(Emploidutemps::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
