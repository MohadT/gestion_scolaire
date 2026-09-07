<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use BelongsToCompany;
    protected $fillable = [
        'company_id',
        'etudiant_id',
        'evaluation_id',
        'note',
        'appreciation',
        'user_id',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
