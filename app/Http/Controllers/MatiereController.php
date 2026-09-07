<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matiere;
use Illuminate\Support\Facades\Auth;

class MatiereController extends Controller
{
    /**
     * Afficher la liste des matières
     * appartenant uniquement à l'utilisateur connecté.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $matieres = Matiere::query()
            
            ->when($search, function ($query, $search) {
                $query->where(
                    'nom_matiere',
                    'like',
                    '%' . $search . '%'
                );
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.matieres.index',
            compact('matieres')
        );
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('admin.matieres.create');
    }

    /**
     * Enregistrer une nouvelle matière.
     */
   public function store(Request $request)
{
    $validatedData = $request->validate([
        'nom_matiere' => [
            'required',
            'array',
            'min:1',
        ],

        'nom_matiere.*' => [
            'required',
            'string',
            'max:255',
        ],
    ]);


    foreach ($validatedData['nom_matiere'] as $nomMatiere) {

        Matiere::create([
            'nom_matiere' => trim($nomMatiere),
            'user_id' => Auth::id(),
        ]);

    }


    return redirect()
        ->route('matieres.index')
        ->with(
            'success',
            'Les matières ont été ajoutées avec succès.'
        );
}

    /**
     * Afficher les détails d'une matière.
     */
    public function show(string $id)
    {
        $matiere = Matiere::query()
            ->findOrFail($id);

        return view(
            'admin.matieres.show',
            compact('matiere')
        );
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(string $id)
    {
        $matiere = Matiere::query()
            ->findOrFail($id);

        return view(
            'admin.matieres.edit',
            compact('matiere')
        );
    }

    /**
     * Mettre à jour une matière.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nom_matiere' => 'required|string|max:255',
        ]);

        // Sécurité SaaS :
        // on ne récupère que les matières du compte connecté.
        $matiere = Matiere::query()
            ->findOrFail($id);

        $matiere->update($validatedData);

        return redirect()
            ->route('matieres.index')
            ->with('success', 'Matière modifiée avec succès.');
    }

    /**
     * Supprimer une matière.
     */
    public function destroy(string $id)
    {
        // Sécurité SaaS.
        $matiere = Matiere::query()
            ->findOrFail($id);

        $matiere->delete();

        return redirect()
            ->route('matieres.index')
            ->with('success', 'Matière supprimée avec succès.');
    }
}
