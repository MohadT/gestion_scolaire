<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Les champs pouvant être remplis.
     */
    protected $fillable = [
        'name',
        'identifiant',
        'email',
        'password',
        'role',
        'company_id',
    ];

    /**
     * Champs cachés.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | RELATION AVEC L'ÉTABLISSEMENT
    |--------------------------------------------------------------------------
    */

    public function company()
    {
        return $this->belongsTo(
            Company::class,
            'company_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELATION ÉTUDIANT
    |--------------------------------------------------------------------------
    */

    public function etudiants()
    {
        return $this->hasMany(
            Etudiant::class,
            'user_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENFANTS DU PARENT
    |--------------------------------------------------------------------------
    */

    public function enfants()
    {
        return $this->belongsToMany(
            Etudiant::class,
            'parent_etudiant',
            'parent_id',
            'etudiant_id'
        )
        ->withPivot('company_id')
        ->withTimestamps();
    }


    /*
    |--------------------------------------------------------------------------
    | VÉRIFIER LE RÔLE PARENT
    |--------------------------------------------------------------------------
    */

    public function isParent(): bool
    {
        return $this->role === 'parent';
    }
}
