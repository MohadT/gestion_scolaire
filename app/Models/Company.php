<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'address',
        'city',
        'country',
        'phone',
        'email',
        'website',
        'tax_id',
        'registration_number',
        'logo',
        'footer_text',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
