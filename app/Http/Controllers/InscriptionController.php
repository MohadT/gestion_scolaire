<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Etudiant;
use App\Models\Annee_scolaire;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Liste des inscriptions de l'utilisateur connecté
       $inscriptions = Inscription::query()
            ->with(['etudiant', 'classe', 'anneeScolaire'])  // ✅ Charger anneeScolaire
        ->orderBy('created_at', 'desc')
        ->paginate(10);


        return view('admin.inscriptions.index', compact('inscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
        public function create($etudiant_id = null)
        {
            $etudiants = Etudiant::query()
            ->orderBy('nom_etudiant')
                                ->get();

            $classes = Classe::query()
            ->orderBy('nom_classe')
                            ->get();

            // ✅ Récupérer l'étudiant si ID passé en paramètre
            $selectedEtudiant = null;
            if ($etudiant_id) {
                $selectedEtudiant = Etudiant::query()
            ->find($etudiant_id);
            }

            $annee_scolaires = Annee_scolaire::query()
            ->orderBy('nom_annee_scolaire', 'desc')
                                        ->get();

            // ✅ Passer $selectedEtudiant à la vue
            return view('admin.inscriptions.create',
                compact('etudiants', 'classes', 'selectedEtudiant', 'annee_scolaires'));
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'frais_scolarite' => 'nullable|numeric|min:0',
        ]);

        // ✅ Vérifier si l'étudiant est déjà inscrit pour cette année
        $dejaInscrit = Inscription::query()
            ->where('etudiant_id', $validatedData['etudiant_id'])
            ->where('annee_scolaire_id', $validatedData['annee_scolaire_id'])
            ->exists();

        if ($dejaInscrit) {
            return back()
                ->withInput()
                ->with('error', 'Cet étudiant est déjà inscrit pour cette année scolaire.');
        }

        // ✅ Vérifier l'effectif de la classe
        $classe = Classe::query()
            ->findOrFail($validatedData['classe_id']);

        $nombreInscrits = Inscription::where('classe_id', $classe->id)
            ->where('annee_scolaire_id', $validatedData['annee_scolaire_id'])
            ->count();

        if ($nombreInscrits >= $classe->effectif) {
            return back()
                ->withInput()
                ->with('error', 'La classe "' . $classe->nom_classe . '" a atteint son effectif maximum de ' . $classe->effectif . ' élèves.');
        }

        // Ajouter user_id
        $validatedData['company_id'] = Auth::user()->company_id;
        $validatedData['user_id'] = Auth::id();

        // Création de l'inscription
        Inscription::create($validatedData);

        return redirect()
            ->route('inscriptions.index')
            ->with('success', 'Inscription créée avec succès.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Afficher les détails d'une inscription
        $inscription = Inscription::query()
            ->with(['etudiant', 'classe'])
                                 ->findOrFail($id);

        return view('admin.inscriptions.show', compact('inscription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Formulaire de modification (vérifier que l'inscription appartient à l'utilisateur)
        $inscription = Inscription::query()
            ->findOrFail($id);

        // Récupérer les données pour les selects
        $etudiants = Etudiant::query()->get();
        $classes = Classe::query()->get();

        return view('admin.inscriptions.edit', compact('inscription', 'etudiants', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, string $id)
{
    // Validation des données
    $validatedData = $request->validate([
        'etudiant_id' => 'required|exists:etudiants,id',
        'classe_id' => 'required|exists:classes,id',
        'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
        'frais_scolarite' => 'nullable|numeric|min:0',  // ✅ nullable
    ]);

    // Recherche de l'inscription appartenant à l'utilisateur
    $inscription = Inscription::query()
            ->findOrFail($id);

    // ✅ Ajouter user_id (sécurité)
    $validatedData['company_id'] = Auth::user()->company_id;
        $validatedData['user_id'] = Auth::id();

    // Mise à jour
    $inscription->update($validatedData);

    return redirect()
        ->route('inscriptions.index')
        ->with('success', 'Inscription modifiée avec succès.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Suppression (vérifier que l'inscription appartient à l'utilisateur)
        $inscription = Inscription::query()
            ->findOrFail($id);
        $inscription->delete();

        return redirect()
            ->route('inscriptions.index')
            ->with('success', 'Inscription supprimée avec succès.');
    }


    public function paiement($id)
{
    $inscription = Inscription::with([
        'etudiant',
        'classe',
        'anneeScolaire'
    ])->findOrFail($id);

    $total = $inscription->classe->prix ?? 0;
    $paye = $inscription->frais_scolarite ?? 0;
    $reste = max(0, $total - $paye);

    return view('admin.inscriptions.paiement', compact(
        'inscription',
        'total',
        'paye',
        'reste'
    ));
}

public function enregistrerPaiement(Request $request, $id)
{
    $inscription = Inscription::with(['classe', 'etudiant', 'anneeScolaire'])
        ->findOrFail($id);

    $total = $inscription->classe->prix ?? 0;
    $paye = $inscription->frais_scolarite ?? 0;
    $reste = max(0, $total - $paye);

    $validated = $request->validate([
        'montant' => 'required|numeric|min:1',
        'date_paiement' => 'required|date',
        'mode_paiement' => 'required|in:especes,virement,cheque,mobile_money,autre',
    ]);

    $montant = $validated['montant'];

    if ($montant > $reste) {
        return back()
            ->withInput()
            ->with('error', 'Le montant saisi est supérieur au reste à payer.');
    }

    $nouveauMontant = $paye + $montant;

    $inscription->update([
        'frais_scolarite' => $nouveauMontant,
        'company_id' => Auth::user()->company_id,
        'user_id' => Auth::id(),
    ]);

    return redirect()
        ->route('inscriptions.index')
        ->with(
            'success',
            'Paiement de ' . number_format($montant, 0, ',', ' ') .
            ' FCFA enregistré avec succès pour ' .
            $inscription->etudiant->prenom_etudiant . ' ' .
            $inscription->etudiant->nom_etudiant . '.'
        );
}


}
