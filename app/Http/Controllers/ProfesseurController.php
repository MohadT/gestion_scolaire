<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfesseurController extends Controller
{
    private function companyId(): int
    {
        return (int) Auth::user()->company_id;
    }

    public function index(Request $request)
    {
        $professeurs = Professeur::where('company_id', $this->companyId())
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($q) use ($search) {
                    $q->where('nom_prof', 'like', "%$search%")
                      ->orWhere('prenom_prof', 'like', "%$search%")
                      ->orWhere('telephone', 'like', "%$search%");
                });
            })->latest()->paginate(10)->withQueryString();

        return view('admin.professeurs.index', compact('professeurs'));
    }

    public function create() { return view('admin.professeurs.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_prof' => 'required|string|max:255',
            'prenom_prof' => 'required|string|max:255',
            'addresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:30',
            'profession' => 'required|string|max:255',
            'identifiant' => 'required|string|max:255|unique:users,identifiant',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $companyId = $this->companyId();

        DB::transaction(function () use ($data, $companyId) {
            $user = User::create([
                'company_id' => $companyId,
                'identifiant' => $data['identifiant'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'professeur',
            ]);

            Professeur::create([
                'company_id' => $companyId,
                'user_id' => $user->id,
                'nom_prof' => $data['nom_prof'],
                'prenom_prof' => $data['prenom_prof'],
                'addresse' => $data['addresse'],
                'telephone' => $data['telephone'],
                'profession' => $data['profession'],
            ]);
        });

        return redirect()->route('professeurs.index')->with('success', 'Professeur et compte de connexion créés avec succès.');
    }

    public function show(string $id)
    {
        $professeur = Professeur::where('company_id', $this->companyId())->findOrFail($id);
        return view('admin.professeurs.show', compact('professeur'));
    }

    public function edit(string $id)
    {
        $professeur = Professeur::where('company_id', $this->companyId())->findOrFail($id);
        return view('admin.professeurs.edit', compact('professeur'));
    }

    public function update(Request $request, string $id)
    {
        $professeur = Professeur::where('company_id', $this->companyId())->findOrFail($id);
        $data = $request->validate([
            'nom_prof' => 'required|string|max:255',
            'prenom_prof' => 'required|string|max:255',
            'addresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:30',
            'profession' => 'required|string|max:255',
        ]);
        $professeur->update($data);
        return redirect()->route('professeurs.show', $professeur)->with('success', 'Professeur modifié avec succès.');
    }

    public function destroy(string $id)
    {
        $professeur = Professeur::where('company_id', $this->companyId())->findOrFail($id);
        $professeur->delete();
        return redirect()->route('professeurs.index')->with('success', 'Professeur supprimé avec succès.');
    }
}
