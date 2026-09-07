<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Professeur;
use App\Models\Inscription;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;

class SecretaryPortalController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;
        $totalEtudiants = Etudiant::where('company_id', $companyId)->count();
        $totalProfesseurs = Professeur::where('company_id', $companyId)->count();
        $totalClasses = Classe::where('company_id', $companyId)->count();
        $totalInscriptions = Inscription::where('company_id', $companyId)->count();
        return view('portal.secretary.index', compact('totalEtudiants','totalProfesseurs','totalClasses','totalInscriptions'));
    }
}
