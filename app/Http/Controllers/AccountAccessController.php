<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Professeur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountAccessController extends Controller
{
    public function professorForm(Professeur $professeur)
    {
        return view('admin.accounts.professor', compact('professeur'));
    }

    public function professorStore(Request $request, Professeur $professeur)
    {
        $data = $request->validate([
            'identifiant' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        abort_unless($professeur->company_id === Auth::user()->company_id, 403);

        $user = User::create([
            'company_id' => Auth::user()->company_id,
            'identifiant' => $data['identifiant'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'professeur',
        ]);

        $professeur->update(['user_id' => $user->id]);

        return redirect()->route('professeurs.show', $professeur)
            ->with('success', 'Accès professeur créé.');
    }

    public function studentForm(Etudiant $etudiant)
    {
        return view('admin.accounts.student', compact('etudiant'));
    }

    public function studentStore(Request $request, Etudiant $etudiant)
    {
        $data = $request->validate([
            'identifiant' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        abort_unless($etudiant->company_id === Auth::user()->company_id, 403);

        $user = User::create([
            'company_id' => Auth::user()->company_id,
            'identifiant' => $data['identifiant'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'etudiant',
        ]);

        $etudiant->update(['user_id' => $user->id]);

        return redirect()->route('etudiants.show', $etudiant)
            ->with('success', 'Accès étudiant créé.');
    }
}
