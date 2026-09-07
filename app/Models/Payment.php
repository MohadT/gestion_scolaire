<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'inscription_id',
        'user_id',
        'amount',
        'paid_at',
        'method',
        'reference',
        'note',
    ];

    protected $casts = [
        'paid_at' => 'date',
        'amount' => 'decimal:2',
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
