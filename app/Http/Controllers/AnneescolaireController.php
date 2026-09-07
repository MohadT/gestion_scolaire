<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annee_scolaire;
use App\Models\Inscription;
use Illuminate\Support\Facades\Auth;

class AnneescolaireController extends Controller
{
    public function index()
    {
        // ✅ Filtrer par utilisateur connecté
        $annee_scolaires = Annee_scolaire::query()
            ->orderBy('created_at', 'desc')
                                        ->paginate(10);
        return view('admin.annee_scolaires.index', compact('annee_scolaires'));
    }

    public function create()
    {
        return view('admin.annee_scolaires.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_annee_scolaire' => 'required|unique:annee_scolaires,nom_annee_scolaire',
        ]);

        // ✅ Ajouter user_id
        Annee_scolaire::create([
            'nom_annee_scolaire' => $request->nom_annee_scolaire,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('anneescolaire.index')
            ->with('success', 'Année scolaire créée avec succès.');
    }

    public function show(string $id)
    {
        // ✅ Vérifier que l'année appartient à l'utilisateur
        $annee_scolaire = Annee_scolaire::query()
            ->findOrFail($id);

        $inscriptions = Inscription::query()
            ->where('annee_scolaire_id', $annee_scolaire->id)
            ->with(['etudiant', 'classe'])
            ->paginate(10);

        return view('admin.annee_scolaires.show', compact('annee_scolaire', 'inscriptions'));
    }

    public function edit(string $id)
    {
        // ✅ Vérifier que l'année appartient à l'utilisateur
        $annee_scolaire = Annee_scolaire::query()
            ->findOrFail($id);
        return view('admin.annee_scolaires.edit', compact('annee_scolaire'));
    }

    public function update(Request $request, string $id)
    {
        $annee_scolaire = Annee_scolaire::query()
            ->findOrFail($id);

        $request->validate([
            'nom_annee_scolaire' => 'required|unique:annee_scolaires,nom_annee_scolaire,' . $id,
        ]);

        $annee_scolaire->update([
            'nom_annee_scolaire' => $request->nom_annee_scolaire,
        ]);

        return redirect()->route('anneescolaire.index')
            ->with('success', 'Année scolaire mise à jour avec succès.');
    }

    public function destroy(string $id)
    {
        $annee_scolaire = Annee_scolaire::query()
            ->findOrFail($id);
        $annee_scolaire->delete();

        return redirect()->route('anneescolaire.index')
            ->with('success', 'Année scolaire supprimée avec succès.');
    }
}
